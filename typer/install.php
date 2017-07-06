<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Install</title>
</head>
<body>
<?php
require 'vendor/autoload.php';

use Config\Database\DBConfig as DB;
DB::setDBConfig();
$pdo = DB::getHandle();


/*Tworzenie tabeli uzytwkonik-----------------------------------------------------------*/


$query = "CREATE TABLE IF NOT EXISTS `uzytkownik`(
`idUser` INT AUTO_INCREMENT PRIMARY KEY,
`login` VARCHAR(50) NOT NULL,
`haslo` VARCHAR (50) NOT NULL,
`email` VARCHAR(50) NOT NULL
)";
try {
    $pdo->exec($query);
   //echo nl2br("Utworzono tabele uzytkownik\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli uzytkownik";
}

/*Tworzenie tabeli Access-----------------------------------------------------------*/


$query = "CREATE TABLE IF NOT EXISTS `access`(
`idAccess` INT AUTO_INCREMENT PRIMARY KEY,
`nazwaAccess` VARCHAR(50) NOT NULL
)";
try {
    $pdo->exec($query);
   // echo nl2br("Utworzono tabele  Assess\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli access";
}

/*Tworzenie tabeli accessUser-----------------------------------------------------------*/



$query = "CREATE TABLE IF NOT EXISTS `accessUser` (
		`idAccessUser` INT AUTO_INCREMENT PRIMARY KEY,
		`idUser` INT NOT NULL,
		`idAccess` INT NOT NULL,
		FOREIGN KEY (idUser) REFERENCES uzytkownik(idUser),
		FOREIGN KEY (idAccess) REFERENCES access(idAccess)
		)";

try {
    $pdo->exec($query);
   // echo nl2br("Utworzono tabele accessUser\n");
}
catch(PDOException $e){
    $error =$pdo->errorInfo();
    echo "błąd: ".$error[2];
}

/*Tworzenie tabeli sezon-----------------------------------------------------------*/


$query = "CREATE TABLE IF NOT EXISTS `sezon`(
`idSezon` INT AUTO_INCREMENT PRIMARY KEY,
`dataRozpoczecia` DATE NOT NULL,
`dataZakoncznia` DATE NOT NULL,
`nazwaSezonu` VARCHAR(50) NOT NULL,
`status` INT NOT NULL
)";
try {
    $pdo->exec($query);
   // echo nl2br("Utworzono tabele sezon\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli sezon";
}


/*Tworzenie tabeli kolejka-----------------------------------------------------------*/


$query = "CREATE TABLE IF NOT EXISTS `kolejka`(
`idKolejka` INT AUTO_INCREMENT PRIMARY KEY,
`numerKolejki` INT NOT NULL,
`status` INT NOT NULL,
`idSezon` INT NOT NULL,
FOREIGN KEY (idSezon) REFERENCES sezon(idSezon)
)";
try {
    $pdo->exec($query);
   // echo nl2br("Utworzono tabele kolejka\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli kolejka";
}


/*Tworzenie tabeli mecz-----------------------------------------------------------*/


$query = "CREATE TABLE IF NOT EXISTS `mecz`(
`idMecz` INT AUTO_INCREMENT PRIMARY KEY,
`dataMeczu` DATE NOT NULL,
`godzinaRozpoczecia` TIME NOT NULL,
`gospodarzNazwa` VARCHAR(50) NOT NULL,
`goscNazwa` VARCHAR(50) NOT NULL,
`league` VARCHAR(50),
`golGospodarz` INT  NULL,
`golGosc` INT NULL,
`idKolejka` INT NOT NULL,
FOREIGN KEY (idKolejka) REFERENCES kolejka(idKolejka)
)";
try {
    $pdo->exec($query);
    //echo nl2br("Utworzono tabele mecz\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli mecz";
}

/*Tworzenie tabeli typNaMecz-----------------------------------------------------------*/


$query = "CREATE TABLE IF NOT EXISTS `typNaMecz`(
`idTyp` INT AUTO_INCREMENT PRIMARY KEY,
`typGospodarz` INT NULL,
`typGosc` INT NOT,
`Punkty` INT NOT NULL,
`idUser` INT NOT NULL,
`idMecz` INT NOT NULL,
FOREIGN KEY (idUser) REFERENCES uzytkownik(idUser),
FOREIGN KEY (idMecz) REFERENCES mecz(idMecz)
)";
try {
    $pdo->exec($query);
   // echo nl2br("Utworzono tabele typNaMecz\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli typNaMecz";
}

/*Tworzenie tabeli team-----------------------------------------------------------*/

$query = "CREATE TABLE IF NOT EXISTS `team`(
`idTeam` INT AUTO_INCREMENT PRIMARY KEY,
`nazwaDruzyny` VARCHAR(100) NOT NULL
)";
try {
    $pdo->exec($query);
    //echo nl2br("Utworzono tabele team\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli team";
}

/*Tworzenie tabeli league-----------------------------------------------------------*/

$query = "CREATE TABLE IF NOT EXISTS `league`(
`idLeague` INT AUTO_INCREMENT PRIMARY KEY,
`nazwaLeague` VARCHAR(100) NOT NULL
)";
try {
    $pdo->exec($query);
    //echo nl2br("Utworzono tabele league\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli league";
}

/*Tworzenie tabeli Klasyfikacja-----------------------------------------------------------*/

$query = "CREATE TABLE IF NOT EXISTS `klasyfikacja`(
`idKlasyfikacja` INT AUTO_INCREMENT PRIMARY KEY,
`idSezon` INT NOT NULL,
FOREIGN  KEY (idSezon) REFERENCES sezon(idSezon)
)";
try {
    $pdo->exec($query);
    // echo nl2br("Utworzono tabele klasyfikacja\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli klasyfikacja";
}

/*Tworzenie tabeli Pozycja-----------------------------------------------------------*/

$query = "CREATE TABLE IF NOT EXISTS `pozycja`(
`idPozycja` INT AUTO_INCREMENT PRIMARY KEY,
`Punkty` INT NOT NULL,
`Miejsce` INT NOT NULL,
`idUser` INT NOT NULL,
`idKlasyfIkacja` INT NOT NULL,
FOREIGN  KEY (idUser) REFERENCES uzytkownik(idUser),
FOREIGN  KEY (idKlasyfikacja) REFERENCES klasyfikacja(idKlasyfikacja)
)";
try {
    $pdo->exec($query);
   // echo nl2br("Utworzono tabele klasyfikacja\n");
}
catch(PDOException $e){
    echo "Wystapil blad polaczenia z baza danych podczas tworzenia tabeli pozycja";
}

/*---------------wstawianie wartości do tabeli access-----------------------------------*/

$kol = array();
$kol[] = 'Gosc';
$kol[] = 'Administrator';
try{
    $stmt = $pdo -> prepare('INSERT INTO `access` (`nazwaAccess`) VALUES(:nazwaAccess)');
    foreach($kol as $nazwa){
        $stmt -> bindValue(':nazwaAccess', $nazwa, PDO::PARAM_STR);
        $stmt -> execute();
    }
    echo nl2br("Wpisano wartosci w tabele access!\n");
}
catch (PDOException $e){
    echo 'Wystapil blad polaczenia z baza';
}
/*---------------wstwienie druzy do tabeli team-----------------------------------*/

$kol = array();
$kol[] = 'Chelsea';
$kol[] = 'Arsenal';
$kol[] = 'Liverpool';
$kol[] = 'Manchester City';
$kol[] = 'Tottenham Hotspur';
$kol[] = 'Manchester United';
$kol[] = 'West Bromwich Albion';
$kol[] = 'Everton';
$kol[] = 'Stoke City';
$kol[] = 'Bournemouth';
$kol[] = 'Watford';
$kol[] = 'Southampton';
$kol[] = 'Middlesbrough';
$kol[] = 'Crystal Palace';
$kol[] = 'Burnley';
$kol[] = 'Leicester City';
$kol[] = 'West Ham United';
$kol[] = 'Sunderland';
$kol[] = 'Hull City';
$kol[] = 'Swansea City';
$kol[] = 'Real Madryt';
$kol[] = 'Barcelona';
$kol[] = 'Sevilla FC';
$kol[] = 'Atletico Madryt';
$kol[] = 'Villarreal CF';
$kol[] = 'Real Sociedad';
$kol[] = 'Athletic Bilbao';
$kol[] = 'Eibar';
$kol[] = 'Celta Vigo';
$kol[] = 'UD Las Palmas';
$kol[] = 'Malaga';
$kol[] = 'Espanyol Barcelona';
$kol[] = 'Deportivo Alaves';
$kol[] = 'Betis Sevilla';
$kol[] = 'CD Leganes';
$kol[] = 'Deportivo';
$kol[] = 'Valencia CF';
$kol[] = 'Sporting Gijon';
$kol[] = 'Granada CF';
$kol[] = 'Osasuna';
$kol[] = 'Jagiellonia Białystok';
$kol[] = 'Lechia Gdańsk';
$kol[] = 'Termalica Nieciecza';
$kol[] = 'Legia Warszawa';
$kol[] = 'Lech Poznań';
$kol[] = 'Zagłębie Lubin';
$kol[] = 'Pogoń Szczecin';
$kol[] = 'Wisła Kraków';
$kol[] = 'Arka Gdynia';
$kol[] = 'Korona Kielce';
$kol[] = 'Śląsk Wrocław';
$kol[] = 'Piast Gliwice';
$kol[] = 'Cracovia';
$kol[] = 'Wisła Płock';
$kol[] = 'Ruch Chorzów';
$kol[] = 'Górnik Łęczna';


try{
    $stmt = $pdo -> prepare('INSERT INTO `team` (`nazwaDruzyny`) VALUES(:nazwaDruzyny)');
    foreach($kol as $nazwa){
        $stmt -> bindValue(':nazwaDruzyny', $nazwa, PDO::PARAM_STR);
        $stmt -> execute();
    }
    echo nl2br("Wpisano wartosci w tabele team!\n");
}
catch (PDOException $e){
    echo 'Wystapil blad polaczenia z baza';
}
/*---------------wstawianie nazw lig do tabeli league-----------------------------------*/

$kol = array();
$kol[] = 'Premier League';
$kol[] = 'Seria A';
$kol[] = 'LaLiga Santander';
$kol[] = 'Bundesliga';
$kol[] = 'Ligue 1';
$kol[] = 'Erendivisie';
$kol[] = 'Ekstraklasa';

try{
    $stmt = $pdo -> prepare('INSERT INTO `league` (`nazwaLeague`) VALUES(:nazwaLeague)');
    foreach($kol as $nazwa){
        $stmt -> bindValue(':nazwaLeague', $nazwa, PDO::PARAM_STR);
        $stmt -> execute();
    }
    echo nl2br("Wpisano wartosci w tabele league!\n");
}
catch (PDOException $e){
    echo 'Wystapil blad polaczenia z baza';
}
