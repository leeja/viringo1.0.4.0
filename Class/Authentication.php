<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones de Autenticación.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  01/01/2012
 * @access public
 */
class Class_Authentication
{
    /**
     * Longitud del Login
     * 
     * @var string
     */
    const LEN_LOGIN = 50;
    
    /**
     * Longitud de la contraseña
     * 
     * @var string
     */
    const LEN_PASSWORD = 50;
    
    /**
     * variable que almacena el mensaje de validación.
     * @var string
     * @access private
     */
    private $_returnMessage;

    /**
     * variable que almacena el login del usuario.
     * @var string
     * @access private
     */
    private $_login;


    /**
     * Valida el usuario en el servidor LDAP.<br>
	 * Almacena el mensaje de validación en la variable $_returnMessage.
     * 
     * <b>[algoritmo]</b><br>
     * <i>Condición:</i> Valida el $loginUser y $passwordUser, en una tabla encriptada de la Base de Datos Master (hace uso de la clase Class_Master).<br>
     * <i>Verdadero:</i> Asigna el $loginUser a la variable privada _login, retorna true.<br>
     * <i>Falso:</i> <br>
     * Conecta con el Servidor Ldap, mediante la clase Class_Ldap.<br>
     * Valida el $loginUser, $passwordUser y $domainUser en el Servidor Ldap.<br>
     * <i>Condición:</i> Verifica la cadena de retorno.<br>
     * <i>Si se conecta:</i> Actualiza o ingresa el usuario a la Base de Datos Master.<br>
     * <i>No se conecta:</i> Retorna mensaje de 'usuario no valido'.
     * 
     * @param string $loginUser ej: jbarbaran
     * @param string $passwordUser ej: ******
     * @param string $domainUser ej: Operaciones Norte
     * @return boolean
     */
    public function authenticatesUser($loginUser, $passwordUser, $domainUser)
    {
        $flag = true;
        
        $this->_login = null;

        $master = new Class_Master;
        $result = $master->getAuthenticates($loginUser, $passwordUser);

        if ($result) {
            $this->_returnMessage = Class_Authentication_Language::get('userValid');
            $this->_login = $loginUser;
            
        } else {

            $objLdap = new Class_Ldap();

            $temp = $objLdap->validateLdap($loginUser, $passwordUser, $domainUser);

            if ($temp === Class_Ldap::LDAP_RETURN_VALIDATE_NO_CONNECTED) {
                $this->_returnMessage = Class_Authentication_Language::get('serverNotFound');
                $flag = false;
            } elseif ($temp === Class_Ldap::LDAP_RETURN_VALIDATE_USER_INCORRECT) {
                $this->_returnMessage = Class_Authentication_Language::get('userNotValid');
                $flag = false;
            } elseif ($temp === Class_Ldap::LDAP_RETURN_VALIDATE_USER_CORRECT) {
                    $this->_returnMessage = Class_Authentication_Language::get('userValid');
                    $result = $master->updateAuthenticates($loginUser, $passwordUser);
                    if ((int)$result > 0) 
                        $this->_login = $loginUser;
                    else {
                        $result = $master->insertAuthenticates($loginUser, $passwordUser);
                        if ((int)$result > 0) 
                            $this->_login = $loginUser;
                        else
                            $flag = false;

                    }
              } else $flag = false;
        }
        return $flag;
    }


    /**
     * Obtiene los datos de un usuario.
     * 
     * <b>[algoritmo]</b><br>
	 * Si el parametro $loginUser es null, el método obtiene los datos del último usuario verificado con el método authenticatesUser de esta clase.
     * 
     * @param string $loginUser
     * @return object Class_USer
     */
    public function getDataUser($loginUser = null)
    {
        if (empty($loginUser))
            $loginUser = $this->_login;

        $master = new Class_Master;
        $result = $master->getDataUser($loginUser);
        return $result;

    }


    /**
     * Retorna el mensaje de validación.
     * 
     * @return string
     */
    public function getReturnMessage()
    {
            if (empty($this->_returnMessage))	Class_Error::messageError('returnMessage not found');
            return $this->_returnMessage;
    }

    /**
     * Valida el usuario en una tabla local del aplicativo.
     * 
     * @param string $loginUser
     * @param string $passwordUser
     * @param string $nameStoreProcedure
     * @return array registro de la tabla
     */
    public function localAuthenticates($loginUser, $passwordUser, $nameStoreProcedure)
    {
        $return = null;
        
        $objDataBase = new Class_SuperDataBase(Class_Interface_DataBase::USERSELECT);

        $arraySetVariable = array('@InLogin', '@InPassword');
        $arrayValueVariable = array(($loginUser), ($passwordUser));
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING, Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(self::LEN_LOGIN, self::LEN_PASSWORD);

        $result = $objDataBase->executeQueryStoreProcedure($nameStoreProcedure, $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

         $numTemp = $objDataBase->exploreRowSelect($result); 
         if(isset( $numTemp )) $return = $numTemp[0];
        
         return $return;

    }


    /**
     * Verifica que el usuario se encuentre en la tabla de Usarios del aplicativo.
     * 
     * <b>[algoritmo]</b><br>
	 * Si el parametro $loginUser es null, el método obtiene los datos del último usuario verificado con el metodo authenticatesUser de esta clase.
     * 
     * @param string $loginUser
     * @param string $nameStoreProcedure por defecto 'verify_user'
     * @return int pkTypeUser
     */
    public function verifyUser($loginUser = null, $nameStoreProcedure = 'verify_user', $arrayParameters = null)
    {
        if (empty($loginUser))
            $loginUser = $this->_login;

        $master = new Class_Master;
        $result = $master->verifyUser($loginUser, $nameStoreProcedure, $arrayParameters );
        return $result;
    }
}
