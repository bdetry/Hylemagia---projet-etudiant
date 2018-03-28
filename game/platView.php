<?php

$css=null;

    if(isset(SRequest::getInstance()->get()['c']))
    {
        $css = SRequest::getInstance()->get()['c'];
    }
    else
    {
        $css = "user";
    }
    
?>

<!DOCTYPE html>

<html lang="en">
<head>
   <title>Hylemagia</title>
   <meta type="description" content="">
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0">
   <link rel="stylesheet" type="text/css" href="style/menu.css" />
   <link rel="stylesheet" type="text/css" href="style/<?php echo $css; ?>.css" />
   <link rel="stylesheet" type="text/css" href="style/platStyle.css" />
   <link rel="icon" href="" type="image/x-icon">
</head>

<body>
   <div id="demi_plat">      
      <div id="haut_plat">
         <div id="hero"><?php echo "player id:" . $opponent->getPlaId(); ?></div>
         <div id="info_cont">
            <div id="manas"><?php echo "manas :" . $opponent->getPlaManaPts(); ?></div>
            <div id="hp"><?php echo "hp :" . $opponent->getPlaHPPts(); ?></div>
         </div>
         <div id="deck">
            <?php
            echo "<h4>".$oppentDeck->getName()."</h4>";
         
         foreach($oppentDeck->getCards() as $card)
         {
            echo $card->getName() . " - HP :" . $card->getHP() . "<hr>";
         }
         
            ?>
         </div>
      </div>
      <div id="table"></div>
   </div>
   
      <div id="demi_plat_2">      
      <div id="haut_plat_2">
         <div id="hero_2"><?php echo "player id:" . $me->getPlaId(); ?></div>
         <div id="info_cont_2">
            <div id="manas_2"><?php echo "manas :" . $me->getPlaManaPts(); ?></div>
            <div id="hp_2"><?php echo "hp :" . $me->getPlaHPPts(); ?></div>
         </div>
         <div id="deck_2"><?php 
         echo "<h4>".$myDeck->getName()."</h4>";
         
         foreach($myDeck->getCards() as $card)
         {
            echo $card->getName() . " - HP :" . $card->getHP() . "<hr>";
         }
         
         ?></div>
      </div>
      <div id="table_2"></div>
   </div>
   
   <div id="hand">
      
   </div>

   


</div>

