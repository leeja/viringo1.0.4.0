<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L. */

/**
 * Objeto del tipo Pk
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  08/04/2012
 * @access public
 */
class Class_Object_Extend_Pk implements Class_Interface_Object
{

    private $_primaryKey;

	/**
     * Obtiene el tipo de datos del objeto Pk.
     * 
     * @return string
     */
    public function nameTypeData()
    {
        return Class_Object::DATA_PK;
    }

	/**
     * Método Constructor, Inicializa Variables.<br>
     * Asigna el tipo de dato del PK:  TINYINT, SMALLINT, MEDIUMINT, INT, BIGINT
     * 
     * @param string $type 'INT'
     * @return void
     */
    public function __construct($type = 'INT')
    {
	
	if($type == null or empty($type))
	  $type = 'INT';

        switch ($type) {
            case 'TINYINT':
                $this->_primaryKey = new Class_Object_Int(Class_Object_Int::TINYINT, true);
               
                break;
            case 'SMALLINT':
                $this->_primaryKey = new Class_Object_Int(Class_Object_Int::SMALLINT, true);
                break;

            case 'MEDIUMINT':
                $this->_primaryKey = new Class_Object_Int(Class_Object_Int::MEDIUMINT, true);
                break;

            case 'INT':
                $this->_primaryKey = new Class_Object_Int(Class_Object_Int::VINT, true);
                break;

            case 'BIGINT':
                $this->_primaryKey = new Class_Object_Int(Class_Object_Int::BIGINT, true);
                break;
        }


    }

    /**
     * Setea el valor del objeto Pk.
     * 
     * @param integer $primaryKey
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($primaryKey, $null = false )
    {

		if ($null === true and empty($primaryKey)) {
             $this->_primaryKey->setValue(null, true);
            return true;
        }
        
        if ($this->_primaryKey->setValue( $primaryKey ) and $primaryKey > 0) {
            return true;
        }

       	$this->_primaryKey->setValue(null, true);
        return false;
    }

   
    /**
     * Obtiene el valor del objeto Pk.
     * 
     * @return integer
     */
    public function getValue()
    {
           return $this->_primaryKey->getValue();
       
    }


    /**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLINT4"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_PK);
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
