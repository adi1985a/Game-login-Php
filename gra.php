<?php

session_start(); // nie musimy zamykac, kazdy dokument musi posiadac ta instrukcje zeby dzialac z tablicy globalnej _SESSION['user'] 
//musimy to takze dodac do pliku zaloguj.php

//jezeli nie jestesmy zalogowani(zmienna $zalogowany nie bedzie istniec) przekieruje nas do pliku index.php:
if(!isset($_SESSION['zalogowany'])) //a skoro zmienna nie bedzie istniec to nie bedzie tez miec poprawnej wartosci true
{
    //to wszystko oznacza ze nie jestesmy zalogowani dlatego przekierowujemy uzytkownika do strony logowania:
    header('Location: index.php');
    exit(); //i wstrzymujemy dalsze wykonywanie sie skryptu funkcja exit();
}

?>


<!DOCTYPE HTML>
<html land="pl">

<head>

<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Osadnicy - gra przegladarkowa</title>

</head>

<body>

    <?php //wartosc wyjeta z bazy pokazemy instrukcja echo 

        echo "<p>Witaj ".$_SESSION['user']."! [<a href='logout.php' style='color:red'>Wyloguj sie!</a>]</p>";
        //echo "<p>Twoja sesja: ".session_id(); //serwer rozpoznaje nas poprzez tzw phpsessid (php session id)
        //jesli komus udalo by sie przechwycic twoj session id to bedzie mogl korzystac z twojego konta z innego komputera 
        //istnieja pewne metody przechwytywania session id np: session fixation, session hijacking
    
        echo "<p><b>Drewno</b>: ".$_SESSION['drewno'];
        echo " | <b>Kamien</b>: ".$_SESSION['kamien'];
        echo " | <b>Zboze</b>: ".$_SESSION['zboze']."</p>";
        echo "<p><b>E-mail:</b>: ".$_SESSION['email'];
        echo "<br/><b>Dni premium: ".$_SESSION['dnipremium']."</p>";
    
    
    ?>



</body>

</html>


<!-- DO POWTORZENIA WSZYSTKO, CIEZKI TEMAT!-->