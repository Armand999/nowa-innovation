<?php
ob_start() ;
if(isset($_GET['page'])){
    $page = $_GET['page'] ;
} else { 
    $page = '';
}
switch($page) :
    case '' :
           // On ajoute une variable pour le tite de la page accueil
           $title = "Nowa Innovation :: Accueil" ;
        include 'pages/2.home.php' ;
    break;
    case 'faq' :
           // On ajoute une variable pour le tite de la page test
           $title = "Nowa Innovation :: FAQ" ;
        include 'pages/3.FAQ.php' ;
    break;

    case 'tarifs' :
           // On ajoute une variable pour le tite de la page test
           $title = "Nowa Innovation :: Tarifs" ;
        include 'pages/4.tarfis.php' ;
    break;
    case 'contact' :
           // On ajoute une variable pour le tite de la page test
           $title = "Nowa Innovation :: Contacts" ;
        include 'pages/6.contact.php' ;
    break;
    case 'test' :
           // On ajoute une variable pour le tite de la page test
           $title = "Nowa Innovation :: test" ;
        include 'pages/7.CTA.php' ;
    break;
   
    default :
           // On ajoute une variable pour le tite de la page par defaut
           $title = "Site perso :: Accueil" ;
           include 'pages/2.home.php' ; 
    break;
endswitch ;
$contenu = ob_get_clean() ;
include 'template/template.php' ;



?>