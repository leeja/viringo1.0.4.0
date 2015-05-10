<?PHP
/**
 * @package viringo1.0.3.1
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * @see class Smarty 3.1.11
 * @link http://www.smarty.net/
 */
if(Class_Config::exists('smartyVersion'))
	$smartyVersion = Class_Config::get('smartyVersion');
else $smartyVersion = "3.1.11";


require_once ("smarty/$smartyVersion/libs/Smarty.class.php");

/**
 * Funciones para cargar la Clase Smarty
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  14/03/2012
 * @access public
 */
class Class_Smarty extends Smarty
{
    
    /**     
     * Declarar las variables smarty y asignar los mensajes usados en todo el aplicativo
     * 
     * @return void
     */
    public function __construct()
    {		
        parent::__construct();
        
        //if(!$this->getTemplateDir())
                $this->setTemplateDir(Class_Config::get('pathSmartyTemplateDir'));
        
        //if(!$this->getCompileDir())
                $this->setCompileDir(Class_Config::get('pathSmartyCompileDir'));
	
        global $messages;
      
        $this->assign($messages);
       
    }

    /**
     * Asigna valor a una variable smarty, utilizando un valor del arreglo de mensages
     *
     * @param string $message clave del arreglo de mensages
     * @return void
     */
    public function assignTo ($message)
    {
        $this->assign($message, Class_Message::get ($message));
    }


   
}