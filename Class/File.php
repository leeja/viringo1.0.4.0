<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones de Archivos.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_File
{

    /**
     * @var object
     * @access private
     */
    private $_resourceFile;

    /**
     * Metodo destructor, cierra el archivo
     * 
     * @return void
     */
    public function __destruct()
    {
        if ($this->_resourceFile)
            fclose($this->_resourceFile);
    }

    /**
     * Abrir un archivo
     * 
     * @param string $nameFile Nombre del archivo
     * @param string $mode 'r' = Lectura o 'a' = Escritura
     * @param integer $include_path opcional propiedad de fopen
     * @return void
     */
    public function openFile($nameFile, $mode, $include_path = 0)
    {

            if ((file_exists($nameFile) and $mode == 'r') or $mode == 'a') {
                $this->_resourceFile = fopen($nameFile, $mode, $include_path);
                if (!$this->_resourceFile)
                	Class_Error::messageError( 'File does not exist or Unable to open file ' );
            } else {
                Class_Error::messageError( 'File does not exist or Unable to open file ' . $nameFile);
            }
  
    }
    
    /**
     * Escribir en el archivo $nameFile que es abierto por la funcion $this->openFile
     *
     * @param string $string mensaje a guardar
     * @return integer|null retorna el número de líneas que escribió o un mensaje de error si no pudo escribir
     */
    public function writeFile($string)
    {
        try {

            if ($this->_resourceFile) {
                $numLineWrite = fwrite($this->_resourceFile, $string);
                if (!$numLineWrite)
                	Class_Error::messageError('File does not exist or Unable to open file ');
                else
                    return $numLineWrite;
            } else {
                   Class_Error::messageError('File does not exist or Unable to open file ' . $this->_resourceFile);
            }

        }
        catch (exception $e) {
            Class_Error::messageError($e->getMessage());
        }
    }
    
}