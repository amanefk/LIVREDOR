<?php

session_start();
session_regenerate_id();

include('view/commun/header.php');


$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';
$pages_valides = ['accueil', 'livreDor', 'consultation'];

if (!in_array($page, $pages_valides)) {
    $page = 'accueil';
}

switch($page){
    case 'livreDor':
        include('view/livreDor.php');
        break;
    case 'consultation':
        include('view/consultation.php');
        break;
    default:
        include('view/accueil.php');
        break;
}

include('view/commun/footer.php');
?>
