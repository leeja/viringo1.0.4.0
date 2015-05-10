<?php

class Class_Db_Mssql_Mssql {
    
    private static $singleInstancia = array();
   // private static $_link;
 
	private function __construct(){ }
 
	public static function getInstance($urlServer, $userDataBase, $passwordUserDataBase, $nameDataBase, $portServerDataBase){
		if(!isset(self::$singleInstancia[$nameDataBase][$userDataBase])){
			//self::$singleInstancia[$nameDataBase][$userDataBase] = new mysqli($urlServer, $userDataBase, $passwordUserDataBase, $nameDataBase, $portServerDataBase);
                        //$link = @mssql_connect($urlServer.':'.$portServerDataBase,$userDataBase,$passwordUserDataBase);
                        $link = @mssql_connect($urlServer,$userDataBase,$passwordUserDataBase);
                        self::$singleInstancia[$nameDataBase][$userDataBase] = $link;
                        @mssql_select_db($nameDataBase,$link);
                        
		}
		return self::$singleInstancia[$nameDataBase][$userDataBase];
	}
 
//        public static function getLink()
//        {
//            return 
//        }
            
}

?>
