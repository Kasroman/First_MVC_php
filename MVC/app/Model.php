<?php

// Une classe abstraite ne peut pas être instanciée (ne peut pas créer d'objet) et n'ont donc pas de constructeurs "__construct()"
// Elles sont faite pour être dérivées par d'autres classes "concrètes" qui hériteront des propriétés et méthodes de la classe abstraite mais qui devront absolument les redéfinir.
abstract class Model {

    // Informations de connexion à la bdd
    // Variables private car informations sensibles et donc inaccessibles en dehors de la classe
    private $host = "localhost";
    private $port = "3307";
    private $db_name = "mvc";
    private $username= "root";
    private $password = "";

    // Propriété de connexion
    // Variable protected car on va devoir y avoir accès dans les classes qui vont en hériter
    protected $_connection;

    // Propriété de requêtes
    public $table;
    public $id;

    public function getConnection(){

        // On efface la connexion précédente pour eviter des connexions en parallèle
        $this->_connection = null;

        try {

            // L'extension PDO est une interface pour accéder a une base de données avec PHP
            // Pour se connecter a une bdd mysql : 'mysql:host=host;dbname=mabase;charset=utf8', 'username', 'psw'
            // On concatène donc l'adresse en y incluant nos variables
            // $this->_connection = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->db_name, $this->username, $this->password);
            $this->_connection = new PDO('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name , $this->username, $this->password);

            // execute une requête sql qui vérifie que ce soit de l'utf8 et non de l'ASCII ou autre
            $this->_connection->exec('set names utf8');


        }catch(PDOException $exception){
            // On lève l'exception et on l'affiche
            echo 'Erreur : ' . $exception->getMessage();
        }
    }

    // methode de requête sql qui permet de chercher tous les enregistrements
    public function getAll(){

        // Selectionne la table de nom $table
        $sql = "SELECT * FROM " . $this->table;

        // Prépare la requête
        // Retourne false sur le serveur ne parvient pas à préparer la requête
        // Retourne un objet PDOStatement qui est une requête préparée si il y parvient
        $query = $this->_connection->prepare($sql);

        // L'execute
        $query->execute();

        // fetchAll() retourne un tableau contenant toutes les lignes d'enregistrement de la requête
        return $query->fetchAll();
    }

    public function getOne(){

        // Cette fois on utilise WHERE pour n'extraire que les lignes de l'id donné
        $sql = "SELECT * FROM " . $this->table . "WHERE id=" . $this->id;
        $query = $this->_connection->prepare($sql);
        $query->execute();

        // On fetch simplement ici
        return $query->fetch();
    }
}