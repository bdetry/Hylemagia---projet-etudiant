<?php

class Game
{
        private $id;

        private $player1;
        private $player2;

        private $deck1;
        private $deck2;

        private $table1;
        private $table2;

        private $hand1;
        private $hand2;

        private $trash1;
        private $trash2;

        public function __construct($game_ID) {
                $this->setId($game_ID["gam_id"]);
        }

        public function getId() {
                return $this->id;
        }

        public function setId($val){
            $this->id = $val;
        }

        public function setPlayer1($val) {
            $this->player1 = $val;
        }

        public function setPlayer2($val){
            $this->player2 = $val;
        }

        public function getPlayer1(){
            return $this->player1;
        }

        public function getPlayer2() {
            return $this->player2;
        }

        public function setDeck1($val){
                $this->deck1 = $val;
        }

        public function getDeck1(){
                return $this->deck1;
        }

        public function setDeck2($val){
                $this->deck2 = $val;
        }

        public function getDeck2() {
                return $this->deck2;
        }
}