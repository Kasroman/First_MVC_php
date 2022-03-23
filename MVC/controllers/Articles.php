<?php

// Le controleur qui gère les articles
// Les require sont appelés dans index.php, il n'y a pas a les gérer ici puisque le controleur Articles hérite de la classe abstraite Controller
class Articles extends Controller{

    // Une méthode pour récupérer l'index d'une table de bdd, càd tous les enregistrement et les envoyer a une vue
    public function index(){

        // On utilise la méthode du parent Controller pour charger le modèle Article
        $this->loadModel('Article');

        // On utilise la méthode getAll() du Model de Model.php
        // fetchAll() retourne un tableau contenant toutes les lignes d'enregistrement de la table articles de la bdd
        $articles = $this->Article->getAll();
        
        // On utilise la méthode render() du controleur principal en donnant en paramètre le nom du fichier à utiliser
        // On donne aussi les données récupérées dans la bdd avec getAll() avec le second paramètre
        // On peut aussi écrire $this->render('index', compact('articles'));
        $this->render('index', ['articles' => $articles]);
    }

    // Une méthode pour récupérer un seul enregistrement par son id depuis la bdd et l'envoyer a une vue de la même manière
    public function read($slug){
        $this->loadModel('Article');
        $article = $this->Article->findBySlug($slug);
        $this->render('read', ['article' => $article]);
    }
}


