<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Objeto del tipo Float
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  08/04/2012
 * @access public
 */
class Class_Object_Float implements Class_Interface_Object
{

    private $_float = null;
    private $_round = null;

    /**
     * Retorna el nombre del tipo de datos.
     * 
     * @return string "Float"
     */
    public function nameTypeData()
    {
        return "Float";
    }

    /**
     * Método Constructor, Inicializa Variables.
     * 
     * @param integer $numberRound número de decimales
     * @return void
     */
   public function __construct($numberRound = null)
    {	
       	if( $numberRound == null) $numberRound = 5;
		$this->_round = $numberRound;
    }


    /**
     * Setea el valor del objeto Float.
     * 
     * @param float $float
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($float, $null = false)
    {

        $typeData = gettype($float);
       
       if($typeData == 'string'){
            $temp = $float;
            $temp = trim($temp);
            if(strlen($temp) == 0) $float = $temp;
        }
        
        if($float === false){
            $this->_float = null;
            return false;
        }
        
        if($null === true and empty($float)){
			$this->_float = null;
			return true;	
		}
		
		$cleanFloat = (float)$float;

        if (($float !== true) && ((string )$cleanFloat === (string )$float or filter_var
            ($float, FILTER_VALIDATE_FLOAT))) {

            $this->_float = round($cleanFloat, $this->_round);
            return true;
        }

        $this->_float = null;
        return false;
    }

    /**
     * Obtiene el valor del objeto Float.
     * 
     * @return float
     */
    public function getValue()
    {
        
            return $this->_float;
        
    }


    /**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLFLT8"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_FLOAT);
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
