<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para medir el tiempo de carga del aplicativo.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
Class Class_Performance
{
	/**
	 * Almacena el tiempo cuando inicia la web
	 */
	private static $_startLoad;
        private static $_subTest;

	/**
	 * Captura el tiempo inicial,
	 * 
	 * @return void
	 */
	public function __construct()
	{

	}
        
        public static function begin()
        {
            $performance = Class_Config::get('performance');
	if($performance == 1){
            self::$_startLoad = self::_getMicroTime();
            }
        }

	/**
	 * Obtiene el tiempo
	 * 
	 * @return string
	 */
	private static function _getMicroTime()
		{
		$micro = microtime();
		$micro = explode(' ',$micro);
		$micro = $micro[1] + $micro[0];

		return $micro;
		}
                
        public static function capture($observation = '')
        {
           $performance = Class_Config::get('performance');
	        if($performance == 1){ 
                $micro = self::_getMicroTime();
                $memory = round(memory_get_usage() / 1024,1);
                $module = Class_FrontController::getModule();
                $controller = Class_FrontController::getController();
                $action = Class_FrontController::getAction();
                self::$_subTest[] = array($micro, $memory, $module , $controller , $action, $observation );
                }
        }

       /**
        * Calcula el tiempo de carga y el consumo de memoria
        *
        * @return string
        */
	public static function end()
	{
		
		$performance = Class_Config::get('performance');
	        if($performance == 1){ 

                self::capture('Fin');
                $dateTime = date("Y-m-d h:i:s");
                $sql = "INSERT INTO performance VALUES(null, '".$dateTime."','".Class_Security::getIp()."')";
                $objDB = new Class_SuperDataBase();
                $objDB->executeQuerySelect($sql);
                
                $id = $objDB->getLink()->insert_id;
                
		$j = 1;
                foreach (self::$_subTest as $k){
                    
                    $time = number_format( ($k[0] - self::$_startLoad) , 10);
                    
                    $sql = "INSERT INTO performance_detail VALUES(".$id.",".$j.",".$time.",".$k[1];
                    $sql .=  ",'".$k[2]."','".$k[3]."','".$k[4]."','".$k[5]."')";
                    $objDB->executeQuerySelect($sql);
                    $j++;
                }
                    
                }
	}
	

}