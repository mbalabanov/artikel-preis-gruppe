<?php
$dbHost="localhost";
$dbCharset="utf8";
$dbName="kurs";
$dbUser="kursuser";
$dbPw="123x";

try
{	
	//Ein Verbindungs-Objekt aus der Klasse PDO erstellen
	//dieses hält zahlreiche "hauseigene" Funktionen (Methoden) bereit query, fetch...
	$db=new PDO(
		"mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset",
		$dbUser,
		$dbPw
		);

	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
	//Bei Fehlschlagen der Verbindung
	exit("Keine Verbindung zur Datenbank");
}
?>