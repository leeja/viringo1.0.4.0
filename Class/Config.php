<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para obtener variables de configuración.
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  01/01/2012
 * @access public
 */
class Class_Config
{

    /**
     * Obtiene un valor de configuración, de $config[$key].
     * 
     * @param string $key Nombre de la variable del arreglo $config
     * @return string
     * @global string $config de config.inc.php
     * @static 
     */
    public static function get($key)
    {
        if (!empty($key)) {
            global $config;
	    if(!isset($config[$key])) Class_Error::messageError('Key "'. $key .'" Not Found in array $config of Config.inc.php');
            }
       else
           Class_Error::messageError('Key  Not Found in array $config of Config.inc.php');
      
      return $config[$key];
    }



    public static function exists ($key)
 	{
	   if (!empty($key)) {
            global $config;
	     if(!isset($config[$key])) return false;
	     else return true;
         }	
		return false;
	}

    public static function set($key, $value = null)
   {
	if (!empty($key)) {
            global $config;
	     $config[$key] = $value;
	     return true;
         }	
	return false;


    }	
}
