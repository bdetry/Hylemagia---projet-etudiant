<?php
/**
 * Created by PhpStorm.
 * User: webuser
 * Date: 21/02/2018
 * Time: 10:04
 */
class Player {

    /**
     * --------------------------------------------------
     * PROPRIETES
     * --------------------------------------------------
     **/

    private $pla_id;
    private $pla_mana_pts;
    private $pla_hp_pts;
    private $pla_n_roun;
    private $pla_deck_id;
    private $user_id;

    /**
     * @return mixed
     */
    public function getPlaId()
    {
        return $this->pla_id;
    }

    /**
     * @param mixed $pla_id
     */
    public function setPlaId($pla_id)
    {
        $this->pla_id = $pla_id;
    }

    /**
     * @return mixed
     */
    public function getPlaManaPts()
    {
        return $this->pla_mana_pts;
    }

    /**
     * @param mixed $pla_mana_pts
     */
    public function setPlaManaPts($pla_mana_pts)
    {
        $this->pla_mana_pts = $pla_mana_pts;
    }
    
    

    /**
     * @return mixed
     */
    public function getPlaNRoun()
    {
        return $this->pla_n_roun;
    }

    /**
     * @param mixed $pla_n_roun
     */
    public function setPlaNRoun($pla_n_roun)
    {
        $this->pla_n_roun = $pla_n_roun;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function setPlaHPPts($pla_hp_pts)
    {
        $this->pla_hp_pts = $pla_hp_pts;
    }
    
    
    public function getPlaHPPts()
    {
         return $this->pla_hp_pts;
    }
    
    public function setPlaDeckId($pla_deck_id)
    {
        $this->pla_deck_id = $pla_deck_id;
    }
    
    public function getPlaDeckId()
    {
        return $this->pla_deck_id;
    }


}