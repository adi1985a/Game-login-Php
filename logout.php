<?php
//strona do wylogowywania

session_start();

session_unset(); //niszczy cala sesje, nalezy takze przekierowac uzytkownika na strone glowna index.php
header('Location: index.php');


?>


