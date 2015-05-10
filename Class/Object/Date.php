<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Clase para Objetos tipo fecha.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  08/04/2012
 * @access public
 */
class Class_Object_Date implements Class_Interface_Object
{
    private $_month = null;
    private $_day = null;
    private $_year = null;
    private $_date = null;
    private $_format = null;

    /**
     * Retorna el nombre del tipo de datos.
     * 
     * @return string "Date"
     */
    public function nameTypeData()
    {
        return Class_Object::DATA_DATE;
    }


    /**
     * Método Constructor, Inicializa Variables.
     * 
     * @param string $format por defecto 'yyyy-mm-dd'
     * @return void
     */
    public function __construct($format = 'yyyy-mm-dd')
    {
	if($format == null) $format = 'yyyy-mm-dd';

	$temp = str_replace(array('m', 'd', 'y', '-'), '', $this->_format);
	if(strlen($temp) != 0) 
    	  $format = 'yyyy-mm-dd';
		

	if($format == null or empty($format))
		 $format = 'yyyy-mm-dd';

        if (strlen($format) === 10)
            $this->_format = $format;

    }

    /**
     * Setea el valor del objeto Date.
     * 
     * @param string $date 
     * @param bool $null true = acepta valores nulos
     * @return bool
     */
    public function setValue($date,  $null = false)
    {

        if ($null == true and !isset($date)) {

            $this->_day = null;
            $this->_month = null;
            $this->_year = null;
            $this->_date = null;

            return true;
        }
	
	$temp = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'), '', $date);

        if (strlen($date) == 10 and !empty($date) and strlen($temp) == 0) {
		
            $separatorOnly = str_replace(array('m', 'd', 'y'), '', $this->_format);

            $separator = $separatorOnly[0]; // separator is first character

            if ($separator && strlen($separatorOnly) == 2) {
		


                $arrayDate = explode($separator, $date);

                $positionYear = strpos($this->_format, 'yyyy');
                $positionMonth = strpos($this->_format, 'mm');
                $positionDay = strpos($this->_format, 'dd');
		
                if ($positionYear === 0) {
                    $year = $arrayDate[0];
                    if ($positionMonth === 5) {
                        $month = $arrayDate[1];
                        $day = $arrayDate[2];
                    }
                    else{
                        $month = $arrayDate[2];
                        $day = $arrayDate[1];
                    }

                } elseif ($positionMonth === 0) {
                    $month = $arrayDate[0];
                    if ($positionYear === 3) {
                        $year = $arrayDate[1];
                        $day = $arrayDate[2];
                    }
                    else{
                    	$year = $arrayDate[2];
                        $day = $arrayDate[1];
                    }
 
                } elseif ($positionDay === 0) {
                    $day = $arrayDate[0];
                    if ($positionMonth === 3) {
                        $month = $arrayDate[1];
                        $year = $arrayDate[2];
                    }
                    else{
                    	$month = $arrayDate[2];
                        $year = $arrayDate[1];
                    }

                }
			
                if (@checkdate($month, $day, $year)) {

                    $this->_day = $day;
                    $this->_month = $month;
                    $this->_year = $year;
                    $this->_date = $date;

                    return true;
                }

            }
        }
        $this->_day = null;
        $this->_month = null;
        $this->_year = null;
        $this->_date = null;
        return false;

    }

    /**
     * Obtiene el valor del objeto Date.
     * 
     * @return string
     */
    public function getValue()
    {
            return $this->_date;
    }


    /**
     * Obtiene el valor del objeto Date en formato SQL, YYYY-MM-DD.
     * 
     * @return string
     */
    public function getValueSql()
    {
        if (isset($this->_day) and isset($this->_month) and isset($this->_year))
            return $this->_year . "-" . $this->_month . "-" . $this->_day;
        return null;
    }

    /**
     * Obtiene el formato Fecha del Objeto Date.
     *
     * @return string
     */
    public function getFormat()
    {
        if (isset($this->_format))
            return $this->_format;
        return null;
    }

    /**
     * Obtiene el día del Objeto Date.
     * 
     * @return string
     */
    public function getDay()
    {
            return $this->_day;
    }

    /**
     * Obtiene el mes del Objeto Date.
     * 
     * @return string
     */
    public function getMonth()
    {
            return $this->_month;
    }

    /**
     * Obtiene el año del Objeto Date.
     * 
     * @return string
     */
    public function getYear()
    {
            return $this->_year;
    }

    /**
     * Obtiene el tipo de dato SQL.
     * 
     * @return integer "SQLVARCHAR"
     */
    public function getTypeDataSQL()
    {
        return Class_Object::getTypeDataSQL(Class_Object::DATA_DATE);
    }

    /**
     * Obtiene la longitud maxima del objeto
     * 
     * @return null
     */
    public function getLengthMax()
    {
        return null;
    }
}
