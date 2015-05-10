<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Clase Padre para Entidades.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  01/01/2012
 * @access public
 */
class Class_Entities
{
    /**
     * Arreglo de objetos variables
     *
     * @var array
     * @access public
     */
    public $var = array();

    /**
     * retorna los nombres asociativos del arreglo $var
     * 
     * @return array
     */
    public function getArrayVar()
    {
        $return = null;
        
        if (isset($var)) {
            foreach ($var as $k => $v) {
                $array[] = $k;
            }
            $return = $array;
        }
        return $return;

    }

    /**
     * Combierte un variable $name para usarla como parametro de un procedimiento almacenado.
     * 
     * Ejemplo: si $name es 'pkUser', el método retorna 'InPkUser'.
     * 
     * @static
     * @param string $name
     * @return string
     */
    public static function getVarSQL( $name )
    {

        $temp = "In" . ucfirst($name);
        return $temp;
    }

}