<?php
/**
 * This file is a third-party dependency
 *
 * The SRequest class is used to aggregate HTTP request methods into one object
 *
 * @package {__PACKAGE_NAME__}
 * @copyright {__PACKAGE_LICENSE__}
 * @author {__PACKAGE_AUTHOR__}
 */
class SRequest {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
     */
    /**
     * $_get The get request
     * @var array
     */
    private $_get;
    /**
     * $_post The get request
     * @var array
     */
    private $_post;
    /**
     * $_get The session
     * @var array
     */
    private $_session;
    /**
     * --------------------------------------------------
     * STATICS
     * --------------------------------------------------
     */
    /**
     * $_instance The unique instance
     * @var SRequest
     */
    static private $_instance;
    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
     */
    /**
     * get The getter of the "_get" property
     * @param  string|null  $key    The requested key
     * @return mixed                The value contained in the requested key of the requested array, or the requested array if the key is not set, or null if the requested key doesn't exist in the requested array
     */
    public function get( $key = null ) {
        return $this->getVar( $this->_get, $key );
    }

    /**
     * post The getter of the "_post" property
     * @param  string|null  $key    The requested key
     * @return mixed                The value contained in the requested key of the requested array, or the requested array if the key is not set, or null if the requested key doesn't exist in the requested array
     */
    public function post( $key = null ) {
        return $this->getVar( $this->_post, $key );
    }
    /**
     * --------------------------------------------------
     * STATIC METHODS
     * --------------------------------------------------
     */
    /**
     * getInstance The getter of the "_instance" static property
     * @return SRequest     The instance of SRequest
     */
    static public function getInstance(){
        if( !isset( self::$_instance ) )
            self::$_instance = new self;

        return self::$_instance;
    }

    public function unsetSession(){
        unset($this->_session);
    }
    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
     */
    /**
     * __construct Class constructor
     * @return void
     */
    private function __construct() {
        if( empty( session_id() ) )
            session_start();

        $this->_get = $_GET;
        $this->_post = $_POST;
        $this->_session = &$_SESSION;
        $_GET = $_POST = null;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
     */
    /**
     * unset Unsets a key in the requested array
     * @param  array        $request    The requested array
     * @param  string|null  $key        The requested key
     * @return mixed                    The value contained in the requested key of the requested array, or the requested array if the key is not set, or null if the requested key doesn't exist in the requested array
     */
    public function unset( $request, $key = NULL ) {
        $request = '_' . $request;
        if( isset( $key ) )
            if( isset( $this->$request[$key] ) )
                unset( $this->$request[$key] );
        else
            unset( $this->$request );
    }

    /**
     * session The setter/getter of the "_session" property
     * @param  string|null  $key    The requested key
     * @param  string|null  $value  The value to set
     * @return void|mixed           The value contained in the requested key of the requested array, or the requested array if the key is not set, or null if the requested key doesn't exist in the requested array, or void if value is not set
     */
    public function session( $key = null, $value = null ) {
        if( isset( $key ) && isset( $value ) )
            $this->_session[$key] = serialize( $value );
        else
            return $this->getVar( $this->_session, $key );
    }

    /**
     * getVar Gets a value contained at the key in the requested array
     * @param  array        $request    The requested array
     * @param  string|null  $key        The requested key
     * @return mixed                    The value contained in the requested key of the requested array, or the requested array if the key is not set, or null if the requested key doesn't exist in the requested array
     */
    protected function getVar( $request, $key = null ) {
        return ( isset( $key ) ? ( isset( $request[$key] ) ? ( $request===$this->_session ? unserialize( $request[$key] ) : $request[$key] ) : null ) : $request );
    }
}