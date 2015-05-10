<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Objeto del tipo Name
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  08/04/2012
 * @access public
 */
class Class_Object_Extend_Name implements Class_Interface_Object
{
    private $_name = null;

    /**
     * Obtiene el tipo de datos del objeto Name.
     * 
     * @return string
     */
    public function nameTypeData()
    {
        return Class_Object::DATA_NAME;
    }

    /**
     * Método Constructor, Inicializa Variables.
     * 
     * @param integer $top = Tamaño máximo de caracteres del Objeto Email
     * @return void
     */
    public function __construct($top = null)
    {
        $this->_top = $top;
    }

    /**
     * Setea el valor del objeto Name.
     * 
     * @param string $name
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($name, $null = false)
    {
    	$this->_name = new Class_Object_String($this->_top);
    	
    	echo var_dump($name);
    	if ($null === true and (!isset($name) or strlen(trim($name)) == 0)) {
             $this->_name->setValue(null, true);
            return true;
        }
		
       $name = trim($name);
	   $tmp = 	strtolower($name);
	   	   
	   $tmp = str_replace('Á', 'a', $tmp);
       $tmp = str_replace('É', 'e', $tmp);
       $tmp = str_replace('Í', 'i', $tmp);
       $tmp = str_replace('Ó', 'o', $tmp);
       $tmp = str_replace('Ú', 'u', $tmp);
       $tmp = str_replace('ú', 'u', $tmp);
       $tmp = str_replace('ó', 'o', $tmp);
       $tmp = str_replace('á', 'a', $tmp);
       $tmp = str_replace('é', 'e', $tmp);
       $tmp = str_replace('í', 'i', $tmp);
       $tmp = str_replace(' ', '', $tmp);
       $tmp = str_replace("", "", $tmp);
       $tmp = str_replace("\'", "", $tmp);
	   $tmp = str_replace('ñ', 'n', $tmp);
	   $tmp = str_replace('Ñ', 'n', $tmp);
	   $tmp = str_replace('ö', 'o', $tmp);
	   $tmp = str_replace('ä', 'a', $tmp);
	   $tmp = str_replace('ï', 'i', $tmp);
	   $tmp = str_replace('ë', 'e', $tmp);
	   $tmp = str_replace('ü', 'u', $tmp);
	   $tmp = str_replace('Ö', 'o', $tmp);
	   $tmp = str_replace('Ä', 'a', $tmp);
	   $tmp = str_replace('Ï', 'i', $tmp);
	   $tmp = str_replace('Ë', 'e', $tmp);
	   $tmp = str_replace('Ü', 'u', $tmp);
	   
       
        if (ctype_alpha($tmp)) {
                    return $this->_name->setValue($name,$null);
        }
        $this->_name->setValue(null, true);
        return false;

    }

    /**
     * Obtiene el valor del objeto Name.
     * 
     * @return String
     */
    public function getValue()
    {
        
            return $this->_name->getValue();
       
    }

	/**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLVARCHAR"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_NAME);

    }

	/**
     * Obtiene la longitud máxima de la cadena del objeto Name.
     * 
     * @return integer
     */
    public function getLengthMax()
    {
        return $this->_name->getLengthMax();
    }

	/**
     * Obtiene la longitud de la cadena del objeto Name.
     * 
     * @return integer
     */
    public function getLength()
    {
        return $this->_name->getLength();
    }
}
