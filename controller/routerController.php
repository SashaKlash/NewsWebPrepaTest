<?php
// Use Global Manager
use NewsWeb\Manager\thesectionManager; // sections

use NewsWeb\Mapping\theuserMapping;

// gestionnaire de la table thesection
$thesectionManager = new thesectionManager($connectMyPDO);

// sélection de toutes les sections pour le menu
$thesectionMenu = $thesectionManager->SelectAllThesection();


// blog
if (isset($_GET['blog'])):
    echo $twig->render('public/blog.html.twig',[
        'menu'=>$thesectionMenu,
    ]);

// section
elseif(isset($_GET['section'])):
// si slug trouvé, contient un tableau associatif
$theSectionDatas = $thesectionManager->SelectOneThesectionBySlug($_GET['section']);

    // sinon ld résultat est un string
    if(is_string($theSectionDatas)):

        // appel de l'erreur 404
    else:
        // affichage de le section
        echo $twig->render('public/section.html.twig',[
            'menu'=>$thesectionMenu,
            'section'=>$theSectionDatas,
        ]);

    endif;

// ICI



// contact
elseif (isset($_GET['contact'])):
    if (isset($_POST["name"], $_POST["email"], $_POST["message"])) {
        $name    = theuserMapping::userEntryProtection($_POST["name"]);
        $email   = filter_var(theuserMapping::userEntryProtection($_POST["email"]), FILTER_VALIDATE_EMAIL);
        $message = theuserMapping::userEntryProtection($_POST["message"]);
        if (!empty($name) && !empty($email) && !empty($message)) {
            $mailToAdmin->from($email)->subject("Message de l'utilisateur $name")->text($message);
            $mailToCustomer->to($email)->subject("Merci $name pour votre message!")->text("Merci pour votre message sur notre site!
Nous vous répondrons dans les plus bref délai.");
            try {
                $mailer->send($mailToAdmin);
                $mailer->send($mailToCustomer);
            } catch (Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                $twig->addGlobal("name", $name);
                $twig->addGlobal("email", $email);
                $twig->addGlobal("message", $message);
                if (!PROD) {
                    echo "<script>alert('Une erreur est survenue! Veuillez réessayer')</script>";
                }
                else {
                    throw new Error($e);
                }
            }
        }
        else {
            $twig->addGlobal("name", $name);
            $twig->addGlobal("email", $email);
            $twig->addGlobal("message", $message);
        }
    }
    echo $twig->render('public/contact.html.twig',[
        'menu'=>$thesectionMenu,
        ]);
// homepage
else:
    echo $twig->render('public/homepage.html.twig',[
        'menu'=>$thesectionMenu,
        ]);
endif;