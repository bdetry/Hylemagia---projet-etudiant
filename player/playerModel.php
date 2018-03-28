<?php
/**
 * Created by PhpStorm.
 * User: webuser
 * Date: 21/02/2018
 * Time: 09:52
 */
class PlayerModel{

    private $pdo;
    private $user_id;

    public function __construct(){
        $this->pdo = SPDO::getInstance()->getDb();
    }

    /**
     * --------------------------------------------------
     * METHODES
     * --------------------------------------------------
     **/

    /*Creation du player
     *$user_id = int
     *$deck_id = int
     *return last ID
    */
    public function createPlayer($user_id, $deck_id){
        try {
            if ( ( $reponse = $this->pdo->prepare('INSERT INTO player(`user_id`, `deck_id_fk`) VALUES(:user_id, :deck_id)' )  ) !== false ){
                if( $reponse->execute(array("user_id"=> $user_id , "deck_id" => $deck_id))){
                    $thisID = $this->pdo->lastInsertId() ;
                    return $thisID;
                }
            }
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }

        return false;
    }

     /*Recherche du dernier joueur
      *$user_id = int
      *return array
    */
    public function getLastPlayerId($user_id){
         if(($resource = $this->pdo->prepare('SELECT * FROM player WHERE user_id = :userID'))!==FALSE){
            if($resource->execute(array("userID"=>$user_id))){
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE){
                    return ($array[count($array)-1]);
                }
            }
        }
        return false;
    }

     /* Parcourir la base de donnée savoir si le joueur 2 est present
      *$pla_id = array
      *return true/false
    */

    public function imNotWaiting($pla_id){
        if(($resource = $this->pdo->prepare('SELECT * FROM game WHERE pla_id = :plaID AND pla_id_PLAYER IS NULL'))!==FALSE){
            if($resource->execute(array("plaID"=>$pla_id["pla_id"]))){
                if(($array = $resource->fetchAll(PDO::FETCH_ASSOC))!==FALSE){
                    if(empty($array)){
                        return true;
                    }
                }
            }
        }
        return false;
    }

}