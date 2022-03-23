<?php

// On créer une constante ROOT qui contient le chemin vers index.php
// On remplace index.php par rien
// $_SERVER est une variable super-globale du serveur, elle contient le chemin vers index.php sous le nom SCRIPT_FILENAME
// exemple die(ROOT) --> C:/xampp/htdocs/MVC/ (Chemin vers mon index.php)
define('ROOT', str_replace('index.php','', $_SERVER['SCRIPT_FILENAME']));

// J'appelle mon modèle et mon controleur principal'
require_once(ROOT . 'app/Model.php');
require_once(ROOT . 'app/Controller.php');

// On sépare les paramètres dans $params[] 
// exemple : localhost/je/test/les/params --> array(4) { [0]=> string(2) "je" [1]=> string(4) "test" [2]=> string(3) "les" [3]=> string(6) "params" }
$params = explode('/', $_GET['p']);

// On vérifier l'existence d'un paramètre
if($params[0] !== ""){

    //ucfirst() pour mettre la premiere lettre en maj, les Controlleurs etant par convention écrit avec une maj
    $controller = ucfirst($params[0]);

    //isset() Détermine si une variable est déclarée et est différente de null // si $params[1] existe retourne $params[1] sinon 'index'
    $action = isset($params[1]) ? $params[1] : 'index';
   
    //require_once comme require mais si le fichier est déjà inclus il ne l'inclut pas une deuxieme fois
    // Par ROOT ce qui permet d'avoir le chemin direct et on concatène un chemin avec le controller
    require_once(ROOT . 'controllers/' . $controller . '.php');

    // On remplace la variable $controller par l'instance de ce controleur (qui est une classe) issu du paramètre de l'url
    // exemple : $articles = new Articles();
    $controller = new $controller();

    // method_exists (très explicite) permet de vérifier si une méthode existe dans un objet classe avec en param l'objet et la méthode
    // exemple : Pour $controller = Articles et $action = 'index' on vérifie que la classe Articles a bien une méthode index();
    
    if(method_exists($controller, $action)){

        // // On récupère la méthode $action() de l'objet $controller instancié
        // // exemple : $articles -> index();
        // $controller->$action();
        
        // Fait la même chose que $controller->$action(); commenté au dessus sous forme de tableau mais permet d'y ajouté un/des paramètre(s)
        // On enlève des paramètres avec unset() car $params contient encore le controleur et l'action
        unset($params[0]);
        unset($params[1]);
        call_user_func_array([$controller, $action], $params);
    }else{

        // Si la méthode n'existe pas on renvoie une erreur 404 avec un message
        http_response_code(404);
        echo 'La page demandée n\'existe pas';
    }
}else{

}
