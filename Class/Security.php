<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones que gestionan la Seguridad del Aplicativo.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  12/03/2012
 * @access public
 */
class Class_Security
{
    /**
     * Numero de intentos permitidos en el logeo
     * 
     * @var integer
     */
    const NUMBER_OF_ATTEMPTS = 3;

    
    /**
     * Cuenta el número de intentos que se hace para ingresar a la web
     * 
     * @return void
     */
    public static function countAttempts()
    {
    	self::sessionStart();
	$countAttempst = Class_SendData::session('countAttempst');
	if(empty($countAttempst)) Class_SendData::setSession('countAttempst', 1);
	else{
	    $countAttempst++;
	Class_SendData::setSession('countAttempst', $countAttempst);
   	 }
    
    	if($countAttempst >= self::NUMBER_OF_ATTEMPTS){
	   self::_ipBanned();
	  } 
    }
    
    private function _ipBanned()
    {
    $ip = self::getIp();
    
    }

    /**
     * Valida los script PHP dentro de un proyecto
     * 
     * @static
     * @param string $code
     * @param string $page
     * @return bool
     */
    public static function validatePage($code, $page = null)
    {
        $securityCode = Class_Config::get('securityCode');

        if ($code === $securityCode)
            return true;

        Class_Error::messageError('Security in Application ' . $page);

    }

    /**
     * Inicia Session
     * 
     * @static
     * @return void
     */
    public static function sessionStart()
    {
       $name = Class_Config::get('prefixDb');
	if(isset($name)){ @session_name($name);
        //session_set_cookie_params(0,$name);
        }
	
	$session = session_id();
        if (empty($session))
            session_start();
    }

   /**
     * Destruye Session
     * 
     * @static
     * @return void
     */
    public static function sessionDestroy()
    {
       
	$session = session_id();
        if (!empty($session)){
           
		session_destroy();
        }
    }


    /**
     * Verifica la Seguridad de los Script.
     * 
     * @static
     * @return bool
     */
    public static function getSecurity()
    {
        self::sessionStart();
        if (Class_SendData::session('security') == sha1(self::getIP()))
            return true;
        else {
	      self::sessionDestroy();
	      
            //header("Location:" . Class_Config::get('urlApp'));
	     $sessionDestroyScripts = '<script type="text/javascript" language="javascript">window.location.href =  "'.Class_Config::get('urlApp').'/'.Class_Config::get('welcomePage').'/Index//option/1/";</script>'; 
		  if(Class_SendData::get('jsonRequest') == '1' ){
		  $result = array('sessionDestroy'=>true, 'sessionDestroyScripts'=>$sessionDestroyScripts);
		  Class_Json::encodeArray($result);
		  }
               else{
		        echo $sessionDestroyScripts;   
		 }
             
             
             exit();

        }
    }

	public static function existsSession()
	{
		self::sessionStart();
		if (Class_SendData::session('security') == sha1(self::getIP()))
            		return true;
		else return false;
	}

    /**
     * Setea la Seguridad.
     * 
     * @static
     * @return bool
     */
    public static function setSecurity()
    {
        self::sessionStart();
        if (Class_SendData::setSession('security', sha1(self::getIP())))
            return true;
        return false;
    }

    /**
     * Obtiene el IP de la PC Cliente
     * 
     * @return string
     */
    public static function getIp()
    {
        $ip = Class_SendData::server('REMOTE_ADDR');
        return $ip;
    }

    /**
     * Registra en la tabla audit de cada aplicaciï¿½n, los accesos a los modulos
     * 
     * @param integer $module
     * @param integer $idUser
     * @return bool
     */
    public static function setLogUser($module, $idUser = null)
    {

        if ($idUser === null) {
            $objUser = Class_SendData::session('objUser');
            $objUser = unserialize($objUser);

            if ($objUser)
                $idUser = $objUser->getIdLocalUser();
            else
                Class_Error::messageError('Users Session not Found, Need for Audit');

            if ($idUser === null or empty($idUser))
                Class_Error::messageError('Id Users Session not Found, Need for Audit');
        }

        $dateTime = Class_App::getDateTimeNow();
        $ip = self::getIP();

        $objDataBase = new Class_SuperDataBase(Class_Interface_DataBase::USERINSERT);

        $arraySetVariable = array('@InFkUser', '@InIpPc', '@InDateTime', '@InFkModule');
        $arrayValueVariable = array($idUser, $ip, $dateTime, $module);
        $arrayTipeDataVariable = array(SQLINT4, SQLVARCHAR, SQLVARCHAR, SQLINT4);
        $arraySizeDataVariable = array(null, 23, 30, null);

        $result = $objDataBase->executeUpdateStoreProcedure('add_audit', $arraySetVariable,
            $arrayValueVariable, $arrayTipeDataVariable, $arraySizeDataVariable, false);

        if ($objDataBase->numberRowAffected())
            return true;
        else
            return false;

    }

}