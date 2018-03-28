<?php
    if(!is_null($cards))
    {
        echo "<div class='allCardsDeck'>";
        echo '<h4>Cartes de ton Deck</h4>';
        foreach ($cards as $card)
        {
            echo "<p style='display:block'>" . $card->getName() . "</p>";
        }
        echo "</div>";
    }
    else
    {
        echo "<p style='display:block'>Pas de cartes dans le deck</p>";
    }


    if (isset(SRequest::getInstance()->post()['deckId']))
    {
        echo "<div class='addCardsDeck'>";
        echo "<h4>Ajoute une carte ton Deck</h4>";
            $cpt = 0;
            echo "<form method='post' action='?c=deck&a=addToDeck'> ";
            echo "<input type='hidden' name='dckId' value='".SRequest::getInstance()->post()['deckId']."'>";
            $tmp = 0;

            foreach ($Allcards as $key => $card)
            {
                if ($cpt % 4 == 0)
                {
                    echo "</tr><tr>";
                }
                echo '';
                //echo "<br><input style='display:none; width=100%;' type='checkbox' id=". $tmp . " name='checkbox[]' value=" . $card->getId() . "><label for= ". $tmp ."> Nom : ". $card->getName() .'<br><img src=' . $card->getImg() . '/></label>';
                echo "<br><input  type='checkbox' id=" . $tmp . " name='checkbox[]' value=" . $card->getId() . "><label for= " . $tmp . ">".$card->getName()."</label>";

                $cpt++;
                $tmp++;
            }


            ?>
            <br>
            <button type='submit'>VALIDER</button>
            </form>
        </div>
        <?php
    }
    else
    {
        echo "Il y a pas d'ID Deck";
    }

?>




