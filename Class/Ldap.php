<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones LDAP.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Ldap
{
    private $_serverLdapPrimary;
    private $_serverLdapSecond;
    private $_domain;
    private $_ldapRdn;
    private $_ldapConn;
    private $_ldapBind;
    private $_userLdap = array();

    /**
     * Segundo Servidor Ldap activo
     */
    const LDAP_RETURN_SECONDSERVER = 1;

    /**
     * Primer Servidor Ldap activo
     */
    const LDAP_RETURN_PRIMARYSERVER = 2;

    /**
     * Ningún Servidor Ldap activo
     */
    const LDAP_RETURN_NO_CONNECTED = 0;

    /**
     * Usuario no conectado
     */
    const LDAP_RETURN_VALIDATE_NO_CONNECTED = 3;

    /**
     * Usuario Incorrecto
     */
    const LDAP_RETURN_VALIDATE_USER_INCORRECT = 2;

    /**
     * Usuario Correcto
     */
    const LDAP_RETURN_VALIDATE_USER_CORRECT = 1;


    /**
     * Método Constructor, inicializa las variables<br>
     * obtiene los valores de:<br>
     * $config['primaryServerLdap'] = 'ldap.petroperu.com.pe'<br>
     * $config['secondServerLdap'] = 'tdsono.petroperu.com.pe'
     * 
     * @param string $server dns Servidor Ldap (opcional)
     * @return void
     */
    public function __construct($server = null)
    {
        if (empty($server)) {
            $this->_serverLdapPrimary = gethostbyname(Class_Config::get('primaryServerLdap'));
            $this->_serverLdapSecond = gethostbyname(Class_Config::get('secondServerLdap'));

        } else {
            $this->_serverLdapPrimary = $server;
            $this->_serverLdapSecond = $server;
        }

    }

    /**
     * Conecta con el servidor Ldap.<br>
     * Intenta conectar con el Servidor Secundario, si no logra conectarse, prueba con el Servidor Primario.
     * 
     * @return integer (LDAP_RETURN_SECONDSERVER, LDAP_RETURN_PRIMARYSERVER o LDAP_RETURN_NO_CONNECTED)
     */
    public function connectLdap()
    {

        if ($this->_pingLdap('secondServerLdap')) {
            $this->_ldapConn = @ldap_connect($this->_serverLdapSecond);
            $returnLdap = @ldap_bind($this->_ldapConn);
            if ($returnLdap)
                return Class_Ldap::LDAP_RETURN_SECONDSERVER;
        }
        if ($this->_pingLdap('primaryServerLdap')) {
            $this->_ldapConn = @ldap_connect($this->_serverLdapPrimary);
            $returnLdap = @ldap_bind($this->_ldapConn);
            if ($returnLdap)
                return Class_Ldap::LDAP_RETURN_PRIMARYSERVER;
        }

        return Class_Ldap::LDAP_RETURN_NO_CONNECTED;
    }

    /**
     * Verifica el usuario dentro del arbol del Ldap
     * 
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $userLogin Ej: jbarbaran
     * @return bool
     */
    public function checkUserLdap($userDomain, $userLogin)
    {
        $tempConnection = $this->connectLdap();
        $ds = $this->_ldapConn;

        if ($tempConnection === Class_Ldap::LDAP_RETURN_SECONDSERVER or $tempConnection
            === Class_Ldap::LDAP_RETURN_PRIMARYSERVER) {
            $justthese = array('uid', 'cn', 'sn', 'mail', 'givenname', 'shadowLastChange',
                'shadowMax', 'shadowWarning');
            $dn = 'o=' . $userDomain . ',' . Class_Config::get('dcLdap');
            $filter = '(uid=$userLogin)';
            $sr = @ldap_search($ds, $dn, $filter, $justthese); //max limit 500

            if ($sr) {
                $this->_userLdap = @ldap_get_entries($ds, $sr);
                if ($this->_userLdap)
                    return true;
                else
                    return false;
            } else
                return false;
        } else
            Class_Error::messageError('Unable to connect to LDAP');
    }

    /**
     * Desconecta del servidor Ldap
     * 
     * @return bool
     */
    private function _disconnect()
    {
        if ($this->_ldapConn)
            return ldap_close($this->_ldapConn);
        else
            return true;
    }

    /**
     * Verifica si el servidor Ldap esta activo
     * 
     * @param string $server
     * @return bool
     */
    private function _pingLdap($server)
    {
       
        if (gethostbyname(Class_Config::get($server)) === Class_Config::get($server))
            return false;
        else
            return true;
    }

    /**
     * Obtiene el nombre del host del Servidor Ldap con el cual esta conectado
     * 
     * @return string
     */
    public function getHostNameLdap()
    {
        $tempConnection = $this->connectLdap();
        $ds = $this->_ldapConn;
        if ($tempConnection === Class_Ldap::LDAP_RETURN_SECONDSERVER or $tempConnection
            === Class_Ldap::LDAP_RETURN_PRIMARYSERVER) {
            if ($tempConnection === Class_Ldap::LDAP_RETURN_SECONDSERVER)
                return Class_Config::get('secondServerLdap');
            else
                if ($tempConnection === Class_Ldap::LDAP_RETURN_PRIMARYSERVER)
                    return Class_Config::get('primaryServerLdap');
        } else
            Class_Error::messageError('Unable to connect to LDAP');
    }
    
    /**
     * Obtiene el uid del Usuario
     * 
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $userLogin Ej: jbarbaran
     * @return string
     */
    public function getLoginUserLdap($userDomain, $userLogin)
    {
        if ($this->checkUserLdap($userDomain, $userLogin))
            return $this->_userLdap[0]['uid'][0];
        else
            Class_Error::messageError('Unable to connect to LDAP');
    }

    /**
     * @deprecated
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $userLogin Ej: jbarbaran
     * @return string
     */
    public function getShadowWarningUserLdap($userDomain, $userLogin)
    {
        if ($this->checkUserLdap($userDomain, $userLogin))
            return $this->_userLdap[0]['shadowWarning'][0];
        else
            Class_Error::messageError('Unable to connect to LDAP');
    }
    
    /**
     * Obtiene el cn del Usuario
     * 
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $userLogin Ej: jbarbaran
     * @return string
     */
    public function getNameUserLdap($userDomain, $userLogin)
    {
        if ($this->checkUserLdap($userDomain, $userLogin))
            return $this->_userLdap[0]['cn'][0];
        else
            Class_Error::messageError('Unable to connect to LDAP');
    }
    
    /**
     * Obtiene el givename del Usuario
     * 
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $userLogin Ej: jbarbaran
     * @return string
     */
    public function getFirstNameUserLdap($userDomain, $userLogin)
    {
        if ($this->checkUserLdap($userDomain, $userLogin))
            return $this->_userLdap[0]['givenname'][0];
        else
            Class_Error::messageError('Unable to connect to LDAP');
    }
    
    /**
     * Obtiene el sn del Usuario
     * 
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $userLogin Ej: jbarbaran
     * @return string
     */
    public function getLastNameUserLdap($userDomain, $userLogin)
    {
        if ($this->checkUserLdap($userDomain, $userLogin))
            return $this->_userLdap[0]['sn'][0];
        else
            Class_Error::messageError('Unable to connect to LDAP');
    }
    
    /**
     * Obtiene el mail del Usuario
     * 
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $userLogin Ej: jbarbaran
     * @return string
     */
    public function getEmailNameUserLdap($userDomain, $userLogin)
    {
        if ($this->checkUserLdap($userDomain, $userLogin))
            return $this->_userLdap[0]['mail'][0];
        else
            Class_Error::messageError('Unable to connect to LDAP');
    }
    
    /**
     * Lista los usuarios del arbol de dominio.
     * 
     * @param string $userDomain Ej: Operaciones Norte
     * @param string $justThese Ej: 'cn'
     * @param string $filter  Ej: '*'
     * @return array
     */
    public function listUserLdap($userDomain, $justThese = 'cn', $filter = '*')
    {
        $tempConnection = $this->connectLdap();
        $ds = $this->_ldapConn;

        if ($tempConnection === Class_Ldap::LDAP_RETURN_SECONDSERVER or $tempConnection
            === Class_Ldap::LDAP_RETURN_PRIMARYSERVER) {

            $dn = 'o=' . $userDomain . ',' . Class_Config::get('dcLdap');
            $filter = '(uid=$filter)';
            $sr = @ldap_search($ds, $dn, $filter, $justThese); //max limit 500

            if ($sr) {
                $entradas = @ldap_get_entries($ds, $sr);
                if ($entradas)
                    return $entradas;
                else
                    Class_Error::messageError('Unable to connect to LDAP');
            } else
                Class_Error::messageError('Unable to connect to LDAP');
        } else
            Class_Error::messageError('Unable to connect to LDAP');

    }
    
    /**
     * Valida el usuario en el servidor Ldap
     * 
     * @param string $userLogin Ej: jbarbaran
     * @param string $userPassword
     * @param string $userDomain Ej: Operaciones Norte
     * @return bool
     */
    public function validateLdap($userLogin, $userPassword, $userDomain)
    {
        $this->_ldapRdn = 'uid=' . $userLogin . ',ou=Usuarios,o=' . $userDomain . ',' .
            Class_Config::get('dcLdap');

        $tempConnection = $this->connectLdap();


        if ($tempConnection === Class_Ldap::LDAP_RETURN_SECONDSERVER or $tempConnection
            === Class_Ldap::LDAP_RETURN_PRIMARYSERVER) {

            $this->_ldapBind = @ldap_bind($this->_ldapConn, $this->_ldapRdn, $userPassword);

        } else {

            return Class_Ldap::LDAP_RETURN_VALIDATE_NO_CONNECTED;
        }


        if ($this->_ldapBind === false) {
            return Class_Ldap::LDAP_RETURN_VALIDATE_USER_INCORRECT;
        }

        $this->_disconnect();

        return Class_Ldap::LDAP_RETURN_VALIDATE_USER_CORRECT;


    }
	
	/**
     * Método destructor, desconecta del servidor Ldap
     * 
     * @return void
     */
    public function __destruct()
    {
        $this->_disconnect();
    }

}
