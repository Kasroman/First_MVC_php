<?php
// Pour éviter qu'a chaque instanciation de modèle dans un controleur on fasse son require dans le modèle on va utiliser ce controleur central
// Les require sont appelés dans index.php

// Une classe abstraite ne peut pas être instanciée (ne peut pas créer d'objet) et n'ont donc pas de constructeurs "__construct()"
// Elles sont faite pour être dérivées par d'autres classes "concrètes" qui hériteront des propriétés et méthodes de la classe abstraite
abstract class Controller{

    // On créer une méthode qui permet de charger un modèle de nom $model (on s'assure que c'est une chaine de caractères)
    public function loadModel(string $model){

        // Voir index.php pour ROOT
        // On concatène le chemin pour charger le modèle de nom $model et d'extension .php
        // require_once inclut et execute le fichier spécifié
        require_once(ROOT . 'models/' . $model . '.php');

        // On remplace la variable donnée en paramètre de la méthode par l'instance de ce modèle (qui est une classe)
        $this->$model = new $model();
    }

    // On créer une fonction qui appelle le fichier $file dans les vues correspondant au controleur utilisé
    // Un met un paramètre $data dans lequel on donne les données pour la page par la même occasion
    public function render(string $file, array $data = []){
    
        // !!!!!!!!!!!!!!!!!!!!!!!! PAS COMPRIS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // !!!!!!!!!!!! extract() censé extraire et créer des variables ????? !!!!!!!!!!
        extract($data);

        // On créer un "buffer" de sortie qui permet d'intercepter et de conserver tout ce qui va être envoyer à l'affichage
        // Il va intercepter et conserver toutes les commandes entre start et flush
        ob_start();

        // Permet d'inclure et d'executer la vue en mettant en minuscule le nom de la classe utilisée à l'appel de la méthode et donc de créer le chemin pour aller chercher le fichier $file dans le dossier dans views qui a le même nom que le controleur
        require_once(ROOT . 'views/' . strtolower(get_class($this)) . '/' . $file . '.php');

        // ob_get_clean() Permet de transferer tout ce que contient le buffer et de l'affecter à une variable ($content)
        $content = ob_get_clean();

        // on inclut et on execute le template
        require_once(ROOT . 'views/layouts/base.php');
    }
} 
