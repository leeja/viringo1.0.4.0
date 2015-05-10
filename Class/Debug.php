<?php
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para depurar c�digo.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Debug {
   
    /**
     * Mata el c�digo y para la ejecuci�n. 
     * @param string $variable (cadena o variable a evaluar)
     * @param string $file (Nombre del archivo donde se ejecuta la funci�n)
     * @param string $line (Linea de c�digo donde se ejecuta la funci�n)
     * @static
     */
    public static function breakRun($variable, $file = '', $line = '')
    {
       var_dump($variable);
       $message = '- Debug break Run ';
       if(! empty($file) ) $message .= 'In file '.$file.' ';
       if(! empty($line) ) $message .= 'In line '.$line;
        die($message);
        exit(0);
    }
    
    /**
     * Muestra un punto que indica que el c�digo pas� por ahi. 
     * @param string $variable (cadena o variable a evaluar)
     * @param string $file (Nombre del archivo donde se ejecuta la funci�n)
     * @param string $line (Linea de c�digo donde se ejecuta la funci�n)
     * @static
     */
    public static function pointRun($variable, $file = '', $line = '')
    {
        var_dump($variable);
        $message = '- Debug break Run ';
        if(! empty($file) ) $message .= 'In file '.$file.' ';
        if(! empty($line) ) $message .= 'In line '.$line;
        echo($message.'<br />');
    }
    
    
    
}
