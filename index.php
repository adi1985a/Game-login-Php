<?php


session_start();

//jesli istnieje zmienna session[zalogowany] i jednoczenie session[zalogowany]==true to wtedy przekieruj do pliku gra.php:
if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    header('Location: gra.php');
    exit(); //zeby strona nie wykonywala wszystkich instrukcji pod spodem nalezy wyjsc po wykonaniu ifa funkcja exit();
    //dlatego od razu wykonuje sie header() i zostajemy skierowani na strone gra.php
}   //jesli wstawilibysmy exit() w pliku zaloguj.php przed zakonczeniem polaczenia $polaczenie->close(); dlatego nie powinnismy tego robic
?>


<!DOCTYPE HTML>
<html land="pl">

<head>

<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Osadnicy - gra przegladarkowa</title>

</head>

<body>

Tylko martwi ujrzeli koniec wojny - Platon <br/><br/>

<form action="zaloguj.php" method="post">

    Login: <br/> <input type="text" name="login"/> <br/>
    Haslo: <br/> <input type="password" name="haslo"/> <br/><br/> 
    <input type="submit" value="Zaloguj sie"/>

</form>



<?php 

if(isset($_SESSION['blad'])) //isset - znaczy: jest ustawiona [zmienna] , sprawdza czy taka zmienna jest ustawiona w sesji, jesli tak to pokaz jej zawartosc echem ['blad'] 
//tutaj pokazemy informacje o ewentualnym bledzie logowania tylko jesli taka sesja[zmienna] istnieje w bazie ale zostal podany zly login albo haslo:
echo "<br/>".$_SESSION['blad']; //info z zaloguj.php (z else) jesli haslo lub login sa niepoprawne.



?>


</body>

</html>


<!-- DO POWTORZENIA WSZYSTKO, CIEZKI TEMAT!-->