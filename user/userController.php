<?php

class UserController{

    private $model;

    public function __construct(){
        $this->model = new userModel;

    }


/* Affichage de la view d'acceuil */

    public function ShowHeadCom(){
        if(isset(SRequest::getInstance()->session()['user'])){
            $this->showHead();
            $this->showMenu();
        }
    }

    public function ShowMain(){
        if(isset(SRequest::getInstance()->session()['user'])){
            $this->showAccueil();
            $this->showFoot();
        }
        else{
            $this->showOfflineUser();
        }
    }
/* Affichage connection au Jeu de cartes */
    public function showOfflineUser(){
        include( 'views/headView.php' );
        $this->showInscrip();
        $this->showConnect();
        $this->showNewsletter();
        include( 'views/footerView.php' );
    }

    public function showInscrip(){
        require_once('user/userInscripView.php');
    }

    public function showConnect(){
        require_once('user/userConnectView.php');
    }

    public function showNewsletter(){
        require_once('user/userNewsletterView.php');
    }

    public function showAccueil(){
        require_once('user/userAccueilView.php');
    }

    public function showMenu(){
        include( 'views/menuView.php' );
    }

    public function showHead(){
        include( 'views/headView.php' );
    }

    public function showFoot(){
        include( 'views/footerView.php' );
    }
/* Creation du User
 * Recherche des params grace à l'index
 * $a= return du last ID
 */
    public function createAction($params){
        $name = $params['newName'];
        $lname = $params['newLname'];
        $bday = $params['newBday'];
        $mail = $params['newEmail'];
        $username = $params['newUserName'];
        $pass = $params['newPass'];
        $a = $this->model->createUser($name, $lname, $bday, $mail, $username, $pass);
        if(is_numeric($a)){
            return $a;
        }
        return false;
    }
/* Annexe inscription à la newsletter
 * $a= return du last ID
 */
    public function newsAction($params){
        $username = $params['newUserName'];
        $mail = $params['newEmail'];
        $a = $this->model->createNews($username, $mail);
        if(is_numeric($a)){
            return $a;
        }
        return false;
    }
/* Connection au jeu
 * Recherche des params grace à l'index
 * Verification du password
 * application de la Session User
 */
    public function connectAction($params){
        $mail = $params['email'];
        $pass = $params['pass'];
        $this->model->goodPass($mail, $pass);
        if($this->model->goodPass($mail, $pass)!==false)
        {
            $a = $this->model->goodPass($mail, $pass);
            $_SESSION['user'] = $this->model->select($a);

            if(!empty($a)){
                return $a;
            }
        }
        else {
            ?>
            <script type="text/javascript">
                window.location.href = "index.php";
            </script>
            <?php
        }

        return false;
    }
}