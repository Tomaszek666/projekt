<?php
class cialo{
      public function wyswietl_header() {
      ?>
      <html>
        <head>
          <?php
          $spr4 ="templates/glowne_style.css";  
          if(file_exists($spr4)){
          ?>
          <link href='templates/glowne_style.css' type='text/css' rel='stylesheet'/>
          <?php }else{
          ?>
          <link href='../templates/glowne_style.css' type='text/css' rel='stylesheet'/>
          <?php }
          ?>
        </head>
      <body>
        <div class="top">
          <table width="60%" align="center">
            <tr>
              <td>
                <?php
                $html = new cialo(); 
                $pobieranie_akcji = new control();
                $formularze = new view();
                $wysw = new main();
                $obrobka_zdjecia = new obrobka_zdj();
                if(isset($_GET['akcja'])){
                  switch($_GET['akcja']){
                    
                    case 'rejestracja':
                      $nazwa_uz = $pobieranie_akcji->filtruj($_POST['nazwa_uz']);
                      $haslo = $pobieranie_akcji->filtruj($_POST['haslo']);
                      $haslo2 = $pobieranie_akcji->filtruj($_POST['haslo2']);
                      $pobieranie_akcji->rejestracja($nazwa_uz,$haslo,$haslo2);
                      break;
                    case 'logowanie':
                      $nazwa_uz = $pobieranie_akcji->filtruj($_POST['nazwa_uz']);
                      $haslo = $pobieranie_akcji->filtruj($_POST['haslo']);
                      $pobieranie_akcji->logowanie($nazwa_uz,$haslo);
                      break;
                    case 'wyloguj':
                      $pobieranie_akcji->wylogowanie();
                      break;
                    case 'strona_uzytkownika':
                      $pobieranie_akcji->przejscie_na_str_uzytkownika($_SESSION['prawid_uzyt']);
                      break;  
                  }
                }   
                if(isset($_SESSION['prawid_uzyt'])){
                echo '<div class="jestes_zalogowany_jako">jestes zalogowany jako: '.$_SESSION['prawid_uzyt'].'</div>';
                }else{
                echo '<div class="nie_jestes_zalogowany">nie jestes zalogowany</div>';}
                ?>
              </td>
              <td>
                <?php
                $formularze = new view();
                if(isset($_SESSION['prawid_uzyt'])){
                $formularze->wyswietl_form_wylog();}
                ?>
              </td>
              <td>
                <?php
                $formularze->wyswietl_form_przejscia_na_str_uzytkownika();
                ?>
              </td>
              <td>
                <?php
                $formularze->wyswietl_form_przejscia_na_str_glowna();
                
                ?>
              </td>
            </tr>
          </table>
        </div>
                <?php
                
                //$obrobka_zdjecia->wyswietlanie_tylko_zdjec_uzytkownika($_SESSION['prawid_uzyt']);
                
      }
      public function wyswietl_body() {
      
      ?>
      <div id="cale_cialo">
        <h2>Strona glowna</h2>
      <?php
      $html = new cialo(); 
      $pobieranie_akcji = new control();
      $formularze = new view();
      $wysw = new main();
      $obrobka_zdjecia = new obrobka_zdj();
      
      if(isset($_GET['akcja'])){
                  switch($_GET['akcja']){ 
                  case 'brak_rejestracji':
                      $formularze->wyswietl_form_rej();
                      break;
                   case 'dodawanie_zdj':
                    //$pobieranie_akcji->sprawdzanie_zgodnosci($_GET['id'])
                      if(isset($_SESSION['prawid_uzyt'])){
                      $pobieranie_akcji->dodawanie_pop_zdj($_GET['ilosc'],$_GET['id'],$_SESSION['prawid_uzyt']);
                      }else{
                      echo 'musisz byc zalogowany zeby oceniac zdjecia';
                      }
                      
                      break;
                    case 'odejmowanie_zdj':
                      if(isset($_SESSION['prawid_uzyt'])){
                      $pobieranie_akcji->odejmowanie_pop_zdj($_GET['ilosc'],$_GET['id'],$_SESSION['prawid_uzyt']);
                      }else{
                      echo 'musisz byc zalogowany zeby oceniac zdjecia';
                      }
                      break; 
                   case 'wstawianie_zdjecia':
                      $obrobka_zdjecia->sprawdz_bledy();
                      $obrobka_zdjecia->sprawdz_typ();
                      $losowa_nazwa_zdj = rand();                             
                      $obrobka_zdjecia->zapisz_plik($losowa_nazwa_zdj);
                      $pobieranie_akcji->dodawanie_zdj_pop($losowa_nazwa_zdj,0,$_SESSION['prawid_uzyt']);
                      
                      break;
                    case 'wstawianie_filmu':
                      $tekst_film = $_POST['tekst_film'];
                      $losowy_nr_filmu = rand(); 
                      $pobieranie_akcji->dodawanie_filmu_pop($losowy_nr_filmu,0,$_SESSION['prawid_uzyt'],$tekst_film);
                      
                      break;
                    case 'wstawianie_zdjecia_profi':
                      $obrobka_zdjecia->sprawdz_bledy();
                      $obrobka_zdjecia->sprawdz_typ();
                      //$losowa_nazwa_zdj = 'profi_'.rand();                             
                      $obrobka_zdjecia->zapisz_plik_profi($_SESSION['prawid_uzyt']);
                      //$pobieranie_akcji->dodawanie_zdj_pop($losowa_nazwa_zdj,0,$_SESSION['prawid_uzyt']);
                      
                      break;
                    case 'usuwanie_zdj':
                      $obrobka_zdjecia->usuwanie_zdjec_uzytkownika($_GET['obrazek']);
                      
                      break;
                    case 'wyswietlanie_zdjecia':
                      $pobieranie_akcji->przekierowywanie_na_strone_obrazka($_GET['id'],$_GET['ilosc']);
                      break;
                   
                  }
      }
      if(!isset($_SESSION['prawid_uzyt'])){
        if(isset($_GET['akcja'])){
          if(($_GET['akcja'])!='brak_rejestracji'){
      $formularze->wyswietl_form_log();
      }
      }
      }
      ?>
      
      <?php
      }
      public function wyswietl_body_zdjecia() {
      require_once "../controller/controller.php";
      require_once "../controller/funkcje_zdjecia.php";       
      $pobieranie_akcji = new control();
      $obrobka_zdjecia = new obrobka_zdj();
      $formularze = new view();
      ?>
      <div id="cale_cialo">
        <h2>forum zdjecia</h2>
      <?php
      
      }
      public function wyswietl_footer() {
      ?>
          </div>
          <div id="footer"></div>
        </body>
      </html>
      <?php
      }
      
}
?>