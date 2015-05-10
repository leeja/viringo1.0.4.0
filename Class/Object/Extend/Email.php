<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Objeto del tipo Email
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  08/04/2012
 * @access public
 */
class Class_Object_Extend_Email implements Class_Interface_Object
{

    private $_email = null;
    private $_user = null;
    private $_domain = null;
    private $_length = null;
    private $_top = null;

    /**
     * Obtiene el tipo de datos del objeto Email.
     * 
     * @return string
     */
    public function nameTypeData()
    {
        return Class_Object::DATA_EMAIL;
    }

    /**
     * M�todo Constructor, Inicializa Variables.
     * 
     * @param integer $top = Tama�o m�ximo de caracteres del Objeto Email
     * @return void
     */
    public function __construct($top = null)
    {
        $this->_top = $top;
    }

    /**
     * Setea el valor del objeto Age.
     * 
     * @param string $email
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($email, $null = false)
    {
        if($email === false) {
            $this->_notSet();
            return false;
        }
        
    if($null == false) $email=  trim($email);

    if ($null === true  and (!isset($email) or strlen($email) == 0)) {

           $this->_notSet();
           return true;
        }

        if ($this->_top == null)
            $top = strlen($email);
		else $top = $this->_top;
      
            
        if (strlen($email) <= $top and (isset($email) and strlen($email) > 0)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->_email = $email;
                $this->_length = strlen($email);
                $email = explode('@', $email);
                $this->_user = $email[0];
                $this->_domain = $email[1];

                return true;
            }

        }

        $this->_notSet();
        return false;

    }

    private function _notSet()
    {
        
        $this->_email = null;
        $this->_length = null;
        $this->_top = null;
        $this->_user = null;
        $this->_domain = null;
        
    }

    /**
     * Obtiene el valor del objeto Email.
     * 
     * @return string
     */
    public function getValue()
    {
            return $this->_email;
        
    }


    /**
     * Obtiene el nombre del usuario del Email.
     * 
     * @return string
     */
    public function getUser()
    {
        if (isset($this->_user))
            return $this->_user;
        return null;
    }


    /**
     * Obtiene el nombre del dominio del Email.
     * 
     * @return string
     */
    public function getDomain()
    {
        if (isset($this->_domain))
            return $this->_domain;
        return null;
    }

    /**
     * Obtiene la longitud del Email.
     * 
     * @return integer
     */
    public function getLength()
    {
        if (isset($this->_length))
            return $this->_length;
        return null;
    }

    /**
     * Obtiene el tipo de dato SQL.
     *  
     * @return integer "SQLVARCHAR"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_EMAIL);

    }

    /**
     * Obtiene la longitud m�xima de la cadena del objeto Email.
     * 
     * @return integer
     */
    public function getLengthMax()
    {
        return $this->_top;
    }
}
