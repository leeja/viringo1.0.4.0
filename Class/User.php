<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para manejar Datos de los Usuarios
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  14/03/2012
 * @access public
 */
class Class_User
{

    protected $_PkStaff;
    protected $_tab;
    protected $_login;
    protected $_firstLastName;
    protected $_secondLastName;
    protected $_name;
    protected $_email;
    protected $_Fk_rol;

    protected $_Fk_dependency;
    protected $_state;
    protected $_Fk_operation;

    protected $_idLocalUser;
    protected $_typeUser;

    /**
     * Longitud del campo ficha
     * @var integer
     */
	const LEN_CHAR_TAB = 35;
	
	/**
	 * Longitud del campo Login
	 * @var integer
	 */
    const LEN_CHAR_LOGIN = 35;
    
    /**
     * Longitud del campo Primer Apellido
     * @var integer
     */
    const LEN_CHAR_FIRSTLASTNAME = 30;
    
    /**
     * Logintud del campo Segundo Apellido
     * @var integer
     */
    const LEN_CHAR_SECONDLASTNAME = 30;
    
    /**
     * Longitud del campo Nombres
     * @var integer
     */
    const LEN_CHAR_NAME = 50;
    
    /**
     * Longitud del Campo Email
     * @var integer
     */
    const LEN_CHAR_EMAIL = 100;

	/**
     * Longitud del Campo State
     * @var integer
     */
	const LEN_CHAR_STATE = 1;

    /**
     * Método Constructor, Inicializa variables privadas.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->_PkStaff = new Class_Object_Extend_Pk();
        $this->_tab = new Class_Object_String(self::LEN_CHAR_TAB);
        $this->_login = new Class_Object_String(self::LEN_CHAR_LOGIN);
        $this->_firstLastName = new Class_Object_String(self::LEN_CHAR_FIRSTLASTNAME);
        $this->_secondLastName = new Class_Object_String(self::LEN_CHAR_SECONDLASTNAME);
        $this->_name = new Class_Object_String(self::LEN_CHAR_NAME);
        $this->_email = new Class_Object_Extend_Email(self::LEN_CHAR_EMAIL);
        $this->_Fk_rol = new Class_Object_Extend_Pk();
        $this->_Fk_dependency = new Class_Object_Extend_Pk();
        $this->_state = new Class_Object_String(self::LEN_CHAR_STATE);
        $this->_Fk_operation = new Class_Object_Extend_Pk();
        $this->_idLocalUser = new Class_Object_Extend_Pk();
        $this->_typeUser = new Class_Object_Int();
    }

    

    /**
     * Setea la variable privada pkStaff.
     * 
     * @param integer $pkStaff
     * @return bool
     */
    public function setPkStaff($pkStaff, $null = false)
    {
            if ($this->_PkStaff->setValue($pkStaff, $null))
                return true;
            Class_Error::messageError('You can not assign a user id empty');
    }

    /**
     * Obtiene el valor de la variable privada pkStaff.
     * 
     * @return integer
     */
    public function getPkStaff()
    {
        return $this->_PkStaff->getValue();
    }

    
    /**
     * Setea la variable privada tag (Ficha).
     * 
     * @param string $tab
     * @return bool
     */
    public function setTab($tab , $null = false)
    {
        
            if ($this->_tab->setValue($tab, $null))
                return true;
            Class_Error::messageError('You can not assign a user tab empty');
        
    }

    /**
     * Obtiene el valor de la variable privada tag (Ficha).
     * 
     * @return string
     */
    public function getTab()
    {
        return $this->_tab->getValue();
    }

    
    /**
     * Setea la variable privada login.
     * 
     * @param string $login
     * @return bool
     */
    public function setLogin($login, $null = false)
    {
            if ($this->_login->setValue($login, $null))
                return true;
           Class_Error::messageError('You can not assign a user login empty');
    }

    /**
     * Obtiene el valor de la variable privada login.
     * 
     * @return string
     */
    public function getLogin()
    {
        return $this->_login->getValue();
    }

    
    /**
     * Setea la variable privada firstLastName (Apellido Paterno).
     * 
     * @param string $firstLastName
     * @return bool
     */
    public function setFirstLastName($firstLastName, $null = false)
    {
            if ($this->_firstLastName->setValue($firstLastName, $null))
                return true;
            Class_Error::messageError('You can not assign a name to the user empty');
    }


    /**
     * Obtiene el valor de la variable privada firstLastName (Apellido Paterno).
     * 
     * @return string
     */
    public function getFirstLastName()
    {
        return $this->_firstLastName->getValue();
    }

    
    /**
     * Setea la variable privada secondLastName (Apellido Materno).
     * 
     * @param string $secondLastName
     * @return bool
     */
    public function setSecondLastName($secondLastName, $null = false)
    {
        
            if ($this->_secondLastName->setValue($secondLastName, $null))
                return true;
            Class_Error::messageError('You can not assign a name to the user empty');
    }

    /**
     * Obtiene el valor de la variable privada secondLastName (Apellido Materno).
     * 
     * @return string
     */
    public function getSecondLastName()
    {
        return $this->_secondLastName->getValue();
    }


    /**
     * Setea la variable privada name (Nombres).
     * 
     * @param sring $name
     * @return bool
     */
    public function setName($name, $null = false)
    {
            if ($this->_name->setValue($name, $null))
                return true;
            Class_Error::messageError('You can not assign a name to the user empty');
    }

	
    /**
     * Obtiene el valor de la variable privada name (Nombres).
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name->getValue();
    }

    
    /**
     * Setea la variable privada email.
     * 
     * @param string $email
     * @return bool
     */
    public function setEmail($email, $null = false)
    {
            if ($this->_email->setValue($email, $null))
                return true;
            Class_Error::messageError('You can not assign an empty email to the user');
    }


    /**
     * Obtiene el valor de la variable privada email.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->_email->getValue();
    }


    
    /**
     * Setea la variable privada fkRol.
     * 
     * @param integer $fkRol
     * @return bool
     */
    public function setFkRol($fkRol, $null = false)
    {
            if ($this->_Fk_rol->setValue($fkRol, $null))
                return true;
            Class_Error::messageError('You can not assign an empty rol to the user');
    }

    /**
     * Obtiene el valor de la variable privada pkRol.
     * 
     * @return integer
     */
    public function getFkRol()
    {
        return $this->_Fk_rol->getValue();
    }

    
    /**
     * Setea la variable privada fkDependency.
     * 
     * @param integer $fkDependency
     * @return bool
     */
    public function setFkDependency($fkDependency, $null = false)
    {
            if ($this->_Fk_dependency->setValue($fkDependency, $null))
                return true;
           Class_Error::messageError('You can not assign an empty dependency to the user');
    }


    /**
     * Obtiene el valor de la variable privada fkDependency.
     * 
     * @return integer
     */
    public function getFkDependency()
    {
        return $this->_Fk_dependency->getValue();
    }

    
    /**
     * Setea la variable privada state.
     * 
     * @param string $state
     * @return bool
     */
    public function setState($state, $null = true)
    {
            if ($this->_state->setValue($state, $null))
                return true;
            Class_Error::messageError('You can not assign an empty state to the user');
    }


    /**
     * Obtiene el valor de la variable privada state.
     * 
     * @return string
     */
    public function getState()
    {
        return $this->_state->getValue();
    }

    
    /**
     * Setea la variable privada fkOperation.
     * 
     * @param integer $fkOperation
     * @return bool
     */
    public function setFkOperation($fkOperation, $null = false)
    {
            if ($this->_Fk_operation->setValue($fkOperation, $null))
                return true;
            Class_Error::messageError('You can not assign an empty operation to the user');
    }


    /**
     * Obtiene el valor de la variable privada fkOperation.
     * 
     * @return integer
     */
    public function getFkOperation()
    {
        return $this->_Fk_operation->getValue();
    }


    /**
     * Setea la variable privada idLocalUser.
     * 
     * @param integer $idLocalUser
     * @return bool
     */
    public function setIdLocalUser($idLocalUser, $null = false)
    {
            if ($this->_idLocalUser->setValue($idLocalUser, $null))
                return true;
             Class_Error::messageError('You can not assign a user id empty o string in the Class User');
    }

    /**
     * Obtiene el valor de la variable privada idLocalUser.
     * 
     * @return integer
     */
    public function getIdLocalUser()
    {
        return $this->_idLocalUser->getValue();
    }


    /**
     * Setea la variable privada typeUser.
     * 
     * @param integer $typeUser
     * @return bool
     */
    public function setTypeUser($typeUser, $null = false)
    {
            if ($this->_typeUser->setValue($typeUser, $null))
                return true;
            Class_Error::messageError('You can not assign a user to type');
    }


    /**
     * Obtiene el valor de la variable privada typeUser.
     * 
     * @return integer
     */
    public function getTypeUser()
    {
        return $this->_typeUser->getValue();
    }

}
