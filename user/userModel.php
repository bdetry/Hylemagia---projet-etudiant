<?php
/**
 * Created by PhpStorm.
 * User: Sxt
 * Date: 24/01/2018
 * Time: 10:36
 */

class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = SPDO::getInstance()->getDb();
    }

    /**
     * --------------------------------------------------
     * METHODES
     * --------------------------------------------------
     **/


    /** createNews
     * [Inscrire les données de mailing dans la base de donnée.]
     * @param $pseudo
     * @param $mail
     */
    public function createNews($pseudo, $mail){
        try {
            if ( ( $reponse = $this->pdo->prepare ('INSERT INTO user_mail(`email`,`pseudo`) VALUES ( :email , :pseudo)' )  ) !== false ) {
                return $reponse->execute(
                    array(
                        "email" => $mail,
                        "pseudo" => $pseudo
                    )
                );
            }
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }
    }

    /** deleteNews
     * [Supprime les données de mailing dans la base de donnée.]
     * @param $mail
     */

    public function deleteNews($mail){
        try {
            if ( ( $reponse = $this->pdo->prepare ('DELETE FROM `user_mail` WHERE `email` = :email' )  ) !== false ) {
                return $reponse->execute(
                    array(
                        "email" => $mail
                    )
                );
            }
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }
    }

    /** createUser
     * [Inscrire les données de création de compte utilisateur dans la base de donnée.]
     * @param $name
     * @param $lname
     * @param $bday
     * @param $mail
     * @param $pseudo
     * @param $pass
     */

    public function createUser($name, $lname, $bday, $mail, $username, $pass){
        try {
            if ( ( $reponse = $this->pdo->prepare ('INSERT INTO user(`user_name`, `user_l_name`, `user_b_day`, `user_crea_day`, `user_email`, `user_username`, `user_pass`) VALUES ( :name, :lname, :bday, now(), :mail , :username, :pass)' )  ) !== false ) {
                if( $reponse->execute(
                    array(
                        "name" => $name,
                        "lname" => $lname,
                        "bday" => $bday,
                        "mail" => $mail,
                        "username" => $username,
                        "pass" => $pass
                    )))
                {
                    $thisID = $this->pdo->lastInsertId() ;
                    //$this->canConnect($mail, $pass);
                    return $thisID; // Modif la function return l'id de l'insertion execute
                }
                else{
                    return false;
                }
            }
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }
    }

    /** deleteUser
     * [Effacer les données de compte utilisateur dans la base de donnée.]
     * @param $user_id
     */
    public function deleteUser($user_id){
        try {
            if ( ( $reponse = $this->pdo->prepare ('DELETE FROM `user` WHERE `user_id` = :user_id' )  ) !== false ) {
                return $reponse->execute(
                    array(
                        "user_id" => $user_id
                    )
                );
            }
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }
    }

    /** updateUser
     * [Mettre à jour les données de compte utilisateur dans la base de donnée.]
     * @param $user_id
     * @param $name
     * @param $lname
     * @param $bday
     * @param $mail
     * @param $pseudo

    retourne true si elle s'execute bien false si erreur
     */
    public function updateUser($user_id, $name, $lname, $bday, $mail, $pseudo){
        try {
            if ( ( $reponse = $this->pdo->prepare ('UPDATE `user` SET `user_name`=:name, `user_l_name`=:lname, `user_b_day`=:bday, `user_email`=:mail, `user_username`=:pseudo WHERE `user_id` = :user_id' )  ) !== false ) {
                if( $reponse->execute(
                    array(
                        "user_id" => $user_id,
                        "name" => $name,
                        "lname" => $lname,
                        "bday" => $bday,
                        "mail" => $mail,
                        "pseudo" => $pseudo
                    )
                ))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }catch( PDOException $e ) {
            die( $e->getMessage( ) );
        }
    }


    //vierifie si un mail est deja existant dans la base de donnees retourne
    //false le mail existe pas!
    //retourne l'id de l'utilisateur

    public function mailExist($mail)
    {
        try
        {
            if(( $reponse = $this->pdo->prepare ('SELECT user_id FROM user WHERE user_email = :mail')) !== false)
            {
                if($reponse->execute(["mail"=>$mail]))
                {
                    if(($data = $reponse->fetch())!==false)
                    {
                        if($data==null)
                        {
                            return false;
                        }
                        else
                        {
                            return $data[0];
                        }
                    }
                }
            }

        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }


    //la function verifie si le mail est le mot de pass coincide
    //true oui
    //false non
    public function goodPass($mail, $pass)
    {
        //var_dump($this->mailExist($mail));
        $userID =  $this->mailExist($mail);
        if($userID!==false)
        {
            if(( $reponse = $this->pdo->prepare ('SELECT user_id FROM user WHERE user_id = :id AND user_pass = :pass')) !== false)
            {
                if($reponse->execute(["id"=>$userID,"pass"=>$pass]))
                {
                    if(($data = $reponse->fetch())!== false)
                    {
                        if(!empty($data))
                        {
                            return $data[0];
                        }
                    }
                }
            }
        }

        return false;
    }

    /** select
     * [Récupère les données d'un compte utilisateur spécifique dans la base de donnée.]
     * @param $user_id [ ID utilisateur]
     */
    public function select($user_id) {
        try {
            if( ( $perso = $this->pdo->prepare( 'SELECT * FROM `user` WHERE `user_id` = :id' ) )!==false )
            {
                if ($perso->bindValue("id", $user_id)){

                    if ($perso->execute())
                    {
                        $data = $perso->fetch(PDO::FETCH_ASSOC);
                        $user = new User();
                        $user->setUserId($data['user_id']);
                        $user->setUserName($data['user_name']);
                        $user->setUserLName($data['user_l_name']);
                        $user->setUserBDay($data['user_b_day']);
                        $user->setUserEmail($data['user_email']);
                        $user->setUserUsername($data['user_username']);

                        return $user;
                    }
                    return false;
                }
            }
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

}