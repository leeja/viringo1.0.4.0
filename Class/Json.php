<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Javascript Object Notation.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Json
{

    private static  $_array;

    /**
     * Limpia el arreglo
     * 
     */
    public function  __construct()
    {
        self::clearArray();
    }

    
    /**
     *  Recorre el arreglo de objetos o elmentos y retorna otro arreglo modificado con utf8
     * 
     * @param string $input arreglo de entrada
     * @param boolean $utf8 bandera si codifica a utf8
     * @return array 
     */
    private static function _walk( $input, $utf8 = true)
    {
	if(is_object($input)){
            $input = $input->getValue();
        }

        if(!is_array($input)) {
            if($utf8 == true) return Class_App::utf8($input);
            return $input;
        }
	$output = array();
	foreach($input as $key => $value){
		$output[$key] = self::_walk($value);
	}
	return $output;
    }

    /**
     * Limpiar los elementos del arreglo
     * @static
     */
    public static function clearArray()
    {
        self::$_array = null;
    }

    /**
     * Agrega elementos al array
     * @param array|string $array valor a ser agregado al array
     * @param string $key Clave que se asigna al elemento en el array, default = null
     * @param bool $utf8 Especifica si los valores del array deben ser codificados a utf8, default = true
     * @static
     */
    public static function addArray($array, $key = null, $utf8 = true)
    {		
	$array = self::_walk ($array, $utf8);
        if(isset($key))
            self::$_array[$key] = $array;            
        else
            self::$_array[] = $array;
    }

    /**
     * Elimina un elemento del array     
     * @param string $key Clave del elemento que se desea eliminar,
     * si se omite se elimina el ultimo elemento que ha sido agregado, default = null
     * @return boolean
     * @static
     */
    public static function removeArray($key = null)
    {
        $returnValue = false;
        if(is_array(self::$_array) ){
            if(isset($key)){
                if(isset(self::$_array[$key]) ){
                    unset(self::$_array[$key]);
                    $returnValue = true;
                }
            }else{
                if(count(self::$_array) > 0){
                    array_pop(self::$_array);
                    $returnValue = true;
                }
            }
        }
        return $returnValue;
    }

    /**
     * codifica los valores que han sido agregados al array
     * @static
     */
    public static function encode()
    {
        echo json_encode(self::$_array);
    }

    /**
     * Codifica el valor en un unico array
     * @param array|string $array valor a ser codificado
     * @param bool $utf8 Especifica si los valores del array deben ser codificados a utf8, default = true
     * @static
     */
    public static function encodeArray( $array, $utf8 = true, $print = true)
    {
        self::clearArray();
        if(!is_array($array))
            self::addArray($array, null, $utf8);
        else
            self::$_array = self::_walk($array, $utf8);
	if($print == true)
        self::encode();
	return json_encode(self::$_array);

    }

}

