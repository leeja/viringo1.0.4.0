<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones Generales de Objetos de Datos.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Object
{
    
	/**
     * Tipo de Dato Text
     * 
     * @var string
     */
    const DATA_TEXT = 'Text';
	

    /**
     * Tipo de Dato String
     * 
     * @var string
     */
    const DATA_STRING = 'String';

    /**
     * Tipo de Dato Int
     * 
     * @var string
     */
    const DATA_INT = 'Int';

    /**
     * Tipo de Dato Boolean
     * 
     * @var string
     */
    const DATA_BOOLEAN = 'Boolean';

    /**
     * Tipo de Dato Date
     * 
     * @var string
     */
    const DATA_DATE = 'Date';

    /**
     * Tipo de Dato Float
     * 
     * @var string
     */
    const DATA_FLOAT = 'Float';

    /**
     * Tipo de Dato Age
     * 
     * @var string
     */
    const DATA_AGE = 'Age';

    /**
     * Tipo de Dato Email
     * 
     * @var string
     */
    const DATA_EMAIL = 'Email';

    /**
     * Tipo de Dato Name
     * 
     * @var string
     */
    const DATA_NAME = 'Name';

    /**
     * Tipo de Dato Pk
     * 
     * @var string
     */
    const DATA_PK = 'Pk';


    /**
     * Asigna el valor del arreglo obtenido de la Base de Datos
     * 
     * @param string $key Nombre de la variable del arreglo $config
     * @static 
     */
    public static function setValueToArray(&$array, $name, $value, $null = false, $typeData = null,
        $parameterConstruct1 = null, $parameterConstruct2 = false)
    {

        if (isset($typeData)) {

            switch ($typeData) {

                case self::DATA_STRING:
				case self::DATA_TEXT:
                    $object = new Class_Object_String($parameterConstruct1);
                    break;

                case self::DATA_INT:

                    $object = new Class_Object_Int($parameterConstruct1, $parameterConstruct2);
                    break;

                case self::DATA_FLOAT:
                    $object = new Class_Object_Float($parameterConstruct1);
                    break;

                case self::DATA_DATE:
                    $object = new Class_Object_Date($parameterConstruct1);
                    break;

                case self::DATA_BOOLEAN:
			
                    $object = new Class_Object_Boolean();
                    break;

                case self::DATA_AGE:
                    $object = new Class_Object_Extend_Age();
                    break;

                case self::DATA_EMAIL:
                    $object = new Class_Object_Extend_Email($parameterConstruct1);
                    break;

                case self::DATA_NAME:
                    $object = new Class_Object_Extend_Name($parameterConstruct1);
                    break;

                case self::DATA_PK:
                    $object = new Class_Object_Extend_Pk($parameterConstruct1);
                    break;

                default:
                    Class_Error::messageError('Error ' . $typeData );

            }
            if (is_object($object))
                $array[$name] = $object;
            else
                Class_Error::messageError('Error ' . $typeData );
        }

	if(gettype($value) == 'array')
            $value = $value[$name];
		
        if (!$array[$name]->setValue(($value), $null)){
            Class_Error::messageError('Error ' . $name . ' ' . $value, E_NOTICE);
	     return false;
	 }
	 return true;

    }

    
	public static function getTypeDataSQL( $typeData )
	{
		
		if (isset($typeData)) {
		if( Class_Config::get('typeDataBase') == 'Mssql' ){
		
            switch ($typeData) {
				case self::DATA_TEXT:
				     return SQLTEXT;
					 break;
                case self::DATA_STRING:
					
                    return SQLVARCHAR;
                    break;

                case self::DATA_INT:
			
			return SQLINT4;
                    break;

                case self::DATA_FLOAT:
                    return SQLFLT8;
                    break;

                case self::DATA_DATE:
                    return SQLVARCHAR;
                    break;

                case self::DATA_BOOLEAN:
			return SQLBIT;
                    
                    break;

                case self::DATA_AGE:
                    return SQLINT1;
                    break;

                case self::DATA_EMAIL:
                    return SQLVARCHAR;
                    break;

                case self::DATA_NAME:
                    return SQLVARCHAR;
                    break;

                case self::DATA_PK:
                    return SQLINT4;
                    break;

                default:
                    Class_Error::messageError('Error ' . $typeData );

       	     }
		}
			elseif(Class_Config::get('typeDataBase') == 'Mysql' ){
			
			return $typeData;
		}
	   }
	  
	}

    /*

     
  public function testObject($array,  $typeData)
    {

            switch ($typeData) {

                case self::DATA_STRING:
                    $object = new Class_Object_String($parameterConstruct1);
                    break;

                case self::DATA_INT:
                    $object = new Class_Object_Int($parameterConstruct1, $parameterConstruct2);
                    break;

                case self::DATA_FLOAT:
                    $object = new Class_Object_Float($parameterConstruct1);
                    break;

                case self::DATA_DATE:
                    //$object = new Class_Object_Date();
                    $testObject = 'Class_Object_Date';
                    break;

                case self::DATA_BOOLEAN:
                    $object = new Class_Object_Boolean();
                    break;

                case self::DATA_AGE:
                    $object = new Class_Object_Extend_Age();
                    break;

                case self::DATA_EMAIL:
                    $object = new Class_Object_Extend_Email($parameterConstruct1);
                    break;

                case self::DATA_NAME:
                    $object = new Class_Object_Extend_Name($parameterConstruct1);
                    break;

                case self::DATA_PK:
                    $object = new Class_Object_Extend_Pk($parameterConstruct1);
                    break;

                default:
                    Class_Error::messageError('Error ' . $typeData );

            }

        $obj = array();
            
        $null = false;
        echo "Test ".$typeData."<br />";
        echo "#####Test sin aceptar nulos####";

	for($i = 1; $i <= count($array); $i++){

            $value = $array[$i-1];
            $object = new $testObject;
            $result = $object->setValue($value, $null);

            echo "<br />";
            if($result){
               echo $i." OK: ".$object->getValue()."  "."  (".gettype($value).")";
               
            }
            else{
                echo $i." Error: ".$value."  (".gettype($value).")";
            }

        }

        $null = true;
        echo "<br />";
        echo "<br />";
        echo "#####Test aceptando nulos####";

	for($i = 1; $i <= count($array); $i++){

            $value = $array[$i-1];
            $object = new $testObject;
            $result = $object->setValue($value, $null);

            echo "<br />";
             if($result){
               echo $i." OK: ".$object->getValue()."  (".gettype($value).")";
               $obj[] = $object;
            }
            else{
                echo $i." Error: ".$value."  (".gettype($value).")";
            }

        }

        echo "<br /><br /><br />";

        return $obj;
    }
*/
    

}
