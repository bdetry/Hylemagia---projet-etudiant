<?php

class deckController {
    private $model;

    public function __construct() {
        $this->model = new deckModel;
    }
    
    public function ShowHeadCom()
    {
         $this->showHead();
        $this->showMenu();
    }

    public function ShowMain()
    {       
        $this->showChooseNewUniv($this->model->getAllUnivs());
        $this->showDeckAction($this->model->getUserDecks(SRequest::getInstance()->session()['user']->getUserId()));
        $this->showFoot();
    }

    public function showDeckAction($decks)
    {
        include( 'deck/deckView.php' );
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

    public function showDeckCardsAction($params)
    {
        $deckId = $params['deckId'];
        $cards = $this->model->selectDeckCards($deckId);
        $Allcards = $this->model->getAllCards($this->getMeUniv($deckId));
        include( 'deck/cardInDeckView.php' );

    }

    public function getMeUniv($deckId)
    {
        $univID = $this->model->getUnivId($deckId);
        return($univID);
    }

    public function showChooseNewUniv($univs)
    {
        include( 'deck/chooseUnivView.php' );
    }

    public function createAction($params){
    
        $user =$params["userID"];
        $univ =$params["univ_id"];
        $name =$params["newName"];
var_dump($params);
        $create=$this->model->createDeck($user, $univ, $name);
        return $create;


    }

    public function addToDeckAction($parms)
    {
        $deckid = $parms['dckId'];
        $cartes = $parms['checkbox'];
       $move=$this->model->moveToDeck($deckid, $cartes);
    }


}