<?php
class Card{
 /**
     * --------------------------------------------------
     * PROPRIETES
     * --------------------------------------------------
}
**/
    private $crd_id;
    private $crd_name;
    private $crd_decrip;
    private $crd_available;
    private $crd_manas;
    private $crd_hp;
    private $crd_attack;
    private $crd_type;
    private $univ_id;
    private $img_id;
    private $inGameId;

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

    public function setId($crd_id) { $this->crd_id= $crd_id; }
    public function setName($crd_name) { $this->crd_name= $crd_name; }
    public function setDecrip($crd_decrip) { $this->crd_decrip= $crd_decrip; }
    public function setAvailable($crd_available) { $this->crd_available= $crd_available; }
    public function setManas($crd_manas) { $this->crd_manas= $crd_manas; }
    public function setHp($crd_hp) { $this->crd_hp= $crd_hp; }
    public function setAttack($crd_attack) { $this->crd_attack= $crd_attack; }
    public function setType($crd_type) { $this->crd_type= $crd_type; }
    public function setUniv($univ_id) { $this->univ_id= $univ_id; }
    public function setImg($img_id) { $this->img_id= $img_id; }
    public function setInGameId($val) { $this->inGameId= $val; }


    public function getId() { return $this->crd_id; }
    public function getName() { return $this->crd_name; }
    public function getDecrip() { return $this->crd_decrip; }
    public function getAvailable() { $this->crd_available= $crd_available; }
    public function getManas() { return $this->crd_manas; }
    public function getHp() { return $this->crd_hp; }
    public function getAttack() { return $this->crd_attack; }
    public function getType() { return $this->crd_type; }
    public function getUniv() { return $this->univ_id; }
    public function getImg() { return $this->img_id; }
    public function getInGameId() { return $this->inGameId; }



     /**
     * --------------------------------------------------
     * METHODES MAGIQUES
     * --------------------------------------------------
    **/
 }


