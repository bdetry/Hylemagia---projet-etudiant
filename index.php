<?php

require_once ( "Common.php");
require_once( 'vendor/SPDO.php' );
require_once ("ini.php");
require_once("vendor/SRequest.php");

// recherche des envoies GET et POST par le SRequest.
if(!is_null(SRequest::getInstance()->get()))
    $get = SRequest::getInstance()->get();
if(!is_null(SRequest::getInstance()->post()))
    $post = SRequest::getInstance()->post();
if(isset($get['decon']))
{
    //session_destroy();
    SRequest::getInstance()->unsetSession();
    unset($_SESSION['user']);
    header('Location: index.php');
    exit;
}

/*Gestion des controlleur par le GET
 *$controlleur = dossier controller
 *$controlName = class controller
 *$dosAct = action class controller
*/
if (isset($get['c'])){
    $controlleur = strtolower($get['c']) . "Controller.php";
    $controlName =  $get['c'] . "Controller";
    $dosAct = $get['c'];
}else {
    $controlleur = "userController.php";
    $controlName="userController";
    $dosAct = "user";
}
//routing des variables.
$FilePath = "./".$dosAct."/".$controlleur;

/*Verification File exist
 *$control = instance class controller
 *$method = appel de la methode
 *verification de la method
*/
if(file_exists($FilePath)) {
        $control = new $controlName;
        $control->ShowHeadCom();
        if(isset($get['a'])){
            $method = $get['a'] . "Action";
            if(method_exists($control , $method)){
                $params = null;
                if(isset($post)){
                    $params = $post;
                }
                elseif(isset($get)){
                    $params = $get;
                }
/*Lancement de la methode et ses paramtres*/
                $control->$method($params);
//A Revoir
                if($method == "connectAction"){
                    ?>
                    <script type="text/javascript">
                        window.location.href = "index.php";
                    </script>
                    <?php
                }
            }
            else
                {
                echo "Methode demande non execute";
            }
        }
    $control->ShowMain();
}
else{
        Header("Location: 404");
}



