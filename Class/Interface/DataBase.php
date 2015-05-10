<?PHP

	interface Class_Interface_DataBase{
			
			const USERROOT = 0;	
			const USERSELECT = 1;
			const USERINSERT = 2;
			const USERUPDATE = 3;
			const USERDELETE = 4;						
		
//                        public function __construct($prefixDb);
                        public function setPrefixDb($prefixDb);
			public function connectDataBase($typeUser = NULL, $nameDataBase = NULL, $urlServer = NULL, $userDataBase = NULL, $passwordUserDataBase = NULL, $portServerDataBase = NULL);
			public function disconnectDataBase();
		
			public function executeQuerySelect($sql);
			public function executeQueryUpdate($sql);
			public function exploreAllArraySelect();
			public function exploreArraySelect($result);
			public function exploreRowSelect($result);
			public function exploreAssocSelect($result);
			public function numberRowAffected();
			public function numberRows();
			public function numberCols();
			//public function realEscapeString($string);
                        
                        
                        public function getNumberError();
                        public function getMessageError();
                       

			public function executeQueryStoreProcedure($nameStoreProcedure,$arraySetVariable = NULL, $arrayValueVariable = NULL,  $arrayTypeDataVariable = NULL, $arraySizeDataVariable = NULL,  $debugger = FALSE, $die = TRUE);
			
			public function executeUpdateStoreProcedure($nameStoreProcedure,$arraySetVariable = NULL, $arrayValueVariable = NULL,  $arrayTypeDataVariable = NULL, $arraySizeDataVariable = NULL,  $debugger = FALSE, $die = TRUE);
			
			
			
	}