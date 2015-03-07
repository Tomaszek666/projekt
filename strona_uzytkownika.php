<?php
//require_once "C:/xampp/smarty/libs/Smarty.class.php";
require_once "model/model_baza.php";
require_once "view/view.php";
require_once "controller/controller.php";
require_once "controller/funkcje_zdjecia.php";
require_once "templates/body.php";
session_start();

$html = new cialo(); 
$pobieranie_akcji = new control();
$formularze = new view();
$wysw = new main();
$obrobka_zdjecia = new obrobka_zdj();
/*$smarty = new Smarty;
$smarty->template_dir = 'C:/xampp/htdocs/smarty/templates';
$smarty->config_dir = 'C:/xampp/htdocs/smarty/config';
$smarty->cache_dir = 'C:/xampp/smarty/cache';
$smarty->compile_dir = 'C:/xampp/smarty/templates_c';
$smarty->assign("title", "Przyklad zastosowania Smarty");   */


// $smarty->assign("uzytkownik", $wysw->wysw_uzyt());
$html->wyswietl_header();
$html->wyswietl_body();
if(isset($_SESSION['prawid_uzyt'])){

//echo '<br />Jestes zalogowany jako: '.$_SESSION['prawid_uzyt'].'<br />';
echo '<div class="panel_uzyt_tytul"><h2>To jest Twoj panel zarzadzania zdjeciami i filmami</h2></div>';
//$formularze->wyswietl_form_wylog();
$spr8 ="zdjecia_profilowe/zdj_".$_SESSION['prawid_uzyt'].".jpg";  
if(file_exists($spr8)){
echo '<div class="zdj_profi"><img src="zdjecia_profilowe/zdj_'.$_SESSION['prawid_uzyt'].'.jpg"/></div><br />';
}else{
echo '<div class="zdj_profi"><img src="zdjecia_profilowe/zdj_profilowe.jpg"/></div><br />';}
//echo 'dodaj nowe zdjecie :';
$formularze->wyswietl_form_dodawania_zdj_profi();
$formularze->wyswietl_form_dodawania_zdj();
$formularze->wyswietl_form_dod_filmow();

$obrobka_zdjecia->wyswietlanie_tylko_zdjec_uzytkownika($_SESSION['prawid_uzyt']);

}else{
$formularze->wyswietl_form_log();}

//$smarty->assign("popularnosc_zdj", $wysw->wysw_pop_zdj());
//$smarty->assign("popularnosc", $wysw->wysw_pop_uzyt());
//$smarty->display('templates/index.tpl');
$html->wyswietl_footer();
?>