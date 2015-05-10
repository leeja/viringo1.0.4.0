<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones de notificación de errores
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version  1.0.1.0  26/02/2012
 * @access public
 */
class Class_Error
{

    /**
     * Constante para definir que el mensaje se guardará en el log y no se mostrará en la aplicación
     */
    const E_LOG = 'E_LOG';

    /**
     * Nombre del archivo error.log donde se almacenan todos los errores de todos los aplicativos. 
     */
    const FILELOG = 'error.log';

    /**
     * Servidor Mail Configurado $config['configurationMailServer'] = 1.
     */
    const MAILSERVER = 1;

    /**
     * Modo desarrollo $config['modeDevelopment'] = 1.
     */
    const MODEDEVELOPMENT = 1;

    /**
     * Ruta del archivo error.log.
     */
    const PATHLOG = '/Log/';


    static  $ip;
    static $date;
    static $nameApplication;
    static $post;
    static $get;
    static $url;
    static $controller;
    static $action;
    static $module;
    static $tracer;
            

    /**
     * Abre el archivo error.log y guarda el mensaje suministado por _bodyMsg.
     * 
     * @see Class_Error::_bodyMsg
     * @param string $msgError
     * @return void
     */
    private static function _logError($msgError, $path = null)
    {
        
        if($path == null) $path = '/library/'.VERSION.self::PATHLOG . self::FILELOG;
    	error_log ($msgError , 3 , $path);

    }
    
    private static function _getFileError($v)
    {
        if(isset($v['file'])) $file = $v['file']."::";
        else $file = '';
        
        return $file;
    }
    
    private static function _getLineError($v)
    {
        if(isset($v['line'])) $line = $v['line']."::";
        else $line = '';
        
        return $line;
    }
    
    private static function _getClassError($v)
    {
        if(isset($v['class'])) $class = $v['class']."::";
        else $class = '';
        
        return $class;
    }
    
    private static function _getFunctionError($v)
    {
        if(isset($v['function'])) $function = $v['function']."::";
        else $function = '';
        
        return $function;
    }
    
    private static function _walkDebugError()
    {
        $backtracel = "";
                
        foreach(debug_backtrace() as $k=>$v){ 
            if($k != 0){
            
                if(self::_getFunctionError($v) == "include" || self::_getFunctionError($v) == "include_once" || self::_getFunctionError($v) == "require_once" || self::_getFunctionError($v) == "require"){ 
                    $backtracel .= "#".$k." ".self::_getClassError($v).self::_getFunctionError($v)."(".$v['args'][0].") called at [".self::_getFileError($v).":".self::_getLineError($v)."]\r\n"; 
                }else{ 
                    $backtracel .= "#".$k." ".self::_getClassError($v).self::_getFunctionError($v)."() called at [".self::_getFileError($v).":".self::_getLineError($v)."]\r\n"; 
                }
            
            } 
        } 
        return $backtracel;
    }
   
    
    private static function _saveLogInDB($msgError)
    {
        $objDataBase = new Class_SuperDataBase(Class_Interface_DataBase::USERINSERT);
        
        $msgError = $objDataBase->realEscapeString($msgError);
        self::$tracer = $objDataBase->realEscapeString(self::$tracer);
        self::$module = $objDataBase->realEscapeString(self::$module);
        self::$controller  = $objDataBase->realEscapeString(self::$controller);      
        self::$action = $objDataBase->realEscapeString(self::$action);
        self::$url = $objDataBase->realEscapeString(self::$url);
                
            $sql = "INSERT INTO error_log VALUES(null, '".self::$ip."','".self::$date."','".$msgError."','".self::$tracer."'";
            $sql .= ",'".self::$module."','".self::$controller."','".self::$action."','".self::$url."','',0)";
//            echo $sql;
          $objDataBase->executeQueryUpdate($sql);
   
        
    }
    
    private static function _loadInformationError()
    {
            self::$ip = Class_Security::getIP();
            self::$date = Class_App::getDateTimeNow();
            self::$nameApplication = Class_Config::get('nameApplication');

            $post = Class_SendData::arrayPost();
            $get = Class_SendData::arrayGet();
            self::$post = json_encode($post);
            self::$get = json_encode($get);
            self::$url = Class_SendData::server('REQUEST_URI');
            
            self::$controller = Class_FrontController::getController();
            self::$action = Class_FrontController::getAction();
            self::$module = Class_FrontController::getModule();

            self::$tracer = self::_walkDebugError(); 
    }
    
    private static function _setMsgError($msgError, $format = 'html')
    {
               
        $msg = "Name Application = ".self::$nameApplication."\r\n";
        $msg .= "Ip = ".self::$ip."\r\n";
        $msg .= "Date = ".self::$date."\r\n";
        $msg .= "Url = ".self::$url."\r\n";
        $msg .= "Post = ".self::$post."\r\n";
        $msg .= "Get = ".self::$get."\r\n";
        $msg .= "Module = ".self::$module."\r\n";
        $msg .= "Controller = ".self::$controller."\r\n";
        $msg .= "Action = ".self::$action."\r\n";
        $msg .= self::$tracer;
        $msg .= $msgError;
        
        if($format == 'html')
            return nl2br ($msg);
        return $msg;
        
    }
    
    /**
     * Envia el mensaje de error al correo del webmaster o imprime el mensaje en pantalla.
     * 
     * <b>[algoritmo]</b><br>
     * <i>Condición:</i> $config['modeDevelopment'] != 1  y $config['configurationMailServer'] == 1.<br>
     * <i>Verdadero:</i> Envia un email con el error y le muestra un mensaje amigable al usuario.<br>
     * <i>Falso:</i> Muestra el mensaje de error en pantalla.
     * 
     * Los errores en modo ejecución obligatoriamente se guarden en el archivo error.log.
     *  
     * @param string $msgError Mensaje de error, definido por el desarrollador.
     * @param integer si $typeError = E_ERROR, E_WARNING o E_PARSE, el error obligatoriamente se muestra en pantalla.
     * @return void
     */
    public static function messageError($msgError, $typeError = E_ERROR)
    {
        if (isset($msgError)) {
        
            self::_loadInformationError();
            self::_saveLogInDB($msgError);
            $msgErrorHtml = self::_setMsgError($msgError, 'html');
            $msgErrorText = self::_setMsgError($msgError, 'text');
                            
            if (Class_Config::get('modeDevelopment') === Class_Error::MODEDEVELOPMENT) {
                
                if ($typeError == E_ERROR or $typeError == E_WARNING or $typeError == E_PARSE)
                    die($msgErrorHtml);
                elseif($typeError != self::E_LOG)
                    echo ($msgErrorHtml);
            } else{
                self::_logError($msgErrorText);
                
                if (Class_Config::get('configurationMailServer') === Class_Error::MAILSERVER) {
                    $tempEmail = Class_Config::get('sendMailFrom');
                    $tempDeveloperEmail = Class_Config::get('developerEmail');
                    $header = 'From: ' . $tempEmail ;
                    error_log($msgErrorHtml, 1, $tempDeveloperEmail, $header);
                } 
                    
                if ($typeError == E_ERROR or $typeError == E_WARNING or $typeError == E_PARSE)
                   die(Class_Error_Language::get('error'));
                    
                
		}
        } else {
            die('Error Not Found, Message Empty');
            exit(0);
        }


    }

    /**
     * Igual que messageError, pero se puede incluir en try-catch como un mensaje de excepcion.<br>
     * Ejemplo:<br>
     * <code>
     * try {
     *       if (empty($this->_returnMessage))
     *           throw new Exception('returnMessage not found');
     *       else
     *           return $this->_returnMessage;
     *   }
     *   catch (exception $e) {
     *       Class_Error::messageErrorTryCatch($e->getMessage(), $e->getFile(), $e->getLine());
     *   }
     * </code>
     * 
     * @see Class_Error::messageError
     * @static
     * @param string $message mensaje de error
     * @param string $file archivo .php
     * @param string $line línea de código
     * @param string $code código php
     * @return void
     */
    public static function messageErrorTryCatch($message, $file = null, $line = null,
        $code = null, $typeError = E_ERROR)
    {
        if (!empty($message))
            $tempMessage = 'Message: ' . $message;
        if (!empty($file))
            $tempMessage .= ' - Script: ' . $file;
        if (!empty($line))
            $tempMessage .= ' - Line: ' . $line;
        if (!empty($code))
            $tempMessage .= ' - Code: ' . $code;

        Class_Error::messageError($tempMessage, $typeError);
    }
}