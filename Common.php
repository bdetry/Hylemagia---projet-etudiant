<?php
/**
 * Created by PhpStorm.
 * User: webuser
 * Date: 02/02/2018
 * Time: 14:45
 */

/**
 * loadClasses - Checks whether a file exists and includes it
 * @param   string  $className
 * @return
 **/
function loadClass( $className ) {
    $_str_file = 'classes/' . ucfirst($className)  . '.class.php';
    if( file_exists( $_str_file ) )
        require_once( $_str_file );

    $_str_file = 'vendor/' . $className . '.php';
    if( file_exists( $_str_file ) )
        require_once( $_str_file );

    $_str_file = 'deck/' . $className . '.php';
    if( file_exists( $_str_file ) )
        require_once( $_str_file );

    $_str_file = 'player/' . $className . '.php';
    if( file_exists( $_str_file ) )
        require_once( $_str_file );

    $_str_file = 'game/' . $className . '.php';
    if( file_exists( $_str_file ) )
        require_once( $_str_file );

    $_str_file = 'user/' . $className . '.php';
    if( file_exists( $_str_file ) )
        require_once( $_str_file );


}

spl_autoload_register( 'loadClass' ); // On lance la procédure d'auto-chargement des classes avec la fonction "loadClass" en callback

