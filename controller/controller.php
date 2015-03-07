<?php
$spr ="model/model_baza.php";
$spr2 ="view/view.php";
$spr3 ="templates/body.php";  
if(file_exists($spr)){
require_once "model/model_baza.php";
}else{
require_once "../model/model_baza.php";}
if(file_exists($spr2)){
require_once "view/view.php";
}else{
require_once "../view/view.php";}
if(file_exists($spr3)){
require_once "templates/body.php";
}else{
require_once "../templates/body.php";}

class control extends main{
  
    public function filtruj($zmienna)
    {
        //if(get_magic_quotes_gpc())
            $zmienna = stripslashes($zmienna); // usuwamy slashe
    
    	// usuwamy spacje, tagi html oraz niebezpieczne znaki
       // return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
       return htmlspecialchars(trim($zmienna));
    } 
    public function dodawanie_zdj_pop($nr_zdj,$pop_poczatkowa_zdj,$nazwa_uz){ 
    $data_zdjecia = date('Y-m-d H:i:s');
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    $result = $sql->query("insert into zdjecia_uzytkownikow values
                       ('".$nr_zdj."','".$nazwa_uz."','".$pop_poczatkowa_zdj."',null,'".$data_zdjecia."')");
    if(!$result){
    echo ('Blad zapytania z baza danych na temat zmiany popularnosci zdjecia ');
    }  
   // echo $nowy_nr_zdj.$pop_poczatkowa_zdj;
    }    
    public function dodawanie_filmu_pop($nr_filmu,$pop_poczatkowa_zdj,$nazwa_uz,$url_filmu){
    $data_filmu = date('Y-m-d H:i:s'); 
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    if(strstr($url_filmu,"=")!==False){
    $modyfikacja = explode("=",$url_filmu);
    $url_wyjsciowy = 'https://www.youtube.com/embed/'.$modyfikacja[1]; 
    }
    if (strstr($url_filmu,"http://youtu.be/")!==False){
    $modyfikacja = explode("/",$url_filmu);
    $url_wyjsciowy = 'https://www.youtube.com/embed/'.$modyfikacja[3]; 
    }
    $result = $sql->query("insert into zdjecia_uzytkownikow values
                       ('".$nr_filmu."','".$nazwa_uz."','".$pop_poczatkowa_zdj."','".$url_wyjsciowy."','".$data_filmu."')");
    
    if(!$result){
    echo ('Blad zapytania z baza danych na temat zmiany popularnosci zdjecia ');
    }  
   // echo $nowy_nr_zdj.$pop_poczatkowa_zdj;
    } 
    //dodawanie popularnosci plus jeden do zdjecia
    public function dodawanie_pop_zdj($ilosc_pop,$nr_id,$nr_uzytkownika){
    $ilosc_pop_nowe = $ilosc_pop+1;
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    $result = $sql->query("insert into zdjecia_uzyt_popularnosc values
                       ('".$nr_id."','".$nr_uzytkownika."')");
    
    if($result){
    $sql->query("update zdjecia_uzytkownikow
                         set popularnosc_zdj = '".$ilosc_pop_nowe."'
                         where nr_zdj = '".$nr_id."'");
    }
    }
    //odejmowanie popularnosci minus jeden do zdjecia
    public function odejmowanie_pop_zdj($ilosc_pop,$nr_id,$nr_uzytkownika){
    $ilosc_pop_nowe = $ilosc_pop-1;
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    $result = $sql->query("insert into zdjecia_uzyt_popularnosc values
                       ('".$nr_id."','".$nr_uzytkownika."')");
    
    if($result){
    $sql->query("update zdjecia_uzytkownikow
                         set popularnosc_zdj = '".$ilosc_pop_nowe."'
                         where nr_zdj = '".$nr_id."'");
    }
    }
    
    
    
    
    
    
      
    public function rejestracja($nazwa_uz,$haslo,$haslo2){
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    if($nazwa_uz&&$haslo&&$haslo2){
    if($haslo==$haslo2){
    $result = $sql->query("insert into uzytkownicy values
                       ('".$nazwa_uz."','".$haslo."')");
    }else{echo ('hasla nie sa takie same');
    }
    }else{echo ('nie wprowadzono wszystkich danych');
    }
    }
    
    public function logowanie($nazwa_uz,$haslo){
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    if($nazwa_uz&&$haslo){
    $result = $sql->query("select * from uzytkownicy
                         where uzytkownik='".$nazwa_uz."'
                         and haslo = '".$haslo."'");
      if($result->num_rows>0){
      $_SESSION['prawid_uzyt'] = $nazwa_uz;
      
      }else{
      echo 'niepoprawne dane wpisane';
      }
    }else{
    echo ('nie wprowadzono wszystkich danych');
    }
    }
    
    public function wylogowanie(){
    unset($_SESSION['prawid_uzyt']);
    }
    public function przejscie_na_str_uzytkownika($prawid_uzyt){
    header("Location: strona_uzytkownika.php");
    }
    public function przejscie_na_str_glowna(){
    header("Location: index.php");
    }
    
    //przekierowanie na strone obrazka po jego nacisnieciu
    public function przekierowywanie_na_strone_obrazka($file_koncowy,$popularnosc_zdj){
    
    // $file_koncowy to jest id_zdjecia
    $c = '<?php require_once "../controller/controller.php";require_once "../controller/funkcje_zdjecia.php";
    session_start();       
    $pobieranie_akcji = new control();
    $obrobka_zdjecia = new obrobka_zdj();
    $formularze = new view();
    $html = new cialo();
    $html->wyswietl_header();
    $html->wyswietl_body_zdjecia();
     '.'?'.'>';
    //tworzy nowy plik dla danego zdjecia, jesli juz istnieje to nadpisuje go nowymi danymi
    $plik = 'view/'.$file_koncowy.'.php'; //nazwa pliku
    $zawartosc= $c.'<?php $pobieranie_akcji->obsluga_zdjecia();
    $obrobka_zdjecia->wyswietlanie_jednego_zdjecia_uzytkownika('.$file_koncowy.');
    if(isset($_SESSION['.'"prawid_uzyt"'.'])){
    $formularze->wyswietl_form_forum('.$file_koncowy.');}
    else echo '.'"<div class=\"bledy\">aby dodawac komentarze musisz byc zalogowany</div>"'.';
    if(isset($_POST['.'"tekst"'.'])&&isset($_SESSION['.'"prawid_uzyt"'.'])){
    $tekst = $pobieranie_akcji->filtruj($_POST['.'"tekst"'.']);
    $pobieranie_akcji->dodawanie_komentarza_do_zdjecia('.$file_koncowy.',$tekst,$_SESSION['.'"prawid_uzyt"'.']);};
    
    
    
    if(isset($_GET['.'"akcja"'.'])){
                  switch($_GET['.'"akcja"'.']){
                      case '.'"dodawanie_pop_komentarza"'.':
                      if(isset($_SESSION['.'"prawid_uzyt"'.'])){
                      $pobieranie_akcji->dodawanie_pop_komentarza($_GET['.'"ilosc"'.'],$_GET['.'"id"'.'],$_SESSION['.'"prawid_uzyt"'.']);
                      }else{
                      echo '.'"musisz byc zalogowany zeby oceniac komentarz uzytkownika"'.';
                      }
                      
                      break;
                    case '.'"odejmowanie_pop_komentarza"'.':
                      if(isset($_SESSION['.'"prawid_uzyt"'.'])){
                      $pobieranie_akcji->odejmowanie_pop_komentarza($_GET['.'"ilosc"'.'],$_GET['.'"id"'.'],$_SESSION['.'"prawid_uzyt"'.']);
                      }else{
                      echo '.'"musisz byc zalogowany zeby oceniac komentarz uzytkownika"'.';
                      }
                      break;     
                      case '.'"wyswietlanie_formularza_odpowiedzi"'.':
                      $formularze->wyswietl_odpowiedz_form_forum($_GET['.'"id"'.'],'.$file_koncowy.');
                      break;
                      case '.'"usuwanie_komentarzu_uzytkownika"'.':
                      $obrobka_zdjecia->usuwanie_komentarzu_uzytkownika($_GET['.'"nr_id"'.']);
                      break;
                      case '.'"usuwanie_odp_komentarzu_uzytkownika"'.':
                      $obrobka_zdjecia->usuwanie_odp_komentarzu_uzytkownika($_GET['.'"nr_id"'.']);
                      break;
                      case '.'"wyswietlanie_komentarzy_do_odpowiedzi_uzytkownikow"'.':
                      if(isset($_POST['.'"tekst_odp"'.'])&&isset($_SESSION['.'"prawid_uzyt"'.'])){
                      $tekst_odp = $pobieranie_akcji->filtruj($_POST['.'"tekst_odp"'.']);
                      $pobieranie_akcji->dodawanie_komentarzy_do_odpowiedzi_poszczegolnych_uzytkownikow_zdjecia($_GET['.'"nr_id"'.'],'.$file_koncowy.',$tekst_odp,$_SESSION['.'"prawid_uzyt"'.']);
                      };
                      break;
                  }  
    };
    $pobieranie_akcji->wyswietlanie_komentarzy_do_zdjecia('.$file_koncowy.');
    $html->wyswietl_footer();
    '.'?'.'>';  
    
   // $zawartosc= $c.'<?php $pobieranie_akcji->obsluga_zdjecia();$obrobka_zdjecia->wyswietlanie_zdjec_uzytkownika() '.'?'.'>'; //zawarto¶æ pliku
    file_put_contents($plik, $zawartosc);
    header("Location: $plik");
    }
    
    
    public function obsluga_zdjecia(){
    $pobieranie_akcji = new control();
    if(isset($_GET['akcja'])){
                  switch($_GET['akcja']){
                    case 'dodawanie_zdj':
                    //$pobieranie_akcji->sprawdzanie_zgodnosci($_GET['id'])
                      $pobieranie_akcji->dodawanie_pop_zdj($_GET['ilosc'],$_GET['id'],$_SESSION['prawid_uzyt']);
                      
                      break;
                    case 'odejmowanie_zdj':
                      $pobieranie_akcji->odejmowanie_pop_zdj($_GET['ilosc'],$_GET['id'],$_SESSION['prawid_uzyt']);
                      break;     
                  }
    }
    }
    public function dodawanie_komentarza_do_zdjecia($nr_zdj,$tekst,$nazwa_uz)
    {
      $data_komentarza = date('Y-m-d H:i:s');
      $sql = $this->connect_db();
      if(!$sql)
      {
      echo ('Blad polaczenia bazy ');
      }
      if($nr_zdj&&$tekst&&$nazwa_uz){
      $result = $sql->query("SELECT nr_zdj,uzytkownik,tekst from zdjecia_forum where nr_zdj='".$nr_zdj."' and uzytkownik='".$nazwa_uz."' and tekst='".$tekst."'");
        if($result->num_rows>0)
        {
        echo "<div class=\"bledy\">nie spamuj, taki komentarz juz napisales</div>";
        }else{
        $result2 = $sql->query("insert into zdjecia_forum values
                           (null,'".$nr_zdj."',0,'".$nazwa_uz."','".$tekst."','".$data_komentarza."')");
        $result3 = $sql->query("SELECT id,nr_zdj, uzytkownik, tekst from zdjecia_forum where nr_zdj='".$nr_zdj."' and uzytkownik='".$nazwa_uz."' and tekst='".$tekst."'");
          if($result3->num_rows>0)
          {
            while ($row = $result3->fetch_array()) 
            {
            $id = $row["id"];
            $result4 = $sql->query("insert into komentarze_uzyt_popularnosc values
                               ('".$id."','".$nazwa_uz."',0)");
            }
          }
        }
      }else{
      echo ('nie wprowadzono wszystkich danych / sprawdz czy jestes zalogowany');
      }
    }
    
    
    
    public function wyswietlanie_komentarzy_do_zdjecia($nr_zdj){
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    $result = $sql->query("SELECT id,nr_zdj,stare_id, uzytkownik, tekst,czas from zdjecia_forum where nr_zdj='".$nr_zdj."' and stare_id=0 ");
    if($result->num_rows>0){
      echo '<div class="komentarze">';
      echo "<table>";
      echo "<tr><th bgcolor=\"#CCCCFF\">Komentarze: </td></tr>";
      echo "</table>";
      while ($row = $result->fetch_array()) {
      
      $id = $row["id"];
      echo "<table>";
      
      echo "<TR class=\"glowny_komentarz_tr\"><div class=\"komentarz_linia_gorna\"></div><td valign='top'><div class=\"glowny_komentarz_td_zdjecie\">";
            $spr8 ="../zdjecia_profilowe/zdj_".$row["uzytkownik"].".jpg"; 
            if(file_exists($spr8)){
            echo "<img src=\"../zdjecia_profilowe/zdj_".$row["uzytkownik"].".jpg\"/></div></td>";
            }else{
            echo "<img src=\"../zdjecia_profilowe/zdj_profilowe.jpg\"/></div></td>";
            }
            
      echo "<td valign='top'><div class=\"glowny_komentarz_td\">" . $row["uzytkownik"]."&nbsp&nbsp</div>";
      
      $result6 = $sql->query("SELECT id_komentarza,uzytkownik,popularnosc_komentarza from komentarze_uzyt_popularnosc where id_komentarza='".$row['id']."' and uzytkownik = '".$row['uzytkownik']."'");
      
      if($result6->num_rows>0)
      {
        while ($row6 = $result6->fetch_array()) 
        {
          echo "<div class=\"komentarz_akcja_pop_dodaj\"><a href=".$nr_zdj.".php?akcja=dodawanie_pop_komentarza&ilosc=".$row6['popularnosc_komentarza']."&id=".$row['id'].">mocne</a></div>";
          echo "<div class=\"komentarz_akcja_pop_odejmij\"><a href=".$nr_zdj.".php?akcja=odejmowanie_pop_komentarza&ilosc=".$row6['popularnosc_komentarza']."&id=".$row['id'].">&nbspslabe&nbsp</a></div>";
          echo "<div class=\"komentarz_akcja_pop_napis\"><a>&nbsp".$row6['popularnosc_komentarza']."&nbsp</a></div>";
        }
      };
      
      $result11 = $sql->query("SELECT id_komentarza from komentarze_uzyt_popularnosc where id_komentarza='".$row['id']."'");
      $ilosc_powtorzen2 = ($result11->num_rows)-1;
      echo "<div class=\"komentarz_akcja_pop_napis_ilosc\"><a>&nbsp(".$ilosc_powtorzen2.")&nbsp</a></div>";
      echo "<div class=\"komentarz_czas\"><a>&nbsp".$row['czas']."&nbsp</a></div>";
      echo "<div class=\"glowny_komentarz_td_tekst\">".$row["tekst"]."</div>";
      if(isset($_SESSION['prawid_uzyt']))
      {
      if($_SESSION['prawid_uzyt']==$row['uzytkownik'])
      {
        echo "<div class=\"usun_komentarz\"><a href=\"".$nr_zdj.".php?akcja=usuwanie_komentarzu_uzytkownika&nr_id=".$row["id"]."\">usun</a></div>";
      }
      }
      echo "</td></TR>";
      echo "<tr><td></td>";
      echo "<td>";
          $result2 = $sql->query("SELECT id, nr_zdj, stare_id, uzytkownik, tekst, czas from zdjecia_forum where stare_id='".$id."'");
          if($result2->num_rows>0)
          {
            while ($row2 = $result2->fetch_array()) 
            {
              echo "<table>
              <tr class=\"odp_komentarz_tr\"><div class=\"odp_komentarz_linia_gorna\"></div><td valign='top'><div class=\"glowny_komentarz_td_zdjecie\">";
                $spr9 ="../zdjecia_profilowe/zdj_".$row2["uzytkownik"].".jpg"; 
                if(file_exists($spr9))
                {
                  echo "<img src=\"../zdjecia_profilowe/zdj_".$row2["uzytkownik"].".jpg\"/></div></td>";
                }else
                {
                  echo "<img src=\"../zdjecia_profilowe/zdj_profilowe.jpg\"/></div></td>";
                }
                
              echo "<td valign='top'><div class=\"odp_komentarz_td\">".$row2["uzytkownik"]."&nbsp&nbsp </div>";
              $result7 = $sql->query("SELECT id_komentarza,uzytkownik,popularnosc_komentarza from komentarze_uzyt_popularnosc where id_komentarza='".$row2['id']."' and uzytkownik = '".$row2['uzytkownik']."'");
              if($result7->num_rows>0)
              {
                while ($row7 = $result7->fetch_array()) 
                {
                echo "<div class=\"komentarz_akcja_pop_dodaj\"><a href=".$nr_zdj.".php?akcja=dodawanie_pop_komentarza&ilosc=".$row7['popularnosc_komentarza']."&id=".$row2['id'].">mocne</a></div>";
                echo "<div class=\"komentarz_akcja_pop_odejmij\"><a href=".$nr_zdj.".php?akcja=odejmowanie_pop_komentarza&ilosc=".$row7['popularnosc_komentarza']."&id=".$row2['id'].">&nbspslabe&nbsp</a></div>";
                echo "<div class=\"komentarz_akcja_pop_napis\"><a>&nbsp".$row7['popularnosc_komentarza']."&nbsp</a></div>";
                }
              };
              $result10 = $sql->query("SELECT id_komentarza from komentarze_uzyt_popularnosc where id_komentarza='".$row2['id']."'");
              $ilosc_powtorzen = ($result10->num_rows)-1;
              echo "<div class=\"komentarz_akcja_pop_napis_ilosc\"><a>&nbsp(".$ilosc_powtorzen.")&nbsp</a></div>";
              echo "<div class=\"komentarz_czas\"><a>&nbsp".$row2['czas']."&nbsp</a></div>";
              echo "<div class=\"odp_komentarz_td_tekst\">" . $row2["tekst"] . "</div>";
              if($_SESSION['prawid_uzyt']==$row2['uzytkownik'])
              {
                echo "<div class=\"usun_komentarz\"><a href=\"".$nr_zdj.".php?akcja=usuwanie_odp_komentarzu_uzytkownika&nr_id=".$row2["id"]."\">usun</a></div>";
              }
              echo "</td></tr></table>";
            }
          }
      echo "<div class=\"odpowiedz\"><a href='#tt".$row["id"]."'>odpowiedz</a></div><div id='tt".$row["id"]."'>";
      ?>
      <div class="wyswietlanie_form_odpowiedzi">
        <form method="post" action="<?php echo $nr_zdj.'.php?akcja=wyswietlanie_komentarzy_do_odpowiedzi_uzytkownikow&nr_id='.$row["id"].'';?>">
          <table>
             <tr>
               <td><textarea id="txtArea" rows="3" cols="70" name="tekst_odp" title="Dodaj komentarz..."  required="1" placeholder="Dodaj komentarz..." aria-required="true" onkeydown="run_with(this, [&quot;legacy:control-textarea&quot;], function() {TextAreaControl.getInstance(this)});"></textarea></td>
             </tr> 
             <tr>
               <td colspan="2" align=center>
               <input type="submit" value="zatwierdz"/></td>
             </tr>
          </table>
        </form>
      </div>
      <?php
      echo "</div></td>"; 
      echo "<style>#tt".$row["id"]."{display: none;}#tt".$row["id"].":target{display: block;}</style>";
      echo "</tr>";
      }
      echo "</table></div>";
      }else
      {
        echo "<div class=\"bledy\">brak komentarzy pod zjeciem</div>";
      }
    
    }
    
    
    public function dodawanie_komentarzy_do_odpowiedzi_poszczegolnych_uzytkownikow_zdjecia($nr_id,$nr_zdj,$tekst,$nazwa_uz_obecnie_zalogowanego){
      $sql = $this->connect_db();
      if(!$sql)
      {
      echo ('Blad polaczenia bazy ');
      }
      if($nr_id&&$nr_zdj&&$tekst&&$nazwa_uz_obecnie_zalogowanego)
      {
        $result = $sql->query("SELECT id,nr_zdj,uzytkownik,tekst from zdjecia_forum where nr_zdj='".$nr_zdj."' and uzytkownik='".$nazwa_uz_obecnie_zalogowanego."' and tekst='".$tekst."'");
        if($result->num_rows>0)
        {
        echo "<div class=\"bledy\">nie spamuj, taki komentarz juz napisales</div>";
        }else
        {
          $data_komentarza = date('Y-m-d H:i:s');
          $result2 = $sql->query("insert into zdjecia_forum values
                             (null,'".$nr_zdj."','".$nr_id."','".$nazwa_uz_obecnie_zalogowanego."','".$tekst."','".$data_komentarza."')");
          $result3 = $sql->query("SELECT id, nr_zdj, stare_id, uzytkownik, tekst from zdjecia_forum where stare_id='".$nr_id."' and nr_zdj='".$nr_zdj."' and uzytkownik='".$nazwa_uz_obecnie_zalogowanego."' and tekst='".$tekst."'");
          if($result3->num_rows>0)
          {
            while ($row = $result3->fetch_array()) 
            {
              $id = $row["id"];
              $result4 = $sql->query("insert into komentarze_uzyt_popularnosc values
                                 ('".$id."','".$nazwa_uz_obecnie_zalogowanego."',0)");
            }
          }
        }
        
      }else
      {
      echo ('nie wprowadzono wszystkich danych / sprawdz czy jestes zalogowany');
      }
    }
    public function dodawanie_pop_komentarza($ilosc_pop,$nr_id,$nr_uzytkownika){
    $ilosc_pop_nowe = $ilosc_pop+1;
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    $result = $sql->query("insert into komentarze_uzyt_popularnosc values
                       ('".$nr_id."','".$nr_uzytkownika."','".$ilosc_pop."')");
    
    if($result){
    $sql->query("update komentarze_uzyt_popularnosc
                         set popularnosc_komentarza = '".$ilosc_pop_nowe."'
                         where id_komentarza = '".$nr_id."'");
    }
    }
    public function odejmowanie_pop_komentarza($ilosc_pop,$nr_id,$nr_uzytkownika){
    $ilosc_pop_nowe = $ilosc_pop-1;
    $sql = $this->connect_db();
    if(!$sql){
    echo ('Blad polaczenia bazy ');
    }
    $result = $sql->query("insert into komentarze_uzyt_popularnosc values
                       ('".$nr_id."','".$nr_uzytkownika."','".$ilosc_pop."')");
    
    if($result){
    $sql->query("update komentarze_uzyt_popularnosc
                         set popularnosc_komentarza = '".$ilosc_pop_nowe."'
                         where id_komentarza = '".$nr_id."'");
    }
    }
    
} 
?>