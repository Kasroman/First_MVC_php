<?php

// Classe enfant qui etend la classe abstraite Model
class Article extends Model{

    // N'étant pas abstraite comme son parent, elle peut créer un objet et à donc une méthode __construct()
    // Elle reprend toutes les propriétés et les méthodes de son parent
    public function __construct(){
        $this->table = "articles";
        $this->getConnection();
    }

    // Methode pour faire un requête sql par la colonne slug (de la même manière que dans app/Model.php)
    public function findBySlug(string $slug){
        
        // !!!! FAIRE TRES ATTENTION AUX ESPACES ET AUX GUILLEMETS ICI !!!!
        $sql = "SELECT * FROM " . $this->table . " WHERE slug='" . $slug . "'"; 
        $query = $this->_connection->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
}