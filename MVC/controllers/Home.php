<?php

class home extends Controller{
    public function index(){

        // On utilise la méthode render() du controleur principal en donnant en paramètre le nom du fichier à utiliser
        $this->render('index');
    }
}