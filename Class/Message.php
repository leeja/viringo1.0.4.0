<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para obtener los mensajes.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Message
{

    /**
     * Obtiene un mensaje, de $message[$key].
     * 
     * @param string $key Nombre de la variable del arreglo $messages
     * @param bool $htmlentities aplica o no la función htmlentities de PHP
     * @return string
     * @global string message.inc.php o LangSpanish.php
     * @static 
     */
    public static function get($key, $htmlentities = false)
    {

	 if (isset($key)) {
             global $messages;
	     if(!isset($messages[$key]))
		 Class_Error::messageError('Key "'. $key .'" Not Found in array $message of /Componets/Messages/Lang'.Class_Config::get('language').'.php');
            }
         else 
                Class_Error::messageError('Key "'. $key .'" Not Found in array $message of /Componets/Messages/Lang'.Class_Config::get('language').'.php');

        if ($htmlentities)
               return htmlentities($messages[$key], ENT_QUOTES, ini_get('default_charset'));
        else
               return $messages[$key];
	
    }
    
    public static function exists ($key)
 	{
	   if (!empty($key)) {
            global $messages;
	     if(!isset($messages[$key])) return false;
	     else return true;
         }	
		return false;
	}

}
