<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Clase para Objetos tipo Int.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  21/03/2012
 * @access public
 */
class Class_Object_Int implements Class_Interface_Object
{

    private $_int = null;

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos TinyInt.
     */
    const MAX_TINYINT = '127';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos SmallInt.
     */
    const MAX_SMALLINT = '32767';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos MediumInt.
     */
    const MAX_MEDIUMINT = '8388607';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos Int.
     */
    const MAX_INT = '2147483647';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos BigInt.
     */
    const MAX_BIGINT = '9223372036854775807';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos TinyInt.
     */
    const MIN_TINYINT = '-128';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos SmallInt.
     */
    const MIN_SMALLINT = '-32768';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos MediumInt.
     */
    const MIN_MEDIUMINT = '-8388608';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos Int.
     */
    const MIN_INT = '-2147483648';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos BigInt.
     */
    const MIN_BIGINT = '-9223372036854775808';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos TinyInt sin signo.
     */
    const U_MAX_TINYINT = '255';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos SmallInt sin signo.
     */
    const U_MAX_SMALLINT = '65535';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos MediumInt sin signo.
     */
    const U_MAX_MEDIUMINT = '16777215';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos Int sin signo.
     */
    const U_MAX_INT = '4294967295';

    /**
     * Mï¿½ximo nï¿½mero permitido en el tipo de datos BigInt sin signo.
     */
    const U_MAX_BIGINT = '18446744073709551615';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos TinyInt sin signo.
     */
    const U_MIN_TINYINT = '0';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos SmallInt sin signo.
     */
    const U_MIN_SMALLINT = '0';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos MediumInt sin signo.
     */
    const U_MIN_MEDIUMINT = '0';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos Int sin signo.
     */
    const U_MIN_INT = '0';

    /**
     * Mï¿½nimo nï¿½mero permitido en el tipo de datos BigInt sin signo.
     */
    const U_MIN_BIGINT = '0';

    /**
     * Identificador del tipo de datos TinyInt.
     */
    const TINYINT = 'TINYINT';

    /**
     * Identificador del tipo de datos SmallInt.
     */
    const SMALLINT = 'SMALLINT';

    /**
     * Identificador del tipo de datos MediumInt.
     */
    const MEDIUMINT = 'MEDIUMINT';

    /**
     * Identificador del tipo de datos Int.
     */
    const VINT = 'INT';

    /**
     * Identificador del tipo de datos BigInt.
     */
    const BIGINT = 'BIGINT';

    /**
     * Identificador del tipo de datos TinyInt sin signo.
     */
    const U_TINYINT = 'U_TINYINT';

    /**
     * Identificador del tipo de datos SmallInt sin signo.
     */
    const U_SMALLINT = 'U_SMALLINT';

    /**
     * Identificador del tipo de datos MediumInt sin signo.
     */
    const U_MEDIUMINT = 'U_MEDIUMINT';

    /**
     * Identificador del tipo de datos Int sin signo.
     */
    const U_INT = 'U_INT';

    /**
     * Identificador del tipo de datos BigInt sin signo.
     */
    const U_BIGINT = 'U_BIGINT';

    private $_minValue;
    private $_maxValue;
    private $_typeData;
    private $_unsigned;

    /**
     * Obtiene el máximo valor del objeto Int.
     * 
     * @return integer
     */
    public function getMaxInt()
    {
        return $this->_maxValue;
    }

    /**
     * Obtiene el mínimo valor del objeto Int.
     * 
     * @return integer 
     */
    public function getMinInt()
    {
        return $this->_minValue;
    }
    
    /**
     * Obtiene el tipo de datos del objeto Int.
     * 
     * @return string
     */
    public function nameTypeData()
    {
        $output = ($this->_unsigned) ? "u" : "";
        return $output.$this->_typeData ;
    }


    /**
     * Método Constructor, Inicializa Variables.<br>
     * Asigna valores máximo y mínimo permitidos para el tipo de datos.
     * 
     * @param string $typeData solo TINYINT, SMALLINT, MEDIUMINT, VINT, BIGINT
     * @param bool $unsigned
     * @return void
     */
    public function __construct($typeData = self::VINT, $unsigned = false)
    {
        if($typeData == null) $typeData = self::VINT;
        if($unsigned == null) $unsigned = false;
        $this->_typeData = $typeData;
        $this->_unsigned = $unsigned;
        
        
        switch ($this->_typeData) {

            case self::TINYINT:

                $this->_maxValue = ($unsigned === false) ? self::MAX_TINYINT:
                self::U_MAX_TINYINT;
                $this->_minValue = ($unsigned === false) ? self::MIN_TINYINT:
                self::U_MIN_TINYINT;

                break;

            case self::SMALLINT:

                $this->_maxValue = ($unsigned === false) ? self::MAX_SMALLINT:
                self::U_MAX_SMALLINT;
                $this->_minValue = ($unsigned === false) ? self::MIN_SMALLINT:
                self::U_MIN_SMALLINT;

                break;

            case self::MEDIUMINT:

                $this->_maxValue = ($unsigned === false) ? self::MAX_MEDIUMINT:
                self::U_MAX_MEDIUMINT;
                $this->_minValue = ($unsigned === false) ? self::MIN_MEDIUMINT:
                self::U_MIN_MEDIUMINT;

                break;

            case self::VINT:

                $this->_maxValue = ($unsigned === false) ? self::MAX_INT:
                self::U_MAX_INT;
                $this->_minValue = ($unsigned === false) ? self::MIN_INT:
                self::U_MIN_INT;

                break;

            case self::BIGINT:

                $this->_maxValue = ($unsigned === false) ? self::MAX_BIGINT:
                self::U_MAX_BIGINT;
                $this->_minValue = ($unsigned === false) ? self::MIN_BIGINT:
                self::U_MIN_BIGINT;

                break;

        }

    }


    /**
     * Setea el valor del objeto Int.
     * 
     * @param integer $int
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($int, $null = false)
    {
       $typeData = gettype($int);
       
       if($typeData == 'string'){
            $temp = $int;
            $temp = trim($temp);
            if(strlen($temp) == 0) $int = $temp;
        }
        
        if($int === false){
            $this->_int = null;
            return false;
        }

        if(($null === true and (!isset($int) or strlen($int) == 0))){
                $this->_int = null;
                return true;	
        }
	 
        switch ($this->_typeData) {

            case self::TINYINT:
            case self::SMALLINT:
            case self::MEDIUMINT:

                if (($int !== true) && ((string )(int)$int) === ((string )$int)) {


                    $intClean = (int)$int;
                    if ($intClean <= (int)$this->_maxValue && $intClean >= (int)$this->_minValue) {
                        $this->_int = $intClean;
                        return true;
                    }

                }

                break;

            case self::VINT:

            	
            	 
                if (!$this->_unsigned) {
					
                    if (($int !== true) && ((string )(int)$int) === ((string )$int)) {

                        $intClean = (int)$int;
                        if ($intClean <= (int)$this->_maxValue && $intClean >= (int)$this->_minValue) {
                            $this->_int = $intClean;
                            return true;
                        }

                    }

                } else {
                	
                    if (($int !== true) && ((string )round((float)$int, 0)) === ((string )$int)) {

                        $intClean = round((float)$int, 0);
                        if ($intClean <= (float)$this->_maxValue && $intClean >= (float)$this->
                            _minValue) {
                            $this->_int = $intClean;
                            return true;
                        }

                    }
                }

                break;

            case self::BIGINT:

                //ini_set('precision','20');

                if (($int !== true) && ((string )round((float)$int, 0)) === ((string )$int)) {

                    $intClean = round((float)$int, 0);
                    if ($intClean <= (float)$this->_maxValue && $intClean >= (float)$this->
                        _minValue) {
                        $this->_int = (string )$intClean;
                        return true;
                    }

                }

                //ini_set('precision','14');
                break;

        }

        //settype($int, 'integer');
        //and ctype_digit($int)
        //and $int <= PHP_INT_MAX
        // or ($int === 0)
        //and  !empty($int)

        // if ((filter_var($int, FILTER_VALIDATE_INT) and $int !== true) or ($int === 0) or ($int === '0') ) {

        $this->_int = null;
        return false; 
    }


    /**
     * Obtiene el valor del objeto Int.
     * 
     * @return Int
     */
    public function getValue()
    {
        
        return $this->_int;
        
    }

    /**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLINT4"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_INT);
    }

    /**
     * Obtiene la longitud maxima del objeto.
     * 
     * @return null
     */
    public function getLengthMax()
    {
        return null; //PHP_INT_MAX;
    }
}
