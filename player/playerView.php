<!--    *Choix du deck
        *$deck = array
  -->
<main>
    <form method="post" action="?c=player&a=create" style="margin: auto;">
        <select name="deck" id="">
            <option value=""></option>
            <?php
            foreach ($decks as $key => $value){
                echo '<option value="' . $value['dck_id'] . '">' . $value['dck_name'] . "<br>";
            }
            ?>
        </select>
        <input type="submit" value="Sélectionner">
    </form>
</main>

