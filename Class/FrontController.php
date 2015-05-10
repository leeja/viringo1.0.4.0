<?PHP
/**
 * @package viringo1.0.4.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones de Controlador MVC.
 *
 * @package viringo1.0.4.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.4.0  12/09/2012
 * @access public
 */


 
class Class_FrontController
{

    /**
     * Controlador
     * @static
     */
    static $_controller;
    
    /**
     * Controlador
     * @static
     */
    static $_module;
    
     /**
     * Acción
     * @static
     */
    static $_action;

    /**
     * @static
     */
    static $_instance;
    
    
    /**
     * Método contructor, que obtiene el url y asigna el Controlador, Acción y los parametros $_GET
     *
	 * <b>[algoritmo]</b><br>
	 * Obtiene Url y asigna valores a la variable $controller y $action de http://Server/Application/$Controller/$Action/$Pameter1/$Value1/$ParameterN/$ValueN.
	 * 
	 * También reconoce cadenas como http://Server/Application/Index.php?controller=$Controller&action=$Action&$parameter1=value1.
	 * 
     * 
     * Si la aplicación se encuentra en mantenimiento Class_Config::get('maintenanceApplication') == 1 sólo pueden ingresar los usuarios WEBMASTER == 1
     *   
     * @return void
     */
    public function __construct()
    {
        
        if(Class_Config::get('maintenanceApplication') == 1){ 
        Class_Security::sessionStart();
        $objUser = unserialize(Class_SendData::session('objUser'));
       
            if(!empty($objUser) and gettype($objUser) == 'object' and $objUser->getTypeUser() != TYPE_USER_WEBMASTER){
                Class_Security::sessionDestroy();
		  $sessionDestroyScripts = "<script>alert('".Class_Config::get('maintenanceApplicationMessages')."');window.location='".Class_Config::get('urlApp')."';</script>"; 
		  if(Class_SendData::get('jsonRequest') == '1' ){
		  $result = array('sessionDestroy'=>true, 'sessionDestroyScripts'=>$sessionDestroyScripts);
		  Class_Json::encodeArray($result);
		  }
               else{
		        echo $sessionDestroyScripts;   
		 }
                exit(0);
          }  
            
        }
        
	
       if(!Class_Config::exists('sessionValidator'))
		{
		$classSessionValidator = 'Class_Session_Validator';	
		}
	else{
		$classSessionValidator = Class_Config::get('sessionValidator');
	     }	
           
	$objSessionValidator = new $classSessionValidator();
	
       
	$controller = Class_SendData::get('controller');
	$action = Class_SendData::get('action');
        $module = Class_SendData::get('module');
       
        if (!empty($controller) && !empty($action) && !empty($module)){
        	self::$_controller = $controller;
        	self::$_action = $action;
              self::$_module = $module;
        }
        else{
                $request = Class_SendData::server('REQUEST_URI');
                $request = substr($request, strlen(NAME_SITE) + 1, strlen($request));
            
		if(!Class_Config::exists('welcomePage'))  Class_Config::set('welcomePage','Default_Index');

        	$splits = explode('/', trim($request, '/'));
        	self::$_module = !empty($splits[0]) ? $splits[0] : Class_Config::get('welcomePage');
	       self::$_controller = !empty($splits[1]) ? $splits[1] : 'Index';
		self::$_action = !empty($splits[2]) ? $splits[2] : '';
	

		if(self::$_module == "public_html" || self::$_module == "Index.php?XDEBUG_SESSION_START=netbeans-xdebug") self::$_module = Class_Config::get('welcomePage');
		if(self::$_controller == "Index.php?XDEBUG_SESSION_START=netbeans-xdebug") self::$_controller = 'Index';
                
                if (!empty($splits[3])) {
                     $keys = $values = array();
                     $count = count($splits);
                     for ($idx = 3; $idx < $count; $idx += 2) {
                         if (isset($splits[$idx + 1])){ 
               	          Class_SendData::setGet($splits[$idx], $splits[$idx + 1]);
				   Class_SendData::setRequest($splits[$idx], $splits[$idx + 1]);

				}
                    }
                }
        }


   if(!$objSessionValidator->validateSession()){
		
			if(Class_Security::existsSession()){
				Class_Security::sessionDestroy();

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


    }

    /**
     * Obtiene la Instancia de esta clase
     *  
     * @return object
     */
    public static function getInstance()
    {
        
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
        
    
    }


    /**
     * Obtiene el nombre del controlador
     * 
     * @return string
     */
    public static function getController()
    {
        return self::$_controller;
    }

    /**
     * Obtiene la acción del controlador
     * 
     * @return string
     */
    public static function getAction()
    {
        return self::$_action ;
    }
    
    /**
     * Obtiene la acción del controlador
     * 
     * @return string
     */
    public static function getModule()
    {
        return self::$_module;
    }

    /**
     * Instalacia la clase Controlador y llama al metodo dependiendo de la acción.
     * <br>
     * Ejemplo de url que acepta:<br>
     * http://webtalaradev/example_mvc/index.php?controller=Test&action=Delete&pkTest=10
     * <br>
     * http://webtalaradev/example_mvc/Test/Delete/pkTest/10
     * 
     * @return object $objController
     */
    public function route()
    {
       $controller = 'Application_'. self::$_module . '_Application_Controllers_'. self::$_controller .'Controller';
	 $action = self::$_action . 'Action';
        return new $controller($action);
       
    }
}
