<?php
$pobieranie_akcji->obsluga_zdjecia();
    $obrobka_zdjecia->wyswietlanie_jednego_zdjecia_uzytkownika('.$file_koncowy.');
    if(isset($_SESSION['.'"prawid_uzyt"'.'])){
    $formularze->wyswietl_form_forum('.$file_koncowy.');}
    else echo '.'"aby dodawac komentarze musisz byc zalogowany"'.';
    if(isset($_POST['.'"tekst"'.'])&&isset($_SESSION['.'"prawid_uzyt"'.'])){
    $pobieranie_akcji->dodawanie_komentarza_do_zdjecia('.$file_koncowy.',$_POST['.'"tekst"'.'],$_SESSION['.'"prawid_uzyt"'.']);};
    
    
    
    if(isset($_GET['.'"akcja"'.'])){
                  switch($_GET['.'"akcja"'.']){
                      case '.'"wyswietlanie_formularza_odpowiedzi"'.':
                      $formularze->wyswietl_odpowiedz_form_forum($_GET['.'"id"'.'],'.$file_koncowy.');
                      break;
                      case '.'"wyswietlanie_kompentarzy_do_odpowiedzi_uzytkownikow"'.':
                      if(isset($_POST['.'"tekst_odp"'.'])&&isset($_SESSION['.'"prawid_uzyt"'.'])){
                      $pobieranie_akcji->dodawanie_komentarzy_do_odpowiedzi_poszczegolnych_uzytkownikow_zdjecia($_GET['.'"nr_id"'.'],'.$file_koncowy.',$_POST['.'"tekst_odp"'.'],$_SESSION['.'"prawid_uzyt"'.']);
                      };
                      break;
                  }  
    };
    $pobieranie_akcji->wyswietlanie_komentarzy_do_zdjecia('.$file_koncowy.');
?>