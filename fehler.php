<?php
include_once('open.php');
if(isset($_GET['artikel'])) {
    $_SESSION['meldung'] = 'Sie müssen sich als Administrator anmelden, um einen Artikel hinzufügen zu können!';
}
if(isset($_GET['regerror'])) {
    $_SESSION['meldung'] = 'Sie sind bereits registriert und angemeldet!';
}
if(isset($_GET['waren'])) {
    $_SESSION['meldung'] = 'Sie sind nicht angemeldet! Melden Sie sich an, um Ihren Warenkorb anzeigen zu lassen';
}
$info->gui->createGui();
$info->reload();
?>
