<?php
 $userId =SRequest::getInstance()->session()['user']->getUserId();
 //var_dump(SRequest::getInstance()->session()['user']);

?>

<div class="creaDeck">
<h4>Creation de Deck</h4>
<form action="?c=deck&a=create" method="post">
    <input type="text" name="newName" id="newName" placeholder="Nom Deck">
    <input type="hidden" name="userID" value="<?php echo $userId; ?>">
    <select name="univ_id">
        <option>Choix Univers</option>
        <?php
        foreach( $univs as $univ ) {
            echo '<option value="' .  $univ['univ_id'] .'">'  . $univ['libelle'] .'</option>';
        }
        ?>
    </select>
    <input type="submit" value="valider">
</form>
</div>

<?php

