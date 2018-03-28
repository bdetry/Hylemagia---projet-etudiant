<?php

class deckModel
{
    private $pdo;
    public function __construct(){
        $this->pdo = SPDO::getInstance()->getDb();
    }

    public function getAllUnivs(){
        try {
            if (($requete = $this->pdo->query('SELECT * FROM univers')) !== false) {
                if ($value = $requete->fetchAll(PDO::FETCH_ASSOC)) {
                    return $value;
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAllDecks(){
        try {
            if (($requete = $this->pdo->query('SELECT * FROM deck')) !== false) {
                if ($value = $requete->fetchAll(PDO::FETCH_ASSOC)) {
                    return $value;
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function validDeck($user_id, $deck_id){
        try {
            if ( ( $reponse = $this->pdo->prepare ('SELECT * FROM deck WHERE user_id = :userID AND dck_id = :deckID' )  ) !== false ) {
                if( $reponse->execute(
                    array(
                        "userID" => $user_id,
                        "deckID" => $deck_id
                    )))
                {
                    if($value = $reponse->fetchAll(PDO::FETCH_ASSOC)){
                        if(!is_null($value)){
                            return true;
                        }
                    }
                }
            }
            return false;
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }
    }


    public function createDeck($user, $univ, $name){
        try {
            if (($requete = $this->pdo->prepare('INSERT INTO deck(dck_id, maked_deck_date, user_id, univ_id, dck_name) VALUES(null, NOW(), :user, :univ, :name )')) !== false) {
                if ($requete->bindValue('user', $user) && $requete->bindValue('univ', $univ) && $requete->bindValue('name', $name)) {
                    if ($requete->execute()) {
                        return $this->pdo->lastInsertId();
                    }
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return false;
    }

    public function moveToDeck($deckUse, $cards){
        try {
            foreach ($cards as $key => $card) {
                if (($requete = $this->pdo->prepare('INSERT INTO moved_to_deck(moved_to_deck_date, dck_id , crd_id) VALUES(NOW(), :deck , :card )')) !== false) {
                    if ($requete->bindValue('card', $card) && $requete->bindValue('deck', $deckUse)) {
                        if ($requete->execute()) {

                        }
                    }
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getUserDecks($id){
       try {
            $decks = null;
            if (($requete = $this->pdo->prepare('SELECT * FROM deck WHERE user_id = :userid;')) !== false) {
                if ($requete->execute(["userid"=>$id])) {
                    if($value = $requete->fetchAll(PDO::FETCH_ASSOC)) {
                        return $value;
                    }
                }
                return $decks;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function selectDeck(){
        try {
            $decks = null;
            if (($requete = $this->pdo->prepare('SELECT * FROM deck;')) !== false) {
                if ($requete->execute()) {
                    foreach ($requete->fetchAll(PDO::FETCH_ASSOC) as $key => $deck) {
                        $decks[$key] = new Deck;
                        $decks[$key]->setId($deck['dck_id']);
                        $decks[$key]->setUniv($deck['univ_id']);
                        $decks[$key]->setName($deck['dck_name']);
                        $cartedDuDeck = $this->selectDeckCards($deck['dck_id']);
                        $decks[$key]->setDeckCards($cartedDuDeck);

                    }
                }
                return $decks;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function selectDeckCards($deckID){
        try {
            $decks = null;
            if (($requete = $this->pdo->prepare('SELECT * FROM moved_to_deck
                    inner join card on moved_to_deck . crd_id = card . crd_id
                    inner join image on card . img_id_fk = image . img_id
                    WHERE dck_id=:id ;')) !== false) {
                if ($requete->execute(['id' => $deckID])) {

                    foreach ($requete->fetchAll(PDO::FETCH_ASSOC) as $key => $deck) {
                        $decks[$key] = new Card;
                        $decks[$key]->setId($deck['crd_id']);
                        $decks[$key]->setName($deck['crd_name']);
                        $decks[$key]->setDecrip($deck['crd_decrip']);
                        $decks[$key]->setManas($deck['crd_manas']);
                        $decks[$key]->setHp($deck['crd_hp']);
                        $decks[$key]->setType($deck['crd_type']);
                        $decks[$key]->setUniv($deck['univ_id']);
                        $decks[$key]->setAttack($deck['crd_attack']);
                        $decks[$key]->setImg($deck['img_src']);
                    }
                    return $decks;
                }

            }
            return false;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


        public function getAllCards($univ) {
            try {
                if (($requete = $this->pdo->prepare('SELECT * FROM card
                    inner join image on image.img_id = card.img_id_fk
                    WHERE card.univ_id=:id ;')) !== false) {
                    if ($requete->bindValue('id', $univ['univ_id']))
                    {
                        if ($requete->execute()){
                            $cards=array();
                            if(($result = $requete->fetchAll(PDO::FETCH_ASSOC))!==false) {
                                foreach ($result as $key => $card) {
                                    $cards[$key] = new Card;
                                    $cards[$key]->setId($card['crd_id']);
                                    $cards[$key]->setName($card['crd_name']);
                                    $cards[$key]->setDecrip($card['crd_decrip']);
                                    $cards[$key]->setAvailable($card['crd_available_at']);
                                    $cards[$key]->setManas($card['crd_manas']);
                                    $cards[$key]->setHp($card['crd_hp']);
                                    $cards[$key]->setAttack($card['crd_attack']);
                                    $cards[$key]->setType($card['crd_type']);
                                    $cards[$key]->setUniv($card['univ_id']);
                                    $cards[$key]->setImg($card['img_src']);
                                }
                               return ($cards) ;
                            }
                        }
                    }
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }


        public function getUnivId($deckId){
            if (($requete = $this->pdo->prepare('SELECT univ_id FROM deck WHERE dck_id=:id ;')) !== false) {
                if ($requete->execute(["id"=>$deckId])) {
                    if(($result = $requete->fetch())!==false) {
                        return($result);
                    }
                }
            }
        }
    }

