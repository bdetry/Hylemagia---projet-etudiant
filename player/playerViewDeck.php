  <?php
  /* Verification du nombre de cartes
 * $deck = array
 */
    if(!is_null($deck)){
        if(count($deck)==20){
        ?><form class='addCardsDeck' method="post" action="?a=insertPlayer&c=player"><?php
            $cpt = 0;
            $tmp = 0;
            foreach ($deck as $key => $card){
                echo $card->getName() . "<br>";
                $cpt++;
                $tmp++;
            }
            ?>
            <br>
            <input type="hidden" name="deck" value="<?php echo $dck_id; ?>">
            <input type="submit" value="Jouer">
        </form>
            <?php
            }
            else{
                echo "T'es en manque de cartes";
            }
    }
    else{
        echo "Le deck est vide";
    }