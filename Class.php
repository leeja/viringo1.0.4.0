<?PHP

define( 'VERSION' , 'viringo1.0.4.0');

if(! appLicency($config['securityCode']) ){

 if($config['configurationMailServer'] == 1){
	$header = 'From: ' . $config['developerEmail'] ;
	$message = $config['urlApp'];
	$mail = mail('soporte@jasoftsolutions.com','Intento de uso de '. VERSION,$message,$header);

 }
 die('Contact us, soporte@jasoftsolutions.com');
}

set_error_handler ('functionError');
function functionError($errno, $errstr, $errfile, $errline)
{
 if( 0 != error_reporting () )
  {
  switch ($errno) {
    case E_ERROR:
        $error = "<b>ERROR</b> [$errno] $errstr<br />\n";
        $error .=  "  Error fatal en la línea $errline en el archivo $errfile";
	if(class_exists ('Class_Error'))
        	Class_Error::messageError($error);
       else
       	 die($error);
        break;

    case E_WARNING:
        $error = "<b>WARNING</b> [$errno] $errstr en la línea $errline de $errfile<br />\n";
        if(class_exists ('Class_Error'))
        	Class_Error::messageError($error, E_NOTICE);
       else
	 	echo $error;

        break;
        
    case E_PARSE:
        $error = "<b>PARSE</b> [$errno] $errstr en la línea $errline de $errfile<br />\n";
        if(class_exists ('Class_Error'))
       	 Class_Error::messageError($error);
       else
        	die($error);

        break;

    case E_NOTICE:
        $error = "<b>NOTICE</b> [$errno] $errstr en la línea $errline de $errfile<br />\n";
	if(class_exists ('Class_Error'))
        	Class_Error::messageError($error, E_NOTICE);
       else
		 echo $error;
        break;

    default:
        $error = "<b>Error:</b> [$errno] $errstr en la línea $errline de $errfile<br />\n";
        if(class_exists ('Class_Error'))
       	 Class_Error::messageError($error);
       else
       	 die($error);

        break;
    }
  }
}

spl_autoload_register('viringoAutoload');
function viringoAutoload($className)
{
    $structClass = explode('_', $className);
    if ($structClass[0] == 'Class'){
    	//if( searchClassFdrap($className) )
    	//{
    	$include = VERSION . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	
        require_once($include);
                
    	//}
    	//else die("Class $className not found, does not belong to " . VERSION);
    }
    elseif($structClass[0] == 'Smarty'){
	
	}
    else{
        
    	$include = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    	//if(file_exists($include)){
    		require_once ($include);
	//	}
   	//else{
		//if(class_exists( 'Class_Error' ) ){
		//	debug_print_backtrace();
		//}
		//else{
   	//	die("Class $className not found in viringo");
		//}
	 //   }
  }
}

function appLicency( $securityCode )
{
	$flag = false;
        if($securityCode == sha1('viringo1.0.4.0'.' '.NAME_SITE))
		$flag = true;
	return $flag;

}

function searchClassFdrap($className)
{
	$arrayClass = array('Class_App',
                            'Class_App_Language',
                            'Class_Authentication',
                            'Class_Authentication_Language',
                            'Class_Config',
                            'Class_Config_Language',
                            'Class_FrontController',
                            'Class_Entities',
                            'Class_Error',
                            'Class_Error_Language',
                            'Class_File',
                            'Class_File_Language',
                            'Class_Ldap',
                            'Class_Ldap_Language',
                            'Class_Mail',
                            'Class_Mail_Language',
                            'Class_Master',
                            'Class_Message',
                            'Class_Message_Language',
                            'Class_Performance',
                            'Class_Security',
                            'Class_Security_Language',
                            'Class_SendData',
                            'Class_SuperDataBase',
                            'Class_UpFile',
                            'Class_UpFile_Language',
                            'Class_User',
                            'Class_User_Language',
                            'Class_Db_Factory',
                            'Class_Db_Mysql',
                            'Class_Db_Mssql',
                            'Class_Excel_Reader',
                            'Class_Interface_DataBase',
                            'Class_Interface_Object',
                            'Class_Object_Boolean',
                            'Class_Object_Date',
                            'Class_Object_Float',
                            'Class_Object_Int',
                            'Class_Object_String',
                            'Class_Object_Extend_Age',
                            'Class_Object_Extend_Email',
                            'Class_Object_Extend_Pk',
                            'Class_Object_Extend_Name',
                            'Class_Smarty',
                            'Class_Search',
                            'Class_Search_Html',
                            'Class_Pagination',
                            'Class_Report',
                            'Class_Object',
                            'Class_Db_Pgsql',
                            'Class_Json',
                            'Class_Button',
                            'Class_Debug',
                            'Class_Report_Form',
                            'Class_Report_Language',
                            'Class_Db_Mysql_Language',
                            'Class_Db_Mssql_Language',
                            'Class_Db_Mysql_Mysqli',
                            'Class_Db_Mssql_Mssql',
                            'Class_WebService',
                            'Class_Object_Reference',
				'Class_Session_Validator');	
        
	return in_array( $className, $arrayClass);
}