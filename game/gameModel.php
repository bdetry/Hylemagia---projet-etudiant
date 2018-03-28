<?php

class GameModel{
     private $pdo;

    public function __construct() {
        $this->pdo = SPDO::getInstance()->getDb();
    }

    /*Recupere Game ID
     *$pla_ID = string
     *return array
    */

    public function getMyGameId($pla_ID) {
        if(($resource = $this->pdo->prepare('SELECT * FROM game WHERE pla_id = :pla1id OR pla_id_PLAYER = :pla2id ORDER BY gam_id DESC'))!==FALSE) {
            if($resource->execute(["pla1id"=>$pla_ID , "pla2id"=>$pla_ID])) {
               if(($game = $resource->fetch(PDO::FETCH_ASSOC))!==FALSE) {
                    return $game;
                }
            }
        }
        return false;
    }

    /*Verif si une game est en cour
     *$gameid = string
     *return true si joueur 2 est present
    */
    public function gameIsFull($gameid) {
        if(($resource = $this->pdo->prepare('SELECT * FROM game WHERE gam_id = :gamID'))!==FALSE){
            if($resource->execute(["gamID"=>$gameid])){
               if(($game = $resource->fetch(PDO::FETCH_ASSOC))!==FALSE) {
                    if($game["pla_id_PLAYER"]!=NULL) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
        }
    }

    /*Regarde la derniere game en cour si le player 2 est absent
     *return array si joueur 2 est absent
    */
    public function isWaiting() {
        if(($resource = $this->pdo->prepare('SELECT * FROM game WHERE pla_id_PLAYER IS NULL LIMIT 1'))!==FALSE) {
            if($resource->execute()) {
               if(($array = $resource->fetch())!==FALSE) {
                    if(!is_null($array)) {
                        return $array;
                    }
                }
            }
        }
        return false;
    }


    /*Selectionne le deck du joueur dans la game
        *pla_id = string
        *return array
    */
    public function playerDeck($pla_id){
        if(($resource = $this->pdo->prepare('SELECT deck_id_fk FROM player WHERE pla_id = :id'))!==FALSE) {
            if($resource->execute(["id"=>$pla_id])) {
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE) {
                    return $array;
                }
            }
        }
        return false;
    }

      /*Selectionne les info du deck du joueur dans la game
        *deckId = array
        *return array
    */
    public function getDeckInfo($deckId) {
        if(($resource = $this->pdo->prepare('SELECT * FROM deck WHERE dck_id = :id'))!==FALSE) {
            if($resource->execute(["id"=>$deckId[0]["deck_id_fk"]])) {
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE) {
                    return $array;
                }
            }
        }
        return false;
    }

    public function getMyhand($game_id)
    {

    }

     /*Insert l'ID game dans la main du joueur
        *gameId = string
        *return last ID
    */
    public function newHand($gameId) {
        if(($resource = $this->pdo->prepare('INSERT INTO hand(gam_id) VALUES(:gam_id)'))!==FALSE) {
            if($resource->execute(["gam_id"=>$gameId])) {
                return $this->pdo->lastInsertId();
            }
        }
    }

    /*Verifie si la hand existe
        *gameId = string
        *return true si la Hand existe
    */
    public function handExists($gameId){
        if(($resource = $this->pdo->prepare('SELECT * FROM hand WHERE gam_id = :id'))!==FALSE) {
            if($resource->execute(["id"=>$gameId])) {
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE) {
                    if(empty($array)) {
                        return false;
                    }
                    else {
                        return $array;
                    }
                }
            }
        }
    }

    /*Recupere les données de hand
        *hand = string
        *return array
    */
    public function getHandCard($hand){
     if(($resource = $this->pdo->prepare('SELECT * FROM pool_in_hand WHERE hand_id = :id'))!==FALSE) {
            if($resource->execute(["id"=>$hand])) {
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE) {
                    if(!empty($array)) {
                        return $array;
                    }
                }
            }
        }
        return false;
    }


    /*Recupere les données du player
        *$me_pla_id = string
        *return array
    */
    public function getPlayerObj($me_pla_id){
        if(($resource = $this->pdo->prepare('SELECT * FROM player WHERE pla_id = :id'))!==FALSE) {
            if($resource->execute(["id"=>$me_pla_id])) {
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE) {
                    $player = new Player();
                    $player->setPlaId($array[0]["pla_id"]);
                    $player->setPlaManaPts($array[0]["pla_mana_pts"]);
                    $player->setPlaDeckId($array[0]["deck_id_fk"]);
                    $player->setPlaHPPts($array[0]["pla_hp"]);
                    return($player);
                }
            }
        }
        return false;
    }


     /*Recupere les cartes des players
        *$my_pla_id = string
        *$my_pla_id_opp = string
        *return array
    */
    public function cardsInGame($my_pla_id, $my_pla_id_opp){
         if(($resource = $this->pdo->prepare('SELECT * FROM game_card WHERE pla_id = :id OR pla_id = :idopp'))!==FALSE){
            if($resource->execute(["id"=>$my_pla_id , "idopp"=>$my_pla_id_opp])){
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE) {
                    return $array;
                }
            }
        }
        return false;
    }


     /*Insert les cartes des players
        *$myDeck = array
        *$oppDeck = array
        *$my_pla_id = string
        *$opp_pla_id = string
        *getCards = recupere les cartes du deck associées au player
        *return array
    */
    public function iniCards($my_pla_id , $opp_pla_id , $myDeck , $oppDeck){
        $cards_me_deck = $myDeck->getCards();
        foreach($cards_me_deck as $card) {
           if(($resource =$this->pdo->prepare('INSERT INTO  game_card(crd_status , crd_manas , crd_hp , crd_attack , crd_type , is_here , crd_id_CARD , pla_id)
                                              VALUES(:crd_status , :crd_manas , :crd_hp , :crd_attack , :crd_type , :is_here , :crd_id_CARD , :pla_id)'))!==FALSE){
                if($resource->execute([
                                    "crd_status"=>1,
                                    "crd_manas"=>$card->getManas(),
                                    "crd_hp"=>$card->getHp(),
                                    "crd_attack"=>$card->getAttack(),
                                    "crd_type"=>$card->getType(),
                                    "is_here"=>1,
                                    "crd_id_CARD"=>$card->getId(),
                                    "pla_id"=>$my_pla_id
                                       ]))
                {
                }
            }
        }
        $cards_opp_deck = $oppDeck->getCards();
        foreach($cards_opp_deck as $card){
           if(($resource =$this->pdo->prepare('INSERT INTO  game_card(crd_status , crd_manas , crd_hp , crd_attack , crd_type , is_here , crd_id_CARD , pla_id)
                                              VALUES(:crd_status , :crd_manas , :crd_hp , :crd_attack , :crd_type , :is_here , :crd_id_CARD , :pla_id)'))!==FALSE) {
                if($resource->execute([
                                    "crd_status"=>1,
                                    "crd_manas"=>$card->getManas(),
                                    "crd_hp"=>$card->getHp(),
                                    "crd_attack"=>$card->getAttack(),
                                    "crd_type"=>$card->getType(),
                                    "is_here"=>1,
                                    "crd_id_CARD"=>$card->getId(),
                                    "pla_id"=>$opp_pla_id
                                       ]))
                {
                }
            }
        }
    }

    /*Recupere le player ID du User
        *$userme = string
        *return array
    */
    public function getMyPlayers($userme){
        if(($resource = $this->pdo->prepare('SELECT pla_id FROM player WHERE user_id = :id'))!==FALSE){
            if($resource->execute(["id"=>$userme])) {
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE) {
                    return $array;
                }
            }
        }
        return false;
    }


    /*Recupere le player ID de la game et compare ID player à l'ID user si se sont les memes
        *$userme = string
        *$gameId = string
        *return array
    */
    public function playerIsNotMe($gameId, $userme) {
        if(($resource = $this->pdo->prepare('SELECT pla_id FROM game WHERE gam_id = :gId'))!==FALSE){
            if($resource->execute(["gId"=>$gameId])) {
               if(($pla_id = $resource->fetch(PDO::FETCH_ASSOC))!==FALSE) {
                    if(!is_null($pla_id)) {
                        if(($resource = $this->pdo->prepare('SELECT * FROM player WHERE pla_id = :pId'))!==FALSE) {
                            if($resource->execute(["pId"=>$pla_id["pla_id"]])) {
                                if(($userNotMe = $resource->fetch(PDO::FETCH_ASSOC))!==FALSE){
                                    if($userNotMe["user_id"]==$userme) {
                                        return $userNotMe;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    /*Crée une game
        *$id = string
        *return last ID
    */
    public function createGame($id){
         try {
            if ( ( $reponse = $this->pdo->prepare('INSERT INTO game(`pla_id`, `gam_date` ) VALUES(:id, NOW())' )  ) !== false ){
                if( $reponse->execute(array("id"=> $id ))){
                    $thisID = $this->pdo->lastInsertId() ;
                    return $thisID;
                }
            }
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }
        return false;
    }

     /*Insert le player 2 dans la game
        *$id = string
        *$game = string
        *return true/false
    */
    public function updateGame($id, $game) {
        if(($resource = $this->pdo->prepare('UPDATE game SET pla_id_PLAYER = :id WHERE gam_id = :gameID'))!==FALSE) {
            if( $resource->execute(array("id"=> $id , "gameID"=>$game ))) {
                return true;
            }
        }
        return false;
    }

     /*Recupere le dernier ID player du User
        *$user_id = string
        *return array
    */
    public function lastPLayFromUser($user_id) {
        if(($resource = $this->pdo->prepare('SELECT * FROM player WHERE user_id = :user ORDER BY pla_id DESC LIMIT 1'))!==FALSE) {
            if($resource->execute(array("user"=>$user_id))) {
               if(($array = $resource->fetch())!==FALSE) {
                    if(!is_null($array)) {
                        return $array;
                    }
                }
            }
        }
        return false;
    }
}





