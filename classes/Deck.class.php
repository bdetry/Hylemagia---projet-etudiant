<?php
class Deck{
 /**
     * --------------------------------------------------
     * PROPRIETES
     * --------------------------------------------------
**/
    private $dck_id;
    private $dck_date;
    private $user_id;
    private $univ_id;
    private $name;
    private $dck_cards = [] ;


 /**
     * --------------------------------------------------
     * CONSTRUCTEUR
     * --------------------------------------------------
    **/

    /**
     * --------------------------------------------------
     * ACCESSEURS
     * --------------------------------------------------
    **/

    public function setId($dck_id) { $this->dck_id= $dck_id; }
    public function setDate($dck_date) { $this->dck_date= $dck_date; }
    public function setUser($user_id) { $this->user_id= $user_id; }
    public function setUniv($univ_id) { $this->univ_id= $univ_id; }
    public function setDeckCards($dck_cards) {  $this->dck_cards= $dck_cards; }
    public function setName($name) { $this->name= $name; }


    public function getId() { return $this->dck_id; }
    public function getDate() { return $this->dck_date; }
    public function getUser() { return $this->user_id; }
    public function getUniv() { return $this->univ_id; }
    public function getName() { return $this->name; }
    public function getCards() { return $this->dck_cards; }



     /**
     * --------------------------------------------------
     * METHODES MAGIQUES
     * --------------------------------------------------
    **/
 }
