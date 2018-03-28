<?php
/**
 * User: webuser
 * Date: 21/02/2018
 * Time: 09:52
 */
class playerController{

    private $model;
    private $deckmodel;
    private $deck;

    /*initialisation des models au construct */
    public function __construct(){
        $this->model = new playerModel;
        $this->deckmodel = new deckModel;
    }

    public function ShowHeadCom(){
         $this->showHead();
        $this->showMenu();
    }

    /*Deck
     *$deck = Object
     *getUserDeck = recherche le deck choisi par le User
    */
    public function ShowMain(){
        $decks=$this->deckmodel->getUserDecks(SRequest::getInstance()->session()['user']->getUserId());
        include ('playerView.php');
        $this->showFoot();
    }

    /*Lien User et deck
     *$deck = Object
     *validDeck = Valide le deck choisi par le User
     *showDeck = affiche les cartes du deck
    */
    public function createAction(){
        $user_id = SRequest::getInstance()->session()['user']->getUserId();
        $deck_id = SRequest::getInstance()->post()["deck"];
        if( !is_null($deck_id) AND is_numeric($deck_id)){
            if($this->deckmodel->validDeck($user_id, $deck_id)) {
                $this->showDeck($this->deckmodel->selectDeckCards($deck_id) , $deck_id);
            }
        }
    }


    /*Lancement de la game
     *getLastPlayerId = Dernier ID player
     *Si imNotWaiting return True le tableau est vide, on crée une game
    */
    public function insertPlayerAction() {
        $user_id = SRequest::getInstance()->session()['user']->getUserId();
        $deck_id = SRequest::getInstance()->post()["deck"];
        $lastPLayerId=$this->model->getLastPlayerId($user_id);
        if($lastPLayerId!==false){
            $notWaiting = $this->model->imNotWaiting($lastPLayerId);
            if($notWaiting){
                if($this->model->createPlayer($user_id, $deck_id)!==false) {
                   header('Location: ?c=game');
                  exit;
                }
           }
           else {
                header('Location: ?c=game');
                exit;
           }
        }
        else {
            echo "probleme";
        }
    }

    public function showDeck($deck , $dck_id)
    {
        include( 'playerViewDeck.php' );
    }

    public function showMenu()
    {
        include( 'views/menuView.php' );
    }

    public function showHead()
    {
        include( 'views/headView.php' );
    }

    public function showFoot()
    {
        include( 'views/footerView.php' );
    }
}