<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones Comunes de un Aplicativo.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  01/01/2012
 * @access public
 */
class Class_App
{

    /**
     * Decodifica la cadena ($string) de uf8. 
	 *
	 * <b>[algoritmo]</b><br>
	 * <i>Condición:</i> Verifica si la cadena ($string), no esta vacia y esta codificada.<br>
     * <i>Verdadero:</i> Retorna la cadena ($string) decodificada.<br>
     * <i>False:</i> Retorna la cadena ($string).
     * 
     * @param string $string (cadena)
     * @return string
     * @static
     */
    public static function aUtf8($string)
    {

        if (self::isUtf8($string) and !empty($string) and gettype($string) == 'string')
            $string = utf8_decode($string);
        
        return $string;
    }

    /**
     * Codifica la cadena ($string) con utf8 si la variable dafaul_charset del php.ini esta en UTF-8. 
     * 
     * <b>[algoritmo]</b><br>
     * <i>Condición:</i> Verifica si la cadena ($string), no esta vacia y default_charset (php.ini) es igual a 'UTF-8'.<br>
     * <i>Verdadero:</i> Retorna la cadena ($string) codificada.<br>
     * <i>False:</i> Retorna la cadena ($string). 
     * 
     * @param string $string (cadena)
     * @return string
     * @static
     */
    public static function cout($string)
    {
        if (!empty($string)) {
            $tempCharSet = ini_get('default_charset');
            if ($tempCharSet == 'UTF-8')
                $string = self::utf8($string);
        } 
        return $string;
    }

    /**
     * Obtiene la fecha local del Servidor. La zona por defecto es America/Lima.
     * 
     * <b>[algoritmo]</b><br>
     * Setea la zona por defecto 'America/Lima' con la función: date_default_timezone_set().<br>
     * Obtiene la fecha segun el formato ($format), por defecto 'Y-m-d'.<br>
     * retorna la fecha.
     * 
     * @param string $zone valor de la zona
     * @param string $format por defecto Y-m-d
     * @return string
     */
    public static function getDate($zone = 'America/Lima', $format = 'Y-m-d')
    {

        date_default_timezone_set($zone);
        $date = @date($format);
        if (empty($date))
            Class_Error::messageError('Incorrect Date in @date($format)');
        return $date;

    }

    /**
     * Obtiene la fecha y hora local del Servidor. La zona por defecto es America/Lima.
     * 
     * <b>[algoritmo]</b><br>
     * Setea la zona por defecto 'America/Lima' con la función: date_default_timezone_set().<br>
     * Obtiene la fecha y hora segun el formato ($format), por defecto 'Y-m-d H:i:s'.<br>
     * retorna la fecha y hora.
     * 
     * @param string $zone valor de la zona 
     * @param string $format por defecto Y-m-d H:i:s
     * @return string Fecha y Hora Y-m-d H:i:s
     * @static
     */
    public static function getDateTimeNow($zone = 'America/Lima', $format =
        'Y-m-d H:i:s')
    {
           return self::getDate($zone, $format);
    }

    /**
     * Obtiene el nombre de la aplicacion de la variable Config['nameApplication'].
     *
     * @return string
     * @static
     */
    public static function getNameApplication()
    {
        $string = Class_Config::get('nameApplication');
        if (empty($string))
            $string = 'Not Name Application';
        
        return $string;
    }


    /**
     * 
     * Obtiene la hora local del Servidor. La zona por defecto es America/Lima.
     * 
     * <b>[algoritmo]</b><br>
     * Setea la zona por defecto 'America/Lima' con la función: date_default_timezone_set().<br>
     * Obtiene la hora segun el formato ($format), por defecto 'H:i:s'.<br>
     * retorna la hora.
     * 
     * @param string $zone valor de la localidad
     * @param string $format por defecto H:i:s
     * @return string Hora H:i:s
     * @static
     */
    public static function getTime($zone = 'America/Lima', $format = 'H:i:s')
    {

        return self::getDate($zone, $format);

    }


    /**
     * Verifica si la cadena ($string) esta codificada con utf8.
     * 
     * @param string $string
     * @return boolean
     * @static
     */
    public static function isUtf8($string)
    {
       return mb_detect_encoding($string, 'UTF-8', true);   
	/*
	$flag = false;
        // From http://w3.org/International/questions/qa-forms-utf-8.html
        if (!empty($string) and gettype($string) == 'string') {
            $flag = (preg_match('%^(?: 
		              [\x09\x0A\x0D\x20-\x7E]            # ASCII 
		            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte 
		            |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs 
		            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte 
		            |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates 
		            |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3 
		            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15 
		            |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16 
		        )*$%xs', $string) == 1) ? true : false;
            
            
        } 
        return $flag;
	*/
    }


    /**
     * Codifica la cadena ($string) con uf8. Si la cadena  esta codificada, la función no la codifica. 
     * 
     * @param string $string
     * @return string
     * @static
     */
    public static function utf8($string)
    {
        if(!empty($string) and !self::isUtf8($string) and gettype($string) == 'string')
                $string = utf8_encode($string);
        return $string;
    }

    
    
    public static function utf8Array($array)
    {
        $array = self::_walk ($array, true);
        return $array;
    }
    
    public static function aUtf8Array($array)
    {
        $array = self::_walk ($array, false);
        return $array;
    }
    
    
    private static function _walk( $input, $utf8 = true)
    {
	if(is_object($input)){
            $input = $input->getValue();
        }

        if(!is_array($input)) {
            if($utf8 == true) return Class_App::utf8($input);
            return Class_App::aUtf8($input);
        }
	$output = array();
	foreach($input as $key => $value){
		$output[$key] = self::_walk($value, $utf8);
	}
	return $output;
    }

    public static function addSlash($input)
    {
        $typeData = gettype($input);
        
        if($typeData == 'string'){
            return addslashes($input);
        }
        elseif($typeData == 'array'){
        
            foreach( $input as $k => $v){
                $input[$k] = self::addSlash($v);
            }
            return $input;
                
            
        }
    }

}
