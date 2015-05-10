<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Clase para Objetos tipo Boolean.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  21/03/2012
 * @access public
 */
class Class_Object_Boolean implements Class_Interface_Object
{

    private $_boleean = null;

    /**
     *
     */
    public function  __construct() {
        ;
    }

    
    /**
     * Obtiene el valor del objeto Boolean en formato SQL, true = '1' y false = '0'.
     * 
     * @return string
     */
    public function getValueSql()
    {
        if($this->_boleean) return '1';
        else return '0';
    }
    

    /**
     * Retorna el nombre del tipo de datos.
     * 
     * @return string "Boolean"
     */
    public function nameTypeData()
    {
        return Class_Object::DATA_BOOLEAN;
    }

     
    /**
     * Setea el valor del objeto bool.
     * 
     * @param mixed $boolean
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($boolean, $null = false)
    {

            $typeData = gettype($boolean);	
       
	    if($boolean === 'true') $boolean = true;
	    else if($boolean === 'false') $boolean = false;


            if($typeData == 'string'){
            $temp = $boolean;
            $temp = trim($temp);
            if(strlen($temp) == 0) $boolean = $temp;
        }
        
	if($null === true and (!isset($boolean) or strlen($boolean) == 0)){
			$this->_boleean = null;
			return true;	
	}
        
        if (($typeData == 'boolean' and ($boolean === true or $boolean === false)) or ($boolean == '1' or $boolean == '0') ) {

            $this->_boleean = (boolean)$boolean;
            return true;

        }
        $this->_boleean = null;
        return false;
    }


    /**
     * Obtiene el valor del objeto bool.
     * 
     * @return bool
     */
    public function getValue()
    {
        return $this->_boleean;
     }

    /**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLBIT"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_BOOLEAN);
    }

    /**
     * Obtiene la longitud maxima del objeto.
     * 
     * @return null
     */
    public function getLengthMax()
    {
        return null;
    }
}
