<?php 
    include "php/Billet.php";
    $billet = new Billet;
    if(! empty($_POST)) {
        /*mode création-modification*/
        // var_dump($_POST); die;
        switch($_POST['case']) {
            case 'create-category' :
                // addCategory($db, $_POST['titre'], $_POST['parent'], $_POST['description']);
                queryAdd($db, 'category', [] );
                break;
            case 'create-user' :
                // addUser($db, $_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['role'], $_POST['password']);
                queryAdd($db, 'users', $_POST);
                break;
            case 'create-billet' :
                // addBillet($db, $_POST['titre'], $_POST['author'], $_POST['texte']);
                break;
        }
        $template = 'templates/home.phtml';
    } 
    elseif(! empty($_GET)) {
        /*mode consultation*/
        switch($_GET['case']) {
            case 'create-user' :
                $template = 'templates/userForm.phtml';
                break;
            case 'create-category' :
                $template = 'templates/categoryForm.phtml';
                break;
            case 'list-user' :
                $user = displayUser($db);
                $template = 'templates/userList.phtml';
                break;
            case 'create-billet' :
                $user = displayUser($db);
                $template = 'templates/billetForm.phtml';
                break;
            default:
                $template = 'templates/home.phtml';
            case 'list-billet' :
                $affichage = $billet->findAll($db);
                $template = 'templates/billetList.phtml';
                break;
            case 'single-billet' :
                $singleAffichage = displayBilletSingle($db, $_GET['id_billet']);
                $template = 'templates/billetSingle.phtml';
                break;
        }
    } 
    else {
        // var_dump($_GET); die;
        /*afficher la page d'accueil*/
        $template = 'templates/home.phtml';
    }

?>