<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Objeto del tipo Age
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  08/04/2012
 * @access public
 */
class Class_Object_Extend_Age implements Class_Interface_Object
{

    private $_age;

    /**
     * Obtiene el tipo de datos del objeto Age.
     * 
     * @return string
     */
    public function nameTypeData()
    {
        return Class_Object::DATA_AGE;
    }

    /**
     * Setea el valor del objeto Age.
     * 
     * @param integer $age
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($age, $null = false)
    {
        
        $this->_age = new Class_Object_Int(Class_Object_Int::BIGINT, true);
    	
        if ($null === true and empty($age)) {
             $this->_age->setValue(null, true);
            return true;
        }

        //if ((float)$age >= 0 and $this->_age->setValue($age))
          if ($this->_age->setValue($age, $null))
            return true;


          

        $this->_age->setValue(null, true);
        return false;

    }


    /**
     * Obtiene el valor del objeto Age.
     * 
     * @return integer
     */
    public function getValue()
    {
        
            return $this->_age->getValue();
        
    }

    /**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLINT4"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_AGE);

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
