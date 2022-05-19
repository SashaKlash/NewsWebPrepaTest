<?php

use NewsWeb\Manager\theuserManager;

if (isset($_GET["disconnect"]) || $_SESSION["idSession"] !== session_id()) {
    theuserManager::disconnect();
    header("Location: ./");
    die();
} else {
    /*
    echo "<h1>You are logged in!</h1><pre>";
    var_dump($_SESSION);
    echo "</pre><p><a href='?disconnect'>Logout?</a></p>";
    // ici l'appel de la vue Twig (private homepage)
    */
    //var_dump($_SESSION);
    echo $twig->render("private/homepage.template.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session' => $_SESSION,
    ]);
}