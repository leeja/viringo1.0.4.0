<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Objeto del tipo String
 * 
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  14/03/2012
 * @access public
 */
class Class_Object_String implements Class_Interface_Object
{
    private $_string = null;
    private $_length = null;
    private $_top = null;
    private $_defaultCharsetString = null;
    private $_flagText = 0;

    /**
     * M�todo Constructor, Inicializa Variables.
     * 
     * @param integer $top = Tama�o m�ximo de caracteres del Objeto String
     * @return void
     */
    public function __construct($top = null, $defaultCharsetString = true)
    {
        if($top == null)
            $this->_flagText = 1;
        
        $this->_top = $top;
        $this->_defaultCharsetString = $defaultCharsetString;
    }
    
    /**
     * Obtiene el tipo de datos del objeto String.
     * 
     * @return string
     */
    public function nameTypeData()
    {
      //  if($this->_flagText)
      //   return Class_Object::DATA_TEXT;
     return Class_Object::DATA_STRING;
    }

    

    /**
     * Setea el valor del objeto String.
     * 
     * @param string $string
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($string, $null = false)
    {
	$typeData = gettype($string);	
        
        
        /**
         * Reduce '  ' a ''
         */
    	if($typeData == 'string'){
            $temp = $string;
            $temp = trim($temp);
            if(strlen($temp) == 0) $string = $temp;
        }
    	
        $lenString = strlen($string);
        
        /*
         * Considera '' y null como vacio (!isset($string) es para null)
         * y strlen(trim($string)) == 0) para ''
         * Considera 0 como un valor 
         */
        
        /*
         * Verifica y asigna en caso los valores seteados sean nulos
         */
        if ($null === true and $typeData != 'boolean' and (!isset($string) or $lenString == 0)) {
            $this->_string = null;
            $this->_length = null;
            $this->_top = null;
            return true;
        }
        
        /*
         * Se calcula el tama�o del string
         */
           
          // parche
          //if ($this->_top == null )
          //      $this->_top = $lenString;
	  if ($this->_top == null )
                $top = strlen($string);
          else $top = $this->_top;
          
         
          
		
	/*
         * Valida que el tipo de dato sea string y la longitud sea menor de lo asignado
         */	
        if ($lenString <= $top and $typeData == 'string' and (isset($string) and $lenString > 0)) {
            $this->_length = $lenString;
            if(Class_Config::exists('defaultCharsetString') && $this->_defaultCharsetString){
                if(Class_Config::get('defaultCharsetString') == 'UTF8'){
                    $this->_string = Class_App::utf8($string);
                    return true;
                }
                elseif(Class_Config::get('defaultCharsetString') == 'AUTF8'){
                    $this->_string = Class_App::aUtf8($string);
                    return true;
                }
            }
            $this->_string = $string;
            return true;
        }
        
        /*
         * Caso contrario setea las variables a null y retorna false
         */
        $this->_string = null;
        $this->_length = null;
        $this->_top = null;
        return false;
    }


    /**
     * Obtiene el valor del objeto String.
     * 
     * @return string
     */
    public function getValue()
    {
       return $this->_string;
    }

    /**
     * Obtiene la longitud de la cadena del objeto String.
     * 
     * @return integer
     */
    public function getLength()
    {
        return $this->_length;
    }

    /**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLVARCHAR"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL($this->nameTypeData());
    }

    /**
     * Obtiene la longitud m�xima de la cadena del objeto String.
     * 
     * @return integer
     */
    public function getLengthMax()
    {
        return $this->_top;
    }
}
