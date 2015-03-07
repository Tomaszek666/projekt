<?php
$spr ="model/model_baza.php";
if(file_exists($spr)){
require_once "model/model_baza.php";
}else{
require_once "../model/model_baza.php";}
class obrobka_zdj extends main{
   public function sprawdz_bledy(){
    if ($_FILES['obrazek']['error'] > 0){
      switch ($_FILES['obrazek']['error']){
      // jest wiêkszy ni¿ domyœlny maksymalny rozmiar,
      // podany w pliku konfiguracyjnym
      case 1: {
      echo 'Rozmiar pliku jest zbyt du¿y.';
      break;} 
	    case 2: {
      echo 'Rozmiar pliku jest zbyt du¿y.';
      break;}
	    case 3: {
      echo 'Plik wyslany tylko czesciowo.';
      break;}
	    case 4: {
      echo 'NIe wyslano zadnego pliku.';
      break;}
	    default: {
      echo 'Wystapil blad podczas wysylania.';
      break;}
      }
      return false;
    }
    return true;
  }
  public function sprawdz_typ(){
	if ($_FILES['obrazek']['type'] != 'image/jpeg')
		return false;
	return true;
  }
  public function zapisz_plik($losowa_nazwa_zdj){

      
     $lokalizacja = 'zdjecia/zdj_'.$losowa_nazwa_zdj.'.jpg';
    	
      if(is_uploaded_file($_FILES['obrazek']['tmp_name']))
      {
        if(!move_uploaded_file($_FILES['obrazek']['tmp_name'], $lokalizacja)){
         echo 'Nie udalo sie skopiowac pliku do katalogu.';
          return false;  
        }
      }
      else
      {
        echo 'PROBLEM : Plik nie zostal zapisany!.';
         return false;
      }
      return true;
   }
   public function zapisz_plik_profi($losowa_nazwa_zdj){

      
     $lokalizacja = 'zdjecia_profilowe/zdj_'.$losowa_nazwa_zdj.'.jpg';
    	
      if(is_uploaded_file($_FILES['obrazek']['tmp_name']))
      {
        if(!move_uploaded_file($_FILES['obrazek']['tmp_name'], $lokalizacja)){
         echo 'Nie udalo sie skopiowac pliku do katalogu.';
          return false;  
        }
      }
      else
      {
        echo 'PROBLEM : Plik nie zostal zapisany!.';
         return false;
      }
      return true;
   }
   
    /*public function wyswietlanie_wszystkich_zdjec(){  
    $spr_ ="zdjecia/";
    if(file_exists($spr_)){
    $d = 'zdjecia/'; 
    }else{
    $d = '../zdjecia/'; }
    
    $sql = $this->connect_db();
    if(!$result = $sql->query("SELECT * FROM zdjecia_uzytkownikow ORDER BY data_dodania DESC")){
    echo ('Blad zapytania z baza danych, nie ma w bazie zdjec');
    }else{
    
    while ($row = $result->fetch_array()) {
    if($row["url_zdjecia"]==null){
    echo '<div class="kontenery_obrazkow">';
    echo '<div class="kontenery_media">';
    echo '<a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'"><img src="'.$d.'/zdj_'.$row["nr_zdj"].'.jpg"/></a><br />';
    echo '</div>';
    echo '<div class="kontenery_akcja">';
    echo '<div class="kontenery_akcja_pop_dodaj"><a href="index.php?akcja=dodawanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'">lubie</a></div>';
    echo '<div class="kontenery_akcja_pop_napis"><a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>';
    echo '<div class="kontenery_akcja_pop_odejmij"><a href="index.php?akcja=odejmowanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'">nie lubie</a></div>';
    echo '</div>';
    echo '</div>';
    }else{
    echo '<div class="kontenery_obrazkow">';
    echo '<div class="kontenery_media_film"><a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'"><iframe src="'.$row["url_zdjecia"].'" frameborder="0" allowfullscreen></iframe></a></div>';
    echo '<div class="kontenery_media_film_komentarze"><a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'">zobacz komentarze</a></div>';
    echo '<div class="kontenery_akcja">';
    echo '<div class="kontenery_akcja_pop_dodaj"><a href="index.php?akcja=dodawanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'">lubie</a></div>';
    echo '<div class="kontenery_akcja_pop_napis"><a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>';
    echo '<div class="kontenery_akcja_pop_odejmij"><a href="index.php?akcja=odejmowanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'">nie lubie</a></div>';
    echo '</div>';
    echo '</div>';
    }
    }
    } echo 'siemka';
    }   
    public function gowno(){       //probna funkcja
      $spr_ ="zdjecia/";
      if(file_exists($spr_)){
        $d = 'zdjecia/'; 
      }else{
        $d = '../zdjecia/'; 
      }
      
      $sql = $this->connect_db();
      if(!$result = $sql->query("SELECT * FROM zdjecia_uzytkownikow ORDER BY data_dodania DESC LIMIT 2,5")){
        echo ('Blad zapytania z baza danych, nie ma w bazie zdjec');
      }else{
        $tablica = [];
        while ($row = $result->fetch_array()) {
          echo $row["data_dodania"].'<br />';
        }
      }
    } */
    public function wyswietlanie_wszystkich_zdjec($nr_strony,$zalogowany_jako)
    { 
      
      $spr_ ="zdjecia/";
      if(file_exists($spr_))
      {
        $d = 'zdjecia/'; 
      }
      else
      {
        $d = '../zdjecia/'; 
      }
      if(isset($_GET['akcja2'])&&($_GET['akcja2'])=='nr_strony')
      {
                   $stronica = $_GET['nr_stronicy'];
      }
      else
      {
        $stronica = 1;
      } 
      if($nr_strony!=1)
      {
        $poczatek_wyswietlania_zdjec = ($nr_strony*5)-5;
      }
      else
      {
        $poczatek_wyswietlania_zdjec = 0;
      }
      $sql = $this->connect_db();
      if(!$result = $sql->query("SELECT * FROM zdjecia_uzytkownikow ORDER BY data_dodania DESC LIMIT ".$poczatek_wyswietlania_zdjec.",5"))
      {
        echo ('Blad zapytania z baza danych, nie ma w bazie zdjec');
      }
      else
      {
        while ($row = $result->fetch_array()) 
        {
          if($row["url_zdjecia"]==null)
          {
            echo '<div class="kontenery_obrazkow">
                    <div class="kontenery_media">
                      <div class="kontenery_media_opis_nad_zdjeciem">Dodany przez: <a>'.$row["uzytkownik"].'</a> w '.$row["data_dodania"].'</div>
                      <a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'">
                      <img src="'.$d.'/zdj_'.$row["nr_zdj"].'.jpg"/></a><br />
                    </div>';
            
            $result2 = $sql->query("SELECT * FROM zdjecia_uzyt_popularnosc where nr_zdj='".$row['nr_zdj']."' and uzytkownik='".$zalogowany_jako."'");
            if($result2->num_rows>0)
            {
            echo '<div class="kontenery_akcja">
                      <div class="kontenery_akcja_pop_oceniles">
                        <a>oceniles je</a></div>
                      <div class="kontenery_akcja_pop_napis">
                        <a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>
                    </div>';
            echo '</div>';
              
            }
            else
            {
            echo '<div class="kontenery_akcja">
                      <div class="kontenery_akcja_pop_dodaj">
                        <a href="index.php?akcja=dodawanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'&akcja2=nr_strony&nr_stronicy='.$stronica.'">lubie</a></div>
                      <div class="kontenery_akcja_pop_napis">
                        <a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>
                      <div class="kontenery_akcja_pop_odejmij">
                        <a href="index.php?akcja=odejmowanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'&akcja2=nr_strony&nr_stronicy='.$stronica.'">nie lubie</a></div>
                    </div>';
             echo '</div>';
            }
          }
          else
          {
            echo '<div class="kontenery_obrazkow">
                    <div class="kontenery_media_film">
                    <div class="kontenery_media_opis_nad_zdjeciem">Dodany przez: <a>'.$row["uzytkownik"].'</a> w '.$row["data_dodania"].'</div>
                    <a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'">
                    <iframe src="'.$row["url_zdjecia"].'" frameborder="0" allowfullscreen></iframe></a></div>
                    <div class="kontenery_media_film_komentarze">
                    <a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'">zobacz komentarze</a></div>';
            
            $result3 = $sql->query("SELECT * FROM zdjecia_uzyt_popularnosc where nr_zdj='".$row['nr_zdj']."' and uzytkownik='".$zalogowany_jako."'");
            if($result3->num_rows>0)
            {
              echo '<div class="kontenery_akcja">
                      <div class="kontenery_akcja_pop_oceniles">
                        <a>oceniles je</a></div>
                      <div class="kontenery_akcja_pop_napis">
                        <a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>
                    </div>';
              echo '</div>';
            }
            else
            {
            echo '<div class="kontenery_akcja">
                    <div class="kontenery_akcja_pop_dodaj">
                    <a href="index.php?akcja=dodawanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'&akcja2=nr_strony&nr_stronicy='.$stronica.'">lubie</a></div>
                    <div class="kontenery_akcja_pop_napis"><a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>
                    <div class="kontenery_akcja_pop_odejmij"><a href="index.php?akcja=odejmowanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$row["nr_zdj"].'&akcja2=nr_strony&nr_stronicy='.$stronica.'">nie lubie</a></div>
                  </div>';
            echo '</div>';
            }
          }
        }
        $result_wszystkich_rzedow = $sql->query("SELECT * FROM zdjecia_uzytkownikow");
        $ilosc_wierszy = $result_wszystkich_rzedow->num_rows; 
        $liczba_stron = $ilosc_wierszy/5;
        echo '<div class="numery_strony">';
        echo '<a>('.$stronica.')</a>&nbsp';
        for ($y = 1; $y<=$liczba_stron+1;$y++)
        {
          echo '<a href="index.php?akcja2=nr_strony&nr_stronicy='.$y.'">'.$y.'</a>&nbsp';
        }
          echo '</div>';
      }
      }
        
      public function wyswietlanie_jednego_zdjecia_uzytkownika($id_zdj){  //$file_koncowy pobrany z funkcji przekierowywanie_na_strone_obrazka
      if(isset($_SESSION['prawid_uzyt']))
      { 
      $zalogowany_jako = $_SESSION['prawid_uzyt'];
      }
      else
      {
      $zalogowany_jako = 0;
      }
      $sql = $this->connect_db();
      $result = $sql->query("SELECT * FROM zdjecia_uzytkownikow
      where nr_zdj='".$id_zdj."'");
      if($result->num_rows>0){
      
      
      $spr_ ="zdjecia/";
      if(file_exists($spr_)){
      $d = 'zdjecia/'; 
      }else{
      $d = '../zdjecia/'; }
      //pobieranie zdj z pliku  
      
      while ($row = $result->fetch_array()) {
      $popularnosc_zdj = $row["popularnosc_zdj"];
      if($row["url_zdjecia"]==null){
      echo '<div class="kontenery_obrazkow">';
      echo '<div class="kontenery_media">';
      echo '<a href="'.$id_zdj.'.php?akcja=wyswietlanie_zdjecia&id='.$id_zdj.'&ilosc='.$popularnosc_zdj.'"><img src="'.$d.'/zdj_'.$id_zdj.'.jpg"/></a>';
      echo '</div>';
      $result2 = $sql->query("SELECT * FROM zdjecia_uzyt_popularnosc where nr_zdj='".$id_zdj."' and uzytkownik='".$zalogowany_jako."'");
            if($result2->num_rows>0)
            {
            echo '<div class="kontenery_akcja">
                      <div class="kontenery_akcja_pop_oceniles">
                        <a>oceniles je</a></div>
                      <div class="kontenery_akcja_pop_napis">
                        <a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>
                    </div>';
            echo '</div>';
              
            }
            else
            {
            echo '<div class="kontenery_akcja">';
            echo '<div class="kontenery_akcja_pop_dodaj"><a href="'.$id_zdj.'.php?akcja=dodawanie_zdj&ilosc='.$popularnosc_zdj.'&id='.$id_zdj.'">lubie</a></div>';
            echo '<div class="kontenery_akcja_pop_napis"><a>&nbsp'.$popularnosc_zdj.'&nbsp</a></div>';
            echo '<div class="kontenery_akcja_pop_odejmij"><a href="'.$id_zdj.'.php?akcja=odejmowanie_zdj&ilosc='.$popularnosc_zdj.'&id='.$id_zdj.'">nie lubie</a></div>';
            echo '</div>';
            echo '</div>';
            }
      }
      else
      {
        echo '<div class="kontenery_obrazkow">';
        echo '<div class="kontenery_media_film"><a href="'.$id_zdj.'.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'"><iframe src="'.$row["url_zdjecia"].'" frameborder="0" allowfullscreen></iframe></a></div>';
        echo '<div class="kontenery_media_film_komentarze"><a href="'.$id_zdj.'.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'">zobacz komentarze</a></div>';
        $result3 = $sql->query("SELECT * FROM zdjecia_uzyt_popularnosc where nr_zdj='".$id_zdj."' and uzytkownik='".$zalogowany_jako."'");
            if($result3->num_rows>0)
            {
              echo '<div class="kontenery_akcja">
                      <div class="kontenery_akcja_pop_oceniles">
                        <a>oceniles je</a></div>
                      <div class="kontenery_akcja_pop_napis">
                        <a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>
                    </div>';
              echo '</div>';
            }
            else
            {
            echo '<div class="kontenery_akcja">';
            echo '<div class="kontenery_akcja_pop_dodaj"><a href="'.$id_zdj.'.php?akcja=dodawanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$id_zdj.'">lubie</a></div>';
            echo '<div class="kontenery_akcja_pop_napis"><a>&nbsp'.$row["popularnosc_zdj"].'&nbsp</a></div>';
            echo '<div class="kontenery_akcja_pop_odejmij"><a href="'.$id_zdj.'.php?akcja=odejmowanie_zdj&ilosc='.$row["popularnosc_zdj"].'&id='.$id_zdj.'">nie lubie</a></div>';
            echo '</div>';
            echo '</div>';
            }
      }
      }
      }
    }
    
    
    public function wyswietlanie_tylko_zdjec_uzytkownika($nazwa_uz){  

    $spr_ ="zdjecia/";
    if(file_exists($spr_)){
    $d = 'zdjecia/'; 
    }else{
    $d = '../zdjecia/'; }
    
    $sql = $this->connect_db();
    $result = $sql->query("SELECT * FROM zdjecia_uzytkownikow
    where uzytkownik='".$nazwa_uz."'");
    if($result->num_rows>0){
    //wydobywamy dla danego id_zdj dana popularnosc z bazy
    while ($row = $result->fetch_array()) {
    $popularnosc_zdj = $row["popularnosc_zdj"];
    $nr_zdj = $row["nr_zdj"];
    if($row["url_zdjecia"]==null){
    //$wynik2->free_result();
    //tworzymy html z linkiem usuwania zdj oraz dodawania popularnosci i wyswietlania;)
    //po nacisnieciu na zdjecie przekierowuje nas na strone ze zdjeciem
    echo '<div class="kontenery_obrazkow">';
    echo '<div class="kontenery_media">';
    echo '<a href="strona_uzytkownika.php?akcja=wyswietlanie_zdjecia&id='.$nr_zdj.'&ilosc='.$popularnosc_zdj.'"><img src="'.$d.'/zdj_'.$nr_zdj.'.jpg"/></a><br />';
    echo '</div>';
    echo '<div class="kontenery_akcja">'; 
    //echo '<img src="zdjecia/zdj_'.$numer_id_zdjecia.'.jpg"/>';
    echo '<div class="kontenery_akcja_usun"><a href="strona_uzytkownika.php?akcja=usuwanie_zdj&obrazek=zdj_'.$nr_zdj.'.jpg">Usun to zdjecie</a></div>';
    echo '<div class="kontenery_akcja_pop_napis"><a>&nbspPopularnosc: '.$popularnosc_zdj.'&nbsp</a></div>';
    echo '</div>';
    echo '</div>';
    }else{
    echo '<div class="kontenery_obrazkow">';
    echo '<div class="kontenery_media_film"><a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'"><iframe src="'.$row["url_zdjecia"].'" frameborder="0" allowfullscreen></iframe></a></div>';
    echo '<div class="kontenery_media_film_komentarze"><a href="index.php?akcja=wyswietlanie_zdjecia&id='.$row["nr_zdj"].'&ilosc='.$row["popularnosc_zdj"].'">zobacz komentarze</a></div>';
    echo '<div class="kontenery_akcja">';
    echo '<div class="kontenery_akcja_usun"><a href="strona_uzytkownika.php?akcja=usuwanie_zdj&obrazek=zdj_'.$row["nr_zdj"].'.jpg">Usun to zdjecie</a></div>';
    echo '<div class="kontenery_akcja_pop_napis"><a>&nbspPopularnosc: '.$row["popularnosc_zdj"].'&nbsp</a></div>';
    echo '</div>';
    echo '</div>';
    }
    }
    }
    }
    
    
    
    
    
    
    
    
    public function usuwanie_zdjec_uzytkownika($file){
      $usuwanie_podlogi = explode("_",$file);
      $usuwanie_jpg = explode(".",$usuwanie_podlogi[1]);
      $file_koncowy = $usuwanie_jpg[0];  
      $sql = $this->connect_db();
      
      if(!$sql)
      {
        echo ('Blad polaczenia bazy ');
      }else
      {
        $result = $sql->query("delete from zdjecia_uzytkownikow where nr_zdj='".$file_koncowy."'");
        $result2 = $sql->query("delete from zdjecia_uzyt_popularnosc where nr_zdj='".$file_koncowy."'");
        $result3 = $sql->query("select id from zdjecia_forum where nr_zdj='".$file_koncowy."'");
                             if($result3->num_rows>0)
                             {
                               while ($row3 = $result3->fetch_array()) 
                               {
                                $result6 = $sql->query("delete from odpowiedzi_forum where nr_id_stare='".$row3['id']."'");
                               }
                             }   
        $result4 = $sql->query("delete from zdjecia_forum where nr_zdj='".$file_koncowy."'");                      
        $file = basename($file);
        $katalog = "zdjecia/";
        $katalog2 = "view/"; 
        if (file_exists($katalog.$file))
        { 
          unlink($katalog.$file);
        }
        if (file_exists($katalog2.$file_koncowy.'.php'))
        { 
          unlink($katalog2.$file_koncowy.'.php');
        }
      }
    }
    
    public function usuwanie_komentarzu_uzytkownika($id)
    {  
      $sql = $this->connect_db();
      if(!$sql)
      {
        echo ('Blad polaczenia bazy ');
      }else
      {
        $result = $sql->query("select id,stare_id from zdjecia_forum where stare_id='".$id."'");
                                 if($result->num_rows>0)
                                 {
                                   while ($row = $result->fetch_array()) 
                                   {
                                      //nie dziala to nie wiem dlaczego !!!!!!!!!!!
                                     $stare_id = $row["stare_id"];
                                     $result2 = $sql->query("delete from komentarze_uzyt_popularnosc where id_komentarza='".$stare_id."'");
                                     $result5 = $sql->query("delete from zdjecia_forum where stare_id='".$stare_id."'");
                                   }
                                 }
        $result3 = $sql->query("delete from komentarze_uzyt_popularnosc where id_komentarza='".$id."'");
        $result4 = $sql->query("delete from zdjecia_forum where id='".$id."'");
      }
    }
    public function usuwanie_odp_komentarzu_uzytkownika($id)
    {  
      $sql = $this->connect_db();
      
      if(!$sql)
      {
        echo ('Blad polaczenia bazy ');
      }else
      {
        $result = $sql->query("delete from zdjecia_forum
                             where id='".$id."'");
        
        $result3 = $sql->query("delete from komentarze_uzyt_popularnosc
                                 where id_komentarza='".$id."'");
      }
    }
    
}
?>