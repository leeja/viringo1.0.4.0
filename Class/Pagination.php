<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para Paginar Listados.
 * Adaptada de un script bajado de internet y creado por Jorge Pinedo
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Pagination
{

    /**
     * Especifica el lenguaje en que se mostrara: spanish o english
     * 
     * @var string
     * @access public
     */
    public $lenguage;
    
    /**
     * Estilo css del paginador
     * 
     * @var string
     * @access public
     */
    public $style;
    
    /**
     * Número de paginas que mostrará el paginador
     * 
     * @var integer
     * @access public
     */
    public $numberLink;
    
    /**
     * Caracter que separa las paginas
     * 
     * @var string
     * @access public
     */
    public $separator;
    
    /**
     * Tipo de url que se utiliza, normal o MVC
     * 
     * @var string
     * @access public
     */
    public $method;
    
    /**
     * Para el metodo MVC, se tiene que especificar el url donde se encuentra el paginador
     * 
     * @var string
     * @access public
     */
    public $link;

    /**
     * Nombre de la Funcion Javascript que para Ajax
     * 
     * @var string
     * @access public
     */
    public $nameFunctionJavascript;

    /**
     * Nombre de la Div donde se cargará el Ajax
     * 
     * @var string
     * @access public
     */
    public $nameDivLoad;


    /**
     * Muestra el Paginador
     * 
     * @param integer $page
     * @param integer $pageTotal
     * @param bool $opcAjax
     * @return string
     */
    public function showLinkPaginator($page, $pageTotal, $opcAjax = false)
    {

        settype($page, 'int');
        settype($pageTotal, 'int');

        if (isset($this->separator))
            $_pagi_separador = $this->separator;
        else
            $_pagi_separador = ' ';

        if (isset($this->style))
            $_pagi_nav_estilo_mod = $this->style;
        else
            $_pagi_nav_estilo_mod = 'paginator';

        if (isset($this->numberLink))
            $_pagi_nav_num_enlaces = $this->numberLink;

        if (isset($this->method))
            $_pagi_method = $this->method;
        else
            $_pagi_method = null;

	if(!isset($this->nameFunctionJavascript))
	     $this->nameFunctionJavascript= 'paginator';

	if(!isset($this->nameDivLoad))
	     $this->nameDivLoad= 'homePage';

        
        if ($this->lenguage == 'spanish') {
            $_pagi_nav_anterior = 'Anterior';
            $_pagi_nav_siguiente = 'Siguiente';
	     $_pagi_nav_inicio = 'Inicio';
	     $_pagi_nav_fin = 'Fin';
        } else {
            $_pagi_nav_anterior = 'Back';
            $_pagi_nav_siguiente = 'Next';
	     $_pagi_nav_inicio = 'Begin';
	     $_pagi_nav_fin = 'End';

        }


        $_pagi_enlace = Class_Config::get('urlServer') . Class_SendData::server('PHP_SELF');
        /*
        if(isset($_SERVER['HTTP_REFERER']))
        $_pagi_enlace = $_SERVER['HTTP_REFERER'];
        else $_pagi_enlace = "";
        */

        if (!isset($_pagi_propagar)) {

            $temp_pagi_pg = Class_SendData::get('_pagi_pg');

            if (isset($temp_pagi_pg))
                Class_SendData::setGet('_pagi_pg', null);
            //unset($_GET['_pagi_pg']);
            $_pagi_propagar = Class_SendData::arrayKeys('get');

        } elseif (!is_array($_pagi_propagar)) {
            Class_Error::messageError('<b>Error Paginator : </b>La variable \$_pagi_propagar debe ser un array');
        }

        $_pagi_query_string = null;
        foreach ($_pagi_propagar as $var) {
            $temp = Class_SendData::request($var);
            if (isset($temp)) {
                $_pagi_query_string .= $var . '=' . $temp . '&';
            }
        }

        //$_pagi_enlace = NULL;
        $_pagi_enlace .= '?' . $_pagi_query_string;

        if (isset($this->link))
            $_pagi_enlace = $this->link;
        //echo $_pagi_enlace."<br />";

        $_pagi_navegacion_temporal = array();

        /*
        * $page = numero de pagina a mostrar
        */
        if ($page != 1) {

		 $_pagi_url = 1;
		
		if($opcAjax == true) 
		$_pagi_navegacion_temporal[] = '<a class=\''.$_pagi_nav_estilo_mod.'\' onclick='.$this->nameFunctionJavascript.'(\''.$_pagi_enlace.'/_pagi_pg/'.$_pagi_url.'/\',\''.$this->nameDivLoad.'\') href=\'#\'>'.$_pagi_nav_inicio.'</a>'; 
	     else{	
            if ($_pagi_method == 'MVC')
                $_pagi_navegacion_temporal[] = "<a class='nextBackPaginator'  href='" . $_pagi_enlace .
                    '/_pagi_pg/' . $_pagi_url . "/'>" . $_pagi_nav_inicio . "</a>&nbsp;&nbsp;";
            else
                $_pagi_navegacion_temporal[] = "<a class='nextBackPaginator'  href='" . $_pagi_enlace .
                    '_pagi_pg=' . $_pagi_url . "'>" . $_pagi_nav_inicio . "</a>&nbsp;&nbsp;";
		}
        


            $_pagi_url = $page - 1;
		
		if($opcAjax == true) 
		$_pagi_navegacion_temporal[] = '<a class=\''.$_pagi_nav_estilo_mod.'\' onclick='.$this->nameFunctionJavascript.'(\''.$_pagi_enlace.'/_pagi_pg/'.$_pagi_url.'/\',\''.$this->nameDivLoad.'\') href=\'#\'>'.$_pagi_nav_anterior.'</a>'; 
	     else{	
            if ($_pagi_method == 'MVC')
                $_pagi_navegacion_temporal[] = "<a class='nextBackPaginator'  href='" . $_pagi_enlace .
                    '/_pagi_pg/' . $_pagi_url . "/'>" . $_pagi_nav_anterior . "</a>&nbsp;&nbsp;";
            else
                $_pagi_navegacion_temporal[] = "<a class='nextBackPaginator'  href='" . $_pagi_enlace .
                    '_pagi_pg=' . $_pagi_url . "'>" . $_pagi_nav_anterior . "</a>&nbsp;&nbsp;";
		}
        }


        if (!isset($_pagi_nav_num_enlaces)) {
            $_pagi_nav_desde = 1;
            $_pagi_nav_hasta = $pageTotal;
        } else {
            $_pagi_nav_intervalo = ceil($_pagi_nav_num_enlaces / 2) - 1;
            $_pagi_nav_desde = $page - $_pagi_nav_intervalo;
            $_pagi_nav_hasta = $page + $_pagi_nav_intervalo;
            if ($_pagi_nav_desde < 1) {
                $_pagi_nav_hasta -= ($_pagi_nav_desde - 1);
                $_pagi_nav_desde = 1;
            }
            if ($_pagi_nav_hasta > $pageTotal) {
                $_pagi_nav_desde -= ($_pagi_nav_hasta - $pageTotal);
                $_pagi_nav_hasta = $pageTotal;
                if ($_pagi_nav_desde < 1) {
                    $_pagi_nav_desde = 1;
                }
            }
        }

        for ($_pagi_i = $_pagi_nav_desde; $_pagi_i <= $_pagi_nav_hasta; $_pagi_i++) {
            //echo $page.' '.$_pagi_i.' '.$_pagi_nav_hasta.' ';
            if ($_pagi_i == $page) {
                if (1 != $_pagi_nav_hasta)
                    $_pagi_navegacion_temporal[] = '<span class=\'' . $_pagi_nav_estilo_mod . '\'>' .
                        $_pagi_i . '</span>';
            } else {
		  if($opcAjax == true)    
		       $_pagi_navegacion_temporal[] = '<a class=\''.$_pagi_nav_estilo_mod.'\' onclick='.$this->nameFunctionJavascript.'(\''.$_pagi_enlace.'/_pagi_pg/'.$_pagi_i.'/\',\''.$this->nameDivLoad.'\') href=\'#\'>'.$_pagi_i.'</a>'; 
		  else{
                if ($_pagi_method == 'MVC')
                    $_pagi_navegacion_temporal[] = "<a class='" . $_pagi_nav_estilo_mod . "' href='" .
                        $_pagi_enlace . "/_pagi_pg/" . $_pagi_i . "/'>" . $_pagi_i . "</a>";
                else
                    $_pagi_navegacion_temporal[] = "<a class='" . $_pagi_nav_estilo_mod . "' href='" .
                        $_pagi_enlace . "_pagi_pg=" . $_pagi_i . "'>" . $_pagi_i . "</a>";
			}
            }
        }

        if ($page < $pageTotal) {
            $_pagi_url = $page + 1;

	  if($opcAjax == true) 
		$_pagi_navegacion_temporal[] = '<a class=\''.$_pagi_nav_estilo_mod.'\' onclick='.$this->nameFunctionJavascript.'(\''.$_pagi_enlace.'/_pagi_pg/'.$_pagi_url.'/\',\''.$this->nameDivLoad.'\') href=\'#\'>'.$_pagi_nav_siguiente.'</a>'; 
	     else{	
            if ($_pagi_method == 'MVC')
                $_pagi_navegacion_temporal[] = "&nbsp;&nbsp;<a class='nextBackPaginator' href='" .
                    $_pagi_enlace . "/_pagi_pg/" . $_pagi_url . "/'>" . $_pagi_nav_siguiente . "</a>";
            else
                $_pagi_navegacion_temporal[] = "&nbsp;&nbsp;<a class='nextBackPaginator' href='" .
                    $_pagi_enlace . "_pagi_pg=" . $_pagi_url . "'>" . $_pagi_nav_siguiente . "</a>";
	   }

	$_pagi_url = $pageTotal;

	  if($opcAjax == true) 
		$_pagi_navegacion_temporal[] = '<a class=\''.$_pagi_nav_estilo_mod.'\' onclick='.$this->nameFunctionJavascript.'(\''.$_pagi_enlace.'/_pagi_pg/'.$_pagi_url.'/\',\''.$this->nameDivLoad.'\') href=\'#\'>'.$_pagi_nav_fin.'</a>'; 
	     else{	
            if ($_pagi_method == 'MVC')
                $_pagi_navegacion_temporal[] = "&nbsp;&nbsp;<a class='nextBackPaginator' href='" .
                    $_pagi_enlace . "/_pagi_pg/" . $_pagi_url . "/'>" . $_pagi_nav_fin . "</a>";
            else
                $_pagi_navegacion_temporal[] = "&nbsp;&nbsp;<a class='nextBackPaginator' href='" .
                    $_pagi_enlace . "_pagi_pg=" . $_pagi_url . "'>" . $_pagi_nav_fin . "</a>";
	   }



        }
        $_pagi_navegacion = implode($_pagi_separador, $_pagi_navegacion_temporal);

        return $_pagi_navegacion;
    }

}
