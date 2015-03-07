
create database uwierz;

use uwierz;

create table uwierzytelnieni_uzytkownicy (
        uzytkownik      varchar(20) not null,
        haslo           varchar(40) not null,
        primary key     (uzytkownik)
);

insert into uwierzytelnieni_uzytkownicy values 
  ('uzytkownik', 'haslo');

insert into uwierzytelnieni_uzytkownicy values
  ( 'testowy', sha1('haslo') );

grant select on uwierz.*
to uwierzytel@localhost 
identified by 'uwierzytel';

flush privileges;




create table zdj_kod_uzytk (
        nr_zdj      int not null,
        nr_uzyt           int not null,
        UNIQUE KEY ix_zdj_kod_uzytk     (nr_zdj,nr_uzyt)


kweik:        
        
    create table uzytkownicy(
    uzytkownik varchar (20),
    haslo varchar (40),
    primary key (uzytkownik)
    )
    
    create table zdjecia_uzytkownikow(
    nr_zdj int not null,
    uzytkownik varchar (20),
    popularnosc_zdj int,
    url_zdjecia text,
    data_dodania text,
    unique key ix_zdj_uzyt(nr_zdj)
    )
    create table zdjecia_forum(
    id int not null auto_increment,
    nr_zdj int,
    stare_id int,
    uzytkownik varchar (20),
    tekst text,
    czas text,
    primary key (id)
    )
    
    create table zdjecia_uzyt_popularnosc(
    nr_zdj int not null,
    uzytkownik varchar (20),
    unique key ix_zdj_uzyt_pop(nr_zdj,uzytkownik)
    )
    
    
    create table komentarze_uzyt_popularnosc(
    id_komentarza int not null,
    uzytkownik varchar (20),
    popularnosc_komentarza int,
    unique key ix_kom_uzyt_pop(id_komentarza,uzytkownik)
    )
    
    
);