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
//$smarty = new Smarty;
//$smarty->template_dir = 'C:/xampp/htdocs/smarty/templates';
//$smarty->config_dir = 'C:/xampp/htdocs/smarty/config';
//$smarty->cache_dir = 'C:/xampp/smarty/cache';
//$smarty->compile_dir = 'C:/xampp/smarty/templates_c';
//$smarty->assign("title", "Przyklad zastosowania Smarty");


// $smarty->assign("uzytkownik", $wysw->wysw_uzyt());
$html->wyswietl_header();
echo "Czesc.<br />";
echo "gowno.<br />";
for ($i = 0; $i < 10; $i++) {
    echo "Czesc.<br />";
}
echo "pojebane gowno";
echo "Siemka";
$html->wyswietl_body();
if(isset($_GET['akcja2'])&&($_GET['akcja2'])=='nr_strony')
{
  if(isset($_SESSION['prawid_uzyt']))
  {

        $obrobka_zdjecia->wyswietlanie_wszystkich_zdjec($_GET['nr_stronicy'],$_SESSION['prawid_uzyt']);
  }
  else
  {
  $obrobka_zdjecia->wyswietlanie_wszystkich_zdjec($_GET['nr_stronicy'],0);
  }
}
else
{ 
  if(isset($_SESSION['prawid_uzyt']))
  {
  $obrobka_zdjecia->wyswietlanie_wszystkich_zdjec(1,$_SESSION['prawid_uzyt']);
  }
  else
  {   
  $obrobka_zdjecia->wyswietlanie_wszystkich_zdjec(1,0);
  }
}



//$smarty->assign("popularnosc_zdj", $wysw->wysw_pop_zdj());
//$smarty->assign("popularnosc", $wysw->wysw_pop_uzyt());
//$smarty->display('templates/index.tpl');
$html->wyswietl_footer();


?>
