<?php require_once "../controller/controller.php";require_once "../controller/funkcje_zdjecia.php";
    session_start();       
    $pobieranie_akcji = new control();
    $obrobka_zdjecia = new obrobka_zdj();
    $formularze = new view();
    $html = new cialo();
    $html->wyswietl_header();
    $html->wyswietl_body_zdjecia();
     ?><?php $pobieranie_akcji->obsluga_zdjecia();
    $obrobka_zdjecia->wyswietlanie_jednego_zdjecia_uzytkownika(25675);
    if(isset($_SESSION["prawid_uzyt"])){
    $formularze->wyswietl_form_forum(25675);}
    else echo "aby dodawac komentarze musisz byc zalogowany";
    if(isset($_POST["tekst"])&&isset($_SESSION["prawid_uzyt"])){
    $tekst = $pobieranie_akcji->filtruj($_POST["tekst"]);
    $pobieranie_akcji->dodawanie_komentarza_do_zdjecia(25675,$tekst,$_SESSION["prawid_uzyt"]);};
    
    
    
    if(isset($_GET["akcja"])){
                  switch($_GET["akcja"]){
                      case "dodawanie_pop_komentarza":
                      if(isset($_SESSION["prawid_uzyt"])){
                      $pobieranie_akcji->dodawanie_pop_komentarza($_GET["ilosc"],$_GET["id"],$_SESSION["prawid_uzyt"]);
                      }else{
                      echo "musisz byc zalogowany zeby oceniac komentarz uzytkownika";
                      }
                      
                      break;
                    case "odejmowanie_pop_komentarza":
                      if(isset($_SESSION["prawid_uzyt"])){
                      $pobieranie_akcji->odejmowanie_pop_komentarza($_GET["ilosc"],$_GET["id"],$_SESSION["prawid_uzyt"]);
                      }else{
                      echo "musisz byc zalogowany zeby oceniac komentarz uzytkownika";
                      }
                      break;     
                      case "wyswietlanie_formularza_odpowiedzi":
                      $formularze->wyswietl_odpowiedz_form_forum($_GET["id"],25675);
                      break;
                      case "usuwanie_komentarzu_uzytkownika":
                      $obrobka_zdjecia->usuwanie_komentarzu_uzytkownika($_GET["nr_id"]);
                      break;
                      case "usuwanie_odp_komentarzu_uzytkownika":
                      $obrobka_zdjecia->usuwanie_odp_komentarzu_uzytkownika($_GET["nr_id"]);
                      break;
                      case "wyswietlanie_komentarzy_do_odpowiedzi_uzytkownikow":
                      if(isset($_POST["tekst_odp"])&&isset($_SESSION["prawid_uzyt"])){
                      $tekst_odp = $pobieranie_akcji->filtruj($_POST["tekst_odp"]);
                      $pobieranie_akcji->dodawanie_komentarzy_do_odpowiedzi_poszczegolnych_uzytkownikow_zdjecia($_GET["nr_id"],25675,$tekst_odp,$_SESSION["prawid_uzyt"]);
                      };
                      break;
                  }  
    };
    $pobieranie_akcji->wyswietlanie_komentarzy_do_zdjecia(25675);
    $html->wyswietl_footer();
    ?>