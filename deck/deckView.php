<div class="ShowDeck">
 <h4>Choisis ton Deck</h4>
<form method="post" action="?c=deck&a=showDeckCards">
    <select name="deckId">
        <?php
        foreach($decks as $decks)
        {
            ?> <option value="<?php echo $decks['dck_id']; ?>"><?php echo $decks['dck_name']; ?></option><?php
        }
        ?>
    </select>
    <input type="submit" value="Afficher">
</form>
</div>
