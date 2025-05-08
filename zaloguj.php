<?php
//SQL INJECTION(Omowienie):

//SQL INJECTION(wstrzykiwanie SQL): luka w zabezpieczeniach aplikacji internetowych
//polegajaca na nieodpowiednim filtrowaniu znakow z danych wejsciowych, co pozwala
//na przekazywanie dodatkowych parametrow do orginalnego zapytania SQL
//U nas orginalne zapytanie to: 
//$sql = "SELECT * FROM uzytkownicy WHERE user='$login' AND pass='$haslo'"; 

//Metoda logowania jest narazona na tzw wstrzykiwanie sql (SQL INJECTION)
//ktos moze zmusic nas skrypt do wykonania innego zapytania do bazy danych niz okreslilismy w pliku zaloguj php
//Dalismy sprytnemu uzytkownikowi furtke bo czesc naszego zapytania stanowi tekst wprowadzony przez uzytkownika do pol edycyjnych login i haslo: $login=$_POST['login'];$haslo=$_POST['haslo'];
//i dlatego w prosty sposob ktos bedzie mogl zmienic to zapytanie sql na wlasne potrzeby.
//Zalozmy ze znamy login pewnego gracza ale hasla nie znamy, czy uda sie nam zalogowac na jego konto? TAK
//Zalozmy ze login gracza to: marek, jesli wpiszemy w login: marek' -- (marek,apostrof,spacja,dwa myslniki,spacja) 
//a haslo moze byc dowolne, np.hello ,wtedy uda nam sie zalogowac na czyjes konto!!!
//Dlatego musimy sie tego pozbyc na naszej stronie!
//Jak to dziala? Znaki w zapytaniu po marek' czyli dwa myslniki -- to tresc komentarza, a wszystko znajdujace sie po znaku komentarza , jest ignorowane przez intrerpreter polecen
//W sql wygladalo by to tak: SELECT * FROM uzytkownicy WHERE user='marek' --' AND pass='hello' (wszystko po znaku komentarza (dwa mysliniki) zostaje zignorowane bo jest traktowane jako komentarz, a nie wlasciwa tresc zapytania

//A czy mozna dostac sie do czyjegos konta nie znajac nawet loginu? TAK 
//Zeby to zrobic podajemy najpierw dowolny login np: aaa , a jako haslo podamy cos takiego:
// ' OR 1=1 -- (apostrof, spacja, OR, spacja, 1=1, spacja, dwa myslniki, spacja)
//za pomoca jej komendy sql injection uda sie nam zalogowac na pierwsze konto w bazie
//u nas jest to konto adam@gmail.com
//W sql wyglodalo by to tak: SELECT * FROM uzytkownicy WHERE user='aaa' AND pass=' OR 1=! -- '
//dorzucilismy klauzule OR z warunkiem prawdziwym bo 1=1 zawsze rowna sie prawda(true) 
//Krok po kroku:
// user='aaa' AND pass="(ten warunek daje zawsze wartosc false) 
// OR (spojnik OR sprawia, ze cale wyrazenie jest prawdziwe gdy chociaz jedno ze skladniowych wyrazen jest true)  
// 1=1 (ten warunek 1=1 zawsze daje true) 
// -- '(dzieki znakowi komentarza -- ten apostrof ' zostanie pominiety (a bylby to blad skladni))
// Zatem juz dla pierwszego rekordu w bazie cale wyrazenie daje wartosc true 
//- dane zostana pobrane a my zalogowani (bo ulozony przez nas test logowania dal wartosc true)

//Komenda sql injection pozwolila nam wejsc na pierwsze konto z bazy 
//a czy mozna zalogowac sie na dowolne konto w bazie? TAK
//Trzeba tylko odgadnac nazwe kolumny przechowujacej login badz id gracza metoda prob i bledow.
//Jesli w koncu uda nam sie odgadnac ze nick gracza przechowuje sie w kolumnie user
//albo ze kluczem glownym tabeli jest kolumna o nazwie id to mozemy przeszukiwac 
//baze w celu znalezienia gracza o konkretnym nicku albo wybranym numerze id
//Sprawdzmy teraz na przyklad czy istnieje gracz o loginie "anna".
//login: ' OR user='anna' -- (apostrof, spacja,OR,spacja,user='anna',spacja,--,spacja)
//haslo: aaa (dowolne)
//W sql wyglada to tak: SELECT * FROM uzytkownicy WHERE user=" OR user='anna' -- ' AND pass='aaa'
//Krok po kroku:
//user=" OR user='anna' (ten warunek spelni sie jesli napotkamy usera o takim niku )
//pozostala czesc kwerendy bedzie znajdowac sie juz za znakiem komentarza -- wiec bedzie ignorowane
//wiec samo napotkanie takiego usera w bazie wystarczy zeby sie zalogowac, bo warunek logowania zwroci wartosc true i wejdziemy na to konto

//Teraz sprawdzmy ktory z graczy ma w bazie id np 7:
//login: ' OR id=7 -- (apostrof,spacja,OR,spacja,id=7,spacja,--,spacja) 
//haslo: aaa (dowolne)
//W sql to zapytanie wygladaloby tak: 
//SELECT * FROM uzytkownicy WHERE user=" OR id=7 -- ' AND pass='aaa'
//Krok po kroku:
//user=" OR id=7(przyjmie wartosc true, tylko jesli napotkamy usera o takim id)
//a po komentarzu -- wszystko jest ignorowane wiec samo znalezienie takiego id wystarczy zeby sie zalogowac

//Te powyzsze przyklady moga sluzyc do wejscie na kazde konto w bazie, i zbierania danych emailowych i innych
// Istnieja takze inne bardziej wyrafinowane metody ataku m.in. 
// z uzyciem klauzuli LIKE, UNION SELECT, ORDER BY(zeby znalezc osobe z najwieksza iloscia dni premium jak w przypadku naszej strony). 

//JAK OBRONIC SIE PRZED SQL INJECTION?
//Nigdy nie ufamy ciagom znakow, ktorze otrzymalismy od uzytkownika!
// Do tego sluzy walidacja (sprawdzanie poprawnosci danych) oraz 
// sanityzacja (wyczyszczenie danych z potencjalnie niebezpiecznych zapisow) takich jak podwojne myslniki czy apostrofy w mySql
//Na poczatek dokonamy przepuszczenia login oraz hasla przez funkcje: htmlentities()
//Przejdz do else ponizej (tam gdzie zbieramy dane logowania): $login=$_POST['login'];...


//SKRYP zaloguj.php: 

session_start(); // nie musimy zamykac, kazdy dokument musi posiadac ta instrukcje zeby dzialac z tablicy globalnej _SESSION['user'] ponizej
//musimy to takze dodac do pliku gra.php

//zeby ktos nie dostal sie na strone bez podawania ani loginu ani hasla musimy sprawdzic czy zmienne login i haslo zostaly wpisane w ogole:
//dlatego sprawdzamy czy login i haslo zostaly ustalone: 
if((!isset($_POST['login'])) || (!isset($_POST['haslo']))) //jezeli nie jest ustawiona w globalnej tablicy $_POST zmiena o nazwie ['login'] lub ['haslo'] to wtedy przekieruj do index.php
{
	header('Location: index.php'); //jesli nie istnieja takie zmienne to przekierowujemy od razu do index.php na start bez uruchamiania skryptu 
	exit(); // exit: wychodzimy nie przetwazajac dalej skryptu
}


require_once "connect.php"; // Funkcja require jest w zasadzie indentyczna do include, jedynie inaczej obsluguje sytuacje wyjatkowe. Gdy wlaczanego pliku nie da sie otworzyc, to include wygeneruje
//tylko ostrzezenie , a skrypt bedzie sie dalej wykonywac. Zas require wygeneruje blad krytyczny i dalsze wykonywanie skryptu zostanie wstrzymane. Czyli w skrocie: 
// include=wlacz plik do zrodla  / require=wymagaj pliku w kodzie
//require vs require_one (include vs include_once)
//Dopisanie _once nie mzienia ogolnej zasady dzialania funkcji, a jedynie sprawia, iz PHP przy wlaczaniu pliku do kodu dodatkowo sprawdzi, czy ten plik nie zostal juz dolaczony wczensiej w dokumencie. 
//Jesli tak, to dolaczane linie nie zostana ponownie wklejone w plik. 

$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno!=0) //connect_errno rowny zero (true) oznacza, iz ostatnio podjeta proba polaczenia sie z baza zakonczyla sie sukcesem
{//jesli polaczenie uda nam sie ustanowic to ten if z gory sie nie spelni 
	echo "Error: ".$polaczenie->connect_errno; // mozna dodac jeszcze informacje ale spowoduje to ze ktos obcy bedzie znal nasza nazwe  ."Opis:".$polaczenie->connect_errono;
}// @ - tym znakiem wyciszamy ostrzezenia php
else
{
	$login=$_POST['login'];
	$haslo=$_POST['haslo'];
	

	
	//tutaj wykonujemy zabezpieczenie przed SQL INJECTION:
	//Uzyjemy do tego htmlentities()- encji html (zastepczy zestaw znakow, ktory przegladarka jako ten sam znak ktory zastepuje encja, ale zrozumie to jako cos nie bedacego czesciom kodu zrodlowego )
	$login=htmlentities($login, ENT_QUOTES, "UTF-8"); //przepuszczamy nasz "login" przez funkcje filtrujaca
	//a dlatego ze poslugujemy sie zestawem znakow UTF-8 to musimy to tez zapisac 
	//jako ENT_QUOTES, "UTF-8", wiecej o encjach w tutorialu Zelent php 2odc.
	//Teraz to samo co powyzej robimy z "haslo":
	$haslo=htmlentities($haslo, ENT_QUOTES, "UTF-8"); 
	//Przyklad encji: "&lt;" zastepuje znak "<"
	//w naszej grze Osadnicy nicki adminow sa zapisane wytluszczona czcionka , 
	//sprytny gracz strzy takie konto: <b>ToJaAdmin</b> i moze podac sie za admina,
	//ale jesli przepuscimy ten nick przez htmlentities() otrzymamy:
	// "&lt;b&gt;ToJaAdmin&lt;/b&gt; i problem znika :) 
	//Innym sposobem uzycia encji do zabezpieczenia naszej strony kiedy ktos uzywa np.
	//wklejania komend w komentarzach na youtube na przyklad takiej jak <script>document.write("pwnd by zero cool");>/script>
	//Przegladarka wtedy zrozumie, ze jest to skrypt i wtedy wszyscy uzytkownicy wchodzacy
	//na strone filmu zobacza taki napis "pwnd by zero cool". 
	//Na szczescie mozemy przepuscic to tez przez htmlentities() wtedy ten zapis nie bedzie juz dla przegladarki skryptem js
	//Juz na poziomie rejestracji do naszej strony nalezy uzyc encji htmlentities() zeby pozbyc sie problemow z wlamaniem na nasza strone poprzez skrypty albo sql injection
	//Dodatkowo musimy usmiescic cale zapytanie sql w funkcji sprintf() jak ponizej:
	//( Do tego zamiast zmiennej "$login" i "$haslo" zapiszemy : "%s" w obu przypadkach), a na koncu dwa argumenty:
	// "mysqli_real_escape_string($polaczenie,$login)," i "mysqli_real_escape_string($polaczenie,$haslo)
	
	
	if($rezultat=@$polaczenie->query(
	sprintf("SELECT * FROM uzytkownicy WHERE user='%s' AND pass='%s'",//sprintf()wprowadza porzadek, w "%s" bedzie znajdowac sie zmienna
	//Funkcji mysqli_real_escape_string() powinnismy uzyc na kazdym ciagu znakow,
	//ktory otrzymalismy od uzytkownika i ktorego uzywamy w zapytaniu SQL. 
	//Zabezpiecza ona nasza baze przed wstrzykiwaniem SQLa. Posiada dwa argumenty (tutaj: $polaczeni i $login)
	mysqli_real_escape_string($polaczenie,$login),
	mysqli_real_escape_string($polaczenie,$haslo)))) 
	 //jesli rezultat zapytania jest rowny polaczenie z metoda query( kwerenda ) z argumentem $sql ( zapytanie )
	{//jesli zapytanie nie bedzie moglo zostac wykonane bo byla na przyklad w nim literowka to zmienna $rezultat przyjmie automatycznie wartosc false i if sie nie spelni
	
		//Wyciaganie wartosci z poszczegolnych kolumn tabeli: 

		$ilu_userow=$rezultat->num_rows; //po wyslaniu zapytania sql do bazy musimy dowiedziec sie ile rekordow zwrocila baza, zero czy jeden? 
		//num_rows znaczy ilosc wierszy zwroci z bazy, jeden czy zero w tym przypadku
		if($ilu_userow>0) // jesli znaleziono uzytkownika czyli ilu_userow>0 to znaczy ze udalo sie komus wlasnie zalogowac 
		{
			//tutaj wstawiamy zmienna ktora mowi czy uzytkownik jest zalogowany:
			$_SESSION['zalogowany']=true;//najpierw ustawiamy tzw flage ze jestesmy zalogowani


			$wiersz=$rezultat->fetch_assoc(); //jeden rekord z bazy jako zmienna $wiersz 
			// $wiersz jest rowny wartosci $rezultat, 
			// fetch_assoc() to funkcja tworzy tablice asosjacyjna (skojarzeniowa) do ktorej zostana powkladane zmienne o takich samych nazwach jak nazwy kolumn w naszej bazie danych
			// fetch znaczy pobierz, haslo usera mozemy odczytac z takiej tablicy potem za pomoca komendy $wiersz['pass']
			

			//dodatkowo mozemy sobie wlozyc do sesji takze id uzytkownika, dzieki temu bedziemy wiedzieli kto jest zalogowany
			$_SESSION['id']=$wiersz['id'];


			//$user=$wiersz['user']; //wyciagamy wartosc z tab assocjacyjnej o nazwie $wiersz z szufladki o nazwie ['user']
			//zamiast gornego kodu uzyjemy tego poniewaz chcemy zeby wartosc $user byla wartoscia globalna tak zebysmy mogli ja wykorzystac w gra.php:
			//do tego stworzymy tzw sesje, 
			$_SESSION['user']=$wiersz['user']; //_SESSION['USER'] jest takze tablica asocjacyjna,
			// zeby sesja dzialala trzeba na samym poczatku dokumentu dodac funkcje session_start();


			//teraz wyciagamy z tablicy reszte danych jak drewno, kamien, zboze , email, dni premium:
			$_SESSION['drewno']=$wiersz['drewno'];
			$_SESSION['kamien']=$wiersz['kamien'];
			$_SESSION['zboze']=$wiersz['zboze'];
			$_SESSION['email']=$wiersz['email'];
			$_SESSION['dnipremium']=$wiersz['dnipremium'];
			//teraz nalezy zapisac ich wyjmowanie z bazy w pliku gra.php


			// Jesli udalo sie nam zalogowac mozemy usunac zmienna blad z sesji bo jest juz niepotrzena, bo odnosi sie tylko do sytuacji kiedy uzytkownik wpisal zle haslo lub login a nie sie juz zalogowal
			unset($_SESSION['blad']);// Funkcja unset znaczy:usun, przeciwienstwem jest funkcja set(ustaw). 
			
			//pozbywamy sie z pamieci niepotrzebnych rezultatow zapytania 
			$rezultat->close(); // zamykamy metode ,mozemy uzyc tez metody free() albo free_result()
			//echo $user; //sprawdzamy czy dziala, jesli tak to powinny sie pojawic imie usera sciagniete z baz danych 
			
			//teraz musimy przekierowac uzytkownika do strony gra.php:
			header('Location: gra.php'); //ta jedna linijka starczy do przekierowania

		}	
		else // jesli nie znaleziono to znaczy ze nie ma nikogo w bazie o podanych login i haslo
		{
			$_SESSION['blad']='<span style="color:red">Nieprawidlowy login lub haslo!</span>';
			
			//po pokazaniu informacji o bledzie przenosimy uzytkownika do strony logowania:
			header('Location: index.php');
			//ale zeby index.php mogl odczytac zawartosc zmiennej $_SESSION musimy takze dodac do pliku index.php tagi php funkcji session_start  
		
		
		}	
		
	}
	
	$polaczenie->close();
}






?>
