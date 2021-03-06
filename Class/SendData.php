<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para manipular los envios por GET, POST, SESSION
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  14/03/2012
 * @access public
 */
class Class_SendData
{

    /**
     * $_GET, $_POST, $_SESSION
     * @var integer
     */
    const TYPE_SEND_DATA_SHORT = 1;

    /**
     * $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_SESSION_VARS
     * @var integer
     */
    const TYPE_SEND_DATA_LARGE = 2;


    public static function arrayGet()
    {
           
                    if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
			     return $_GET;	
                    else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE) 
                         return $HTTP_GET_VARS;
		
    }
    
    public static function arrayPost()
    {
           
                    if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
			     return $_POST;	
                    else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE) 
                         return $HTTP_POST_VARS;
		
    }
    
    /**
     * Obtiene el arreglo GET o POST.
     * 
     * @param string $key 'get' o 'post'
     * @static
     * @return array
     */
    public static function arrayKeys($key)
    {
        if (isset($key)) {

            switch ($key) {

                case 'get':
                    if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
			     return array_keys($_GET);	
                    else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE) 
                         return array_keys($HTTP_GET_VARS);

			return null;	       
                    break;

                case 'post':
                    if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
                        return array_keys($_POST); 
                    else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE)  
                       return array_keys($HTTP_POST_VARS);

			return null;
                    break;
            }
        }
    }

	/**
     * Setea una variable del m�todo POST.
     * 
     * @param string $key nombre de la variable
     * @param mixed $value
     * @static
     * @return void
     */
    public static function setPost($key, $value)
    {
        if (isset($key) and isset($value)) {
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
                $_POST[$key] = $value;
	     else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE) 
                $HTTP_POST_VARS[$key] = $value;

	  return true;
        }
	return false;

    }


    /**
     * Obtiene una variable enviada por el m�todo POST.
     * 
     * @param string $key nombre de la variable
     * @param bool $debug muestra el valor en pantalla
     * @param bool $addslashes agrega '\' cuando encuentra ' o "
     * @static
     * @return string
     */
    public static function post($key, $debug = false, $addslashes = true)
    {

	if(isset($key)){
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT)
	        if(isset($_POST[$key])) $data = $_POST[$key];
            else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE)
               if(isset($HTTP_POST_VARS[$key])) $data = $HTTP_POST_VARS[$key];

            if (isset($data)) {
		if (!get_magic_quotes_gpc() and $addslashes == true)
                    $data = Class_App::addSlash($data);
                if ($debug == true)
                   var_dump($data);
                 return $data;
            }
	}
	return null;
    }

    /**
     * Setea una variable del m�todo GET.
     * 
     * @param string $key nombre de la variable
     * @param mixed $value
     * @static
     * @return void
     */
    public static function setGet($key, $value)
    {
        if (isset($key) and isset($value)) {
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
                $_GET[$key] = $value;
	     else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE) 
                $HTTP_GET_VARS[$key] = $value;

	  return true;
        }
	return false;

    }

    /**
     * Obtiene una variable enviada por el m�todo GET.
     * 
     * @param string $key nombre de la variable
     * @param bool $debug muestra el valor en pantalla
     * @param bool $addslashes agrega '\' cuando encuentra ' o "
     * @static
     * @return string
     */
    public static function get($key, $debug = false, $addslashes = true)
    {

       if(isset($key)){
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT)
		 if(isset($_GET[$key])) $data = $_GET[$key];
            else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE)
               if(isset($HTTP_GET_VARS[$key])) $data = $HTTP_GET_VARS[$key];
                
            
            if (isset($data)) {

                
		if (!get_magic_quotes_gpc() and $addslashes == true)
                    $data = Class_App::addSlash($data);
                if ($debug == true)
                   var_dump($data);
                 return $data;
            }
	}
	return null;
    }

    /**
     * Obtiene una variable enviada por el m�todo REQUEST.
     * 
     * @param string $key nombre de la variable
     * @param bool $debug muestra el valor en pantalla
     * @param bool $addslashes agrega '\' cuando encuentra ' o "
     * @static
     * @return string
     */
    public static function request($key, $debug = false, $addslashes = true)
    {

        if(isset($key)){
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT)
	        if(isset($_REQUEST[$key])) $data = $_REQUEST[$key];
            else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE)
               if(isset($HTTP_REQUEST_VARS[$key])) $data = $HTTP_REQUEST_VARS[$key];

            if (isset($data)) {

                 if (!get_magic_quotes_gpc() and $addslashes == true)
                    $data = Class_App::addSlash($data);
                if ($debug == true)
                   var_dump($data);
                 return $data;

            }
	}
	return null;
    }

    /**
     * Setea una variable del array REQUEST.
     * 
     * @param string $key nombre de la variable
     * @param mixed $value
     * @static
     * @return void
     */
    public static function setRequest($key, $value)
    {
        if (isset($key) and isset($value)) {
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
                $_REQUEST[$key] = $value;
	     else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE) 
                $HTTP_REQUEST_VARS[$key] = $value;

	  return true;
        }
	return false;

    }

    /**
     * Obtiene una variable enviada por el arreglo SERVER.
     * 
     * @param string $key nombre de la variable
     * @static
     * @return string
     */
    public static function server($key)
    {
	if(isset($key)){
        if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT)	
	     if(isset($_SERVER[$key])) return $_SERVER[$key];
        else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE)
            if(isset($HTTP_SERVER_VARS[$key])) return $HTTP_SERVER_VARS[$key];
	 }
	 return null;
    }

    /**
     * Setea una variable del arreglo SESSION.
     * 
     * @param string $key nombre de la variable
     * @param mixed $value
     * @static
     * @return void
     */
    public static function setSession($key, $value)
    {

	if (isset($key) and isset($value)) {
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT) 
                $_SESSION[$key] = $value;
	     else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE) 
                $HTTP_SESSION_VARS[$key] = $value;

	  return true;
        }
	return false;

    }
    
    
    /**
     * Obtiene una variable enviada por el arreglo FILE.
     * 
     * @param string $key nombre de la variable
     * @static
     * @return string
     */
    public static function file($key)
    {
       
	if(isset($key)){
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT)
	        if(isset($_FILES[$key])) return  $_FILES[$key];
            else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE)
               if(isset($HTTP_POST_FILES[$key])) return  $HTTP_POST_FILES[$key];
            }
           return null;

	}
 
    
    /**
     * Obtiene una variable enviada por el arreglo SESSION.
     * 
     * @param string $key nombre de la variable
     * @static
     * @return string
     */
    public static function session($key)
    {

	if(isset($key)){
            if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_SHORT)
	        if(isset($_SESSION[$key])) return $_SESSION[$key];
            else if (Class_Config::get('typeSendData') === self::TYPE_SEND_DATA_LARGE)
               if(isset($HTTP_SESSION_VARS[$key])) return $HTTP_SESSION_VARS[$key];
            }
           return null;
        
    }
}