<?php
class view{
      public function wyswietl_form_zdjecia() {
      ?>
        <form method="post" action="index.php">
        <table>
         <tr>
           <td colspan="2">Nowy numer zdj:</td>
         <tr>
           <td>Numer zdjecia:</td>
           <td><input type="text" name="nowy_nr_zdj"/></td></tr>
         <tr>
           <td>Popularnosc poczatkowa:</td>
           <td><input type="text" name="pop_poczatkowa_zdj"/></td></tr>
         <tr>
           <td colspan="2" align=center>
           <input type="submit" value="zatwierdz"/></td></tr>
       </table></form> 
      <?php
      }
      public function wyswietl_form_dodawania_zdj(){
      //  $_SERVER['REQUEST_URI'] wyswietla aktualny adres w tym wypadku zaczynajac od smarty/
      //<?php echo '..'.$_SERVER['REQUEST_URI']; bubel jest taki ze jak adres ma get to dodaje do konca adresu i wtedy nie przekierowuyje tam gdzie chcemy
      ?>
        <div class="wyswietl_form_dodawania_zdj">
        <a>Dodaj zdjecie na glowna</a>
        <form enctype="multipart/form-data" action="strona_uzytkownika.php?akcja=wstawianie_zdjecia" 
        		 method="post" >
        <input type="hidden" name="MAX_FILE_SIZE" value="5120000" />
        <input type="file" name="obrazek" />
        <input type="submit" value="wyslij" />
        </form>
        </div>
      <?php
      }
      public function wyswietl_form_log() {
      ?>
        <div class="wyswietl_form_log">
        <p><a href="index.php?akcja=brak_rejestracji">Nie masz konta? Zarejestruj sie u Nas!!</a></p>
        <form method="post" action="index.php?akcja=logowanie">
        <input type="text" name="nazwa_uz"/>
        <input type="password" name="haslo"/>
        <input type="submit" value="Logowanie"/>
        </form></div> 
      <?php
      }

    public function wyswietl_form_rej() {
    ?>
      <div class="wyswietl_form_rej">
     <form method="post" action="index.php?akcja=rejestracja">
     <table>
       <tr>
         <td>Preferowana nazwa uzytkownika <br />(maksymalnie 16 znakow):</td>
         <td valign="top"><input type="text" name="nazwa_uz"
                         size="16" maxlength="16"/></td></tr>
       <tr>
         <td>Haslo <br />(pomiedzy 6 i 16 znakow):</td>
         <td valign="top"><input type="password" name="haslo"
                         size="16" maxlength="16"/></td></tr>
       <tr>
         <td>Potwierdz haslo:</td>
         <td><input type="password" name="haslo2" size="16" maxlength="16"/></td></tr>
       <tr>
         <td colspan="2" align="center">
         <input type="submit" value="Rejestracja"></td></tr>
     </table></form></div> 
    <?php
    }
    public function wyswietl_form_wylog() {
    $spr5 ="index.php";  
    if(file_exists($spr5)){
    $action = "index.php";
    }else{
    $action ="../index.php";}
    ?>
     <div class="form_wylog">
     <form method="post" action="<?php echo $action;?>?akcja=wyloguj">
     <input type="submit" value="wyloguj" />
     </form>
     </div> 
    <?php
    } 
    
    public function wyswietl_form_forum($file_koncowy) {
    ?>
    <div class="form_dodawania_komentarzy">
    <form method="post"  action="<?php echo $file_koncowy.'.php';?>">
      <table>
         <tr>
           <td><textarea id="txtArea" rows="3" cols="85" name="tekst" title="Dodaj komentarz..."  required="1" placeholder="Dodaj komentarz..." aria-required="true" onkeydown="run_with(this, [&quot;legacy:control-textarea&quot;], function() {TextAreaControl.getInstance(this)});"></textarea></td>
         </tr> 
         <tr>
           <td colspan="2" align=center>
           <input type="submit" value="zatwierdz"/></td>
         </tr>
      </table>
    </form></div>
    <?php  
    }  
    public function wyswietl_odpowiedz_form_forum($id,$file_koncowy) {
    
    ?>
    <form method="post" action="<?php echo $file_koncowy.'.php?akcja=wyswietlanie_kompentarzy_do_odpowiedzi_uzytkownikow&nr_id='.$id.'';?>">
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
    <?php  
    }
    public function wyswietl_form_przejscia_na_str_uzytkownika() {
    $spr5 ="index.php";  
    if(file_exists($spr5)){
    $action = "index.php";
    }else{
    $action ="../index.php";}
    ?>
     <div class="form_przejscia_na_str_uzytkownika">
     <form method="post" action="<?php echo $action;?>?akcja=strona_uzytkownika">
     <input type="submit" value="strona uzytkownika" />
     </form>
     </div> 
    <?php
    } 
    public function wyswietl_form_przejscia_na_str_glowna() {
    $spr5 ="index.php";  
    if(file_exists($spr5)){
    $action = "index.php";
    }else{
    $action = "../index.php";}
    ?>
     <div class="form_przejscia_na_str_glowna">
     <form method="post" action="<?php echo $action;?>?akcja=strona_glowna">
     <input type="submit" value="strona glowna"></td></tr>
     </form>
     </div> 
    <?php
    }
    public function wyswietl_form_dodawania_zdj_profi(){
      //  $_SERVER['REQUEST_URI'] wyswietla aktualny adres w tym wypadku zaczynajac od smarty/
      //<?php echo '..'.$_SERVER['REQUEST_URI']; bubel jest taki ze jak adres ma get to dodaje do konca adresu i wtedy nie przekierowuyje tam gdzie chcemy
      ?>
        <div class="wyswietl_form_dodawania_zdj_profi">
        <a>Dodaj zdjecie profilowe</a>
        <form enctype="multipart/form-data" action="strona_uzytkownika.php?akcja=wstawianie_zdjecia_profi" 
        		 method="post" >
        <input type="hidden" name="MAX_FILE_SIZE" value="5120000" />
        <input type="file" name="obrazek" />
        <input type="submit" value="wyslij" />
        </form>
        </div>
      <?php
      } 
    public function wyswietl_form_dod_filmow() {
    ?>
    <div class="wyswietl_form_dod_filmow">
    <a>Dodaj adres filmu z youtube</a>
    <form method="post"  action="strona_uzytkownika.php?akcja=wstawianie_filmu">
      <table>
         <tr>
           <td><textarea id="txtArea" rows="3" cols="85" name="tekst_film" title="Dodaj url filmu..."  required="1" placeholder="Dodaj url filmu..." aria-required="true" onkeydown="run_with(this, [&quot;legacy:control-textarea&quot;], function() {TextAreaControl.getInstance(this)});"></textarea></td>
         </tr> 
         <tr>
           <td colspan="2" align=center>
           <input type="submit" value="zatwierdz"/></td>
         </tr>
      </table>
    </form></div>
    <?php  
    }      
}
?>