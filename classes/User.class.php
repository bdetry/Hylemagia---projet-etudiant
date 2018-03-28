<?php
/**
 * Created by PhpStorm.
 * User: Sxt
 * Date: 17/01/2018
 * Time: 10:51
 */
class User{

    /**
     * --------------------------------------------------
     * PROPRIETES
     * --------------------------------------------------
     **/

    private $user_id;
    private $user_name;
    private $user_l_name;
    private $user_b_day;
    private $user_email;
    private $user_username;

    /**
     * --------------------------------------------------
     * CONSTRUCTEUR
     * --------------------------------------------------
     **/

    public function __construct()
    {

    }




    /**
     * --------------------------------------------------
     * SETTERS/GETTES
     * --------------------------------------------------
     **/


    /**
     * @return mixed
     */
    public function getUserId(){
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getUserName() {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name){
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getUserLName() {
        return $this->user_l_name;
    }

    /**
     * @param mixed $user_l_name
     */
    public function setUserLName($user_l_name) {
        $this->user_l_name = $user_l_name;
    }

    /**
     * @return mixed
     */
    public function getUserBDay() {
        return $this->user_b_day;
    }

    /**
     * @param mixed $user_b_day
     */
    public function setUserBDay($user_b_day) {
        $this->user_b_day = $user_b_day;
    }

    /**
     * @return mixed
     */
    public function getUserEmail() {
        return $this->user_email;
    }

    /**
     * @param mixed $user_email
     */
    public function setUserEmail($user_email) {
        $this->user_email = $user_email;
    }

    /**
     * @return mixed
     */
    public function getUserUsername(){
        return $this->user_username;
    }

    /**
     * @param mixed $user_username
     */
    public function setUserUsername($user_username) {
        $this->user_username = $user_username;
    }

}
