<?php



/**
 * Description of Mysqli
 *
 * @author User
 */
class Class_Db_Mysql_Mysqli {
    
    private static $singleInstancia = array();
 
	private function __construct(){ }
 
	public static function getInstance($urlServer, $userDataBase, $passwordUserDataBase, $nameDataBase, $portServerDataBase){
		if(!isset(self::$singleInstancia[$nameDataBase][$userDataBase])){
			self::$singleInstancia[$nameDataBase][$userDataBase] = new mysqli($urlServer, $userDataBase, $passwordUserDataBase, $nameDataBase, $portServerDataBase);
		}
		return self::$singleInstancia[$nameDataBase][$userDataBase];
	}
 
            
}

