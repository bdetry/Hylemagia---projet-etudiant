<?php

class gameController{

    private $model;
    private $classGame;

    public function __construct(){
        $this->model = new gameModel;
        $game_id = $this->model->getMyGameId($this->model->lastPLayFromUser(SRequest::getInstance()->session()['user']->getUserId())["pla_id"]);//Recupere info Game en cour d'execution
        $this->classGame =  new Game($game_id);//instancier la class game (game en cour)
        if( $this->model->gameIsFull($game_id["gam_id"])) {//Si aucune game est en cour
            $this->classGame->setPlayer1($game_id["pla_id"]);
            $this->classGame->setPlayer2($game_id["pla_id_PLAYER"]);

                $modelDeck = new deckModel();

                //Objet deck joueur 1

                $deckId = $this->model->playerDeck($game_id["pla_id"]);
                $deck_info = $this->model->getDeckInfo($deckId);
                $obj_complt_deck = new Deck();
                $obj_complt_deck->setId($deck_info[0]["dck_id"]);
                $obj_complt_deck->setDate($deck_info[0]["maked_deck_date"]);
                $obj_complt_deck->setName($deck_info[0]["dck_name"]);
                $obj_complt_deck->setUniv($deck_info[0]["univ_id"]);
                $obj_complt_deck->setUser($deck_info[0]["user_id"]);
                $cards = $modelDeck->selectDeckCards($deck_info[0]["dck_id"]);//recupere les caracteristiques des cartes les stock dans un tableau
                $obj_complt_deck->setDeckCards($cards);//associe les cartes à l'objet
                $this->classGame->setDeck1($obj_complt_deck);//info complete du player1

                //Objet deck joueur 2

                $obj_complt_deck2 = new Deck();
                $deckId = $this->model->playerDeck($game_id["pla_id_PLAYER"]);

                $deck_info = $this->model->getDeckInfo($deckId);
                $obj_complt_deck2->setId($deck_info[0]["dck_id"]);
                $obj_complt_deck2->setDate($deck_info[0]["maked_deck_date"]);
                $obj_complt_deck2->setName($deck_info[0]["dck_name"]);
                $obj_complt_deck2->setUniv($deck_info[0]["univ_id"]);
                $obj_complt_deck2->setUser($deck_info[0]["user_id"]);
                $cards = $modelDeck->selectDeckCards($deck_info[0]["dck_id"]);//recupere les caracteristiques des cartes, les stock dans un array
                $obj_complt_deck2->setDeckCards($cards);//associe les cartes à l'objet
                $this->classGame->setDeck2($obj_complt_deck2);//info complete du player2



           if($this->classGame->getPlayer2()!=NULL AND $this->classGame->getPlayer1()!=NULL){// verifie la presence des 2 joueurs
                $me = $this->me($game_id["gam_id"] , SRequest::getInstance()->session()['user']->getUserId(), $game_id["pla_id"], $game_id["pla_id_PLAYER"]);// objet player 1 dans la game
                $oppon = $this->opponent($game_id["gam_id"] , SRequest::getInstance()->session()['user']->getUserId(), $game_id["pla_id"], $game_id["pla_id_PLAYER"]);// objet player 2 dans la game
                if(count($this->model->cardsInGame($me->getPlaId(), $oppon->getPlaId()))==0){ //Compte les cartes à l'interieur des decks des joueurs
                    $this->model->iniCards( //initialise les decks
                                            $me->getPlaId(),
                                            $oppon->getPlaId(),
                                            $this->myDeck($me->getPlaDeckId()) , //objet DECK + objet CARD Player 1
                                            $this->opentDeck($me->getPlaDeckId()) );//objet DECK + objet CARD Player 2
                }
                else{
                    //instencier new cards from game_card FAIRE DES NEW CARDS
                }

                $hand=$this->model->handExists($game_id["gam_id"]);//Regarde si HAND existe
                if($hand===false){ //manque deuxieme hand
                    $this->iniHand($game_id["gam_id"] , $me->getPlaId(), $oppon->getPlaId() , $this->myDeck($me->getPlaDeckId()) , $this->opentDeck($me->getPlaDeckId()));
                }
                elseif(is_array($hand)){ //instencier new cards from pool in hand
                    $this->model->getHandCard($hand[0]["hand_id"]);
                }

                $this->showPlatView($me,
                                    $oppon,
                                    $this->myDeck($me->getPlaDeckId()),
                                    $this->opentDeck($me->getPlaDeckId()),
                                    $this->model->getMyhand($game_id)//A VOIR
                                    );
            }
        }
        else{
            $waiting = $this->model->isWaiting();
            if(!$waiting){//Creation de la game
                $this->classGame->setPlayer1($this->model->lastPLayFromUser(SRequest::getInstance()->session()['user']->getUserId())["pla_id"]) ;
                if(!is_null($this->classGame->getPlayer1()) ){
                        if($this->model->createGame($this->classGame->getPlayer1())){
                                $this->showRedirectUpdate();//page de chargement
                        }
                }
            }
            elseif(is_array($waiting)){//deja un joueur qui attend
                $playerIsNotMe = $this->model->playerIsNotMe($this->model->isWaiting()['gam_id'], SRequest::getInstance()->session()['user']->getUserId());
                if(!is_array($playerIsNotMe)){
                     $this->classGame->setPlayer1($this->model->isWaiting()["pla_id"]);
                     $this->classGame->setPlayer2($this->model->lastPLayFromUser(SRequest::getInstance()->session()['user']->getUserId())["pla_id"]) ;
                    if(!is_null($this->classGame->getPlayer1()) AND !is_null($this->classGame->getPlayer2()))  {
                        if($this->model->updateGame($this->classGame->getPlayer2() , $this->model->isWaiting()['gam_id'])){ // GAME COMPLET
                             $this->showRedirect();//Entrer sur plateau
                        }
                    }
                }
            }
        }
    }

    /*Cherche le player opponent
        *gam_id = string
        *userme = string
        *gam_pla_1 = string
        *game_pla_2 = string
        *getMyPlayers = return un array
        *return string
    */
      public function getOppo($gam_id , $userme , $gam_pla_1 , $game_pla_2){
        $my_Players = $this->model->getMyPlayers($userme);
        foreach($my_Players as $player) {
            $array[] = $player["pla_id"];
        }
        if(in_array($gam_pla_1, $array)){
            return $game_pla_2;
        }
        elseif(in_array($game_pla_2, $array)){
            return $gam_pla_1;
        }
        return false;
    }


    public function iniHand($gameId , $my_pla_id, $my_pla_id_opp , $myDeck , $oppnDeck){
        $this->model->newHand($gameId);
        $this->iniPoolHand($my_pla_id, $my_pla_id_opp , $myDeck , $oppnDeck);
    }


     /*Cherche le deck opponent
        *me_player_id = string
        *return array
    */
    public function opentDeck($me_player_id){
        if($this->classGame->getDeck1()->getId() == $me_player_id){
            return $this->classGame->getDeck2();
        }
        elseif($this->classGame->getDeck2()->getId() == $me_player_id){
            return $this->classGame->getDeck1();
        }
        return false;
    }

      /*Cherche le deck me
        *me_player_id = string
        *return array
    */
    public function myDeck($me_player_id){
        if($this->classGame->getDeck1()->getId() == $me_player_id){
            return $this->classGame->getDeck1();
        }
        elseif($this->classGame->getDeck2()->getId() == $me_player_id){
            return $this->classGame->getDeck2();
        }
        return false;
    }


    public function me($gam_id , $userme, $play1 , $play2){
        $me_pla_id = $this->getMe($gam_id , $userme , $play1 , $play2);
        $me = $this->model->getPlayerObj($me_pla_id);
        return $me;
    }
        /*Cherche le player me
        *gam_id = string
        *userme = string
        *gam_pla_1 = string
        *game_pla_2 = string
        *getMyPlayers = return un array
        *return string
    */
    public function getMe($gam_id , $userme , $gam_pla_1 , $game_pla_2){
        $my_Players = $this->model->getMyPlayers($userme);
        foreach($my_Players as $player) {
            $array[] = $player["pla_id"];
        }
        if(in_array($gam_pla_1, $array)) {
            return $gam_pla_1;

        }
        elseif(in_array($game_pla_2, $array)) {
            return $game_pla_2;
        }
        return false;
    }

    public function opponent($gam_id , $userme , $play1 , $play2){
        $me_pla_id = $this->getOppo($gam_id , $userme , $play1 , $play2);
        $oppon = $this->model->getPlayerObj($me_pla_id);
        return $oppon;
    }

    public function iniPoolHand($my_pla_id, $my_pla_id_opp , $myDeck , $oppnDeck) {
        $Allcards = $myDeck->getCards();
        shuffle($Allcards);
        $myAleatoryHand  = [$Allcards[0] , $Allcards[1] , $Allcards[3]];
    }

    public function ShowHeadCom(){
        if($this->classGame->getPlayer2()==NULL) {
            $this->showHead();
           $this->showMenu();
        }
    }

    public function ShowMain(){
        if(is_null($this->classGame->getPlayer2())){
            $this->showRedirectUpdate();
        }
            $this->showFoot();
    }

    public function showMenu(){
        include( 'views/menuView.php' );
    }

    public function showHead(){
        include( 'views/headView.php' );
    }

    public function showFoot() {
        include( 'views/footerView.php' );
    }

    public function showRedirectUpdate(){
        include( 'game/loadingGameView.php' );
    }

    public function showRedirect(){
        include( 'game/redirView.php' );
    }

    public function showPlatView($me , $opponent , $myDeck , $oppentDeck , $myHand){
        include( 'game/platView.php' );
    }
}