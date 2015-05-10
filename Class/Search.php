<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Clase para cargar el buscador de Staff en los aplicativos.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  12/03/2012
 * @access public
 */
class Class_Search
{
    
    private $_nameTable;
    private $_pkReturn;
    private $_valueReturn;
    private $_valueSearch;
    private $_objMaster;
    private $_numberPageShow;
    private $_language;
    private $_message;
    private $_typeSearch;
    private $_rdoChecked;
    private $_pkDependency;
    private $_return;
    private $_orderBy;
    private $_typeOrder;

    /**
     * Método Constructor, inicializa las variables<br>
     * 
     * @return void
     */
    public function __construct()
    {
        
        $this->_language = "spanish";

		$this->_orderBy = Class_SendData::get('orderBy');
		if(empty($this->_orderBy)) $this->_orderBy = 'name';
		
		if(Class_SendData::get('typeOrder') == 'asc') 	
			$this->_typeOrder = 'desc';
		else 
			$this->_typeOrder = 'asc';

        $this->_typeSearch = Class_SendData::get('rdoSearch');
        if (empty($this->_typeSearch))
            $this->_typeSearch = 'allField';
        $this->_rdoChecked[$this->_typeSearch] = 'checked';


        $this->_objMaster = new Class_Master();

        $this->_nameTable = Class_SendData::get('option');
        if ($this->_nameTable != 'staff' or $this->_nameTable == 'dependency')
            $this->_nameTable = 'staff';

        $this->_pkReturn = Class_SendData::get('nameControlToReturnPk');
        $this->_valueReturn = Class_SendData::get('nameControlToReturnValue');

        $this->_numberPageShow = Class_SendData::get('_pagi_pg');
        $this->_numberPageShow = empty($this->_numberPageShow) ? 1 : $this->
            _numberPageShow;

        $this->_valueSearch = trim(Class_SendData::get('txtValueSearch'));
        $this->_pkDependency = (Class_SendData::get('cmbDependency') == 0) ? 1 : Class_SendData::get('cmbDependency')  ;
        
        
        $this->_return = $this->_daoSearch();

        $this->_setMessage();


    }

    /**
     * Seteo los mensajes.
     *
     * @return void
     */
    private function _setMessage()
    {

        $this->_message['spanish']['titleSearch'] = 'Buscador';
        $this->_message['english']['titleSearch'] = 'Search';

        $this->_message['spanish']['search'] = 'Buscar';
        $this->_message['english']['search'] = 'Search';

        $this->_message['spanish']['searchUser'] = 'Buscar Usuario';
        $this->_message['english']['searchUser'] = 'Search User';

        $this->_message['spanish']['allField'] = 'Todos los Campos';
        $this->_message['english']['allField'] = 'All Fields';

        $this->_message['spanish']['tab'] = 'Ficha';
        $this->_message['english']['tab'] = 'Tab';

        $this->_message['spanish']['login'] = 'Login';
        $this->_message['english']['login'] = 'Login';

        $this->_message['spanish']['name'] = 'Apellidos y Nombres';
        $this->_message['english']['name'] = 'Names';

        $this->_message['spanish']['surname'] = 'Apellidos';
        $this->_message['english']['surname'] = 'surnames';

        $this->_message['spanish']['rol'] = 'Rol';
        $this->_message['english']['rol'] = 'Rol';

        $this->_message['spanish']['dependency'] = 'Dependencia';
        $this->_message['english']['dependency'] = 'Dependency';

        $this->_message['spanish']['close'] = 'Cerrar';
        $this->_message['english']['close'] = 'Close';
        
        $this->_message['spanish']['allDependency'] = 'Todas Dependencia...';
        $this->_message['english']['allDependency'] = 'All Dependency...';

		$this->_message['spanish']['registers'] = 'Registros';
        $this->_message['english']['registers'] = 'Registers';
        
        $this->_message['spanish']['notResult'] = 'No hay resultados';
        $this->_message['english']['notResult'] = 'Not Results';

    }

    /**
     * Setea el idioma a mostrar
     * 
     * @param string $language
     * @return void
     */
    public function setLanguage($language)
    {
        if (isset($language))
            $this->_language = $language;
    }

    protected function _daoSearch()
    {

        return $this->_objMaster->getUsersByTabLoginNameDependency($this->_valueSearch, $this->
            _numberPageShow, $this->_pkDependency, $this->_orderBy, $this->_typeOrder);

    }
    
    protected function _getDependency()
    {
    	return $this->_objMaster->getAllDependencyForCombo( Class_Master::TYPE_DEPENDENCY_LIGTH );
    }

    protected function _getPkReturn()
    {
        return $this->_pkReturn;
    }

    protected function _getValueReturn()
    {
        return $this->_valueReturn;
    }

    /**
     * Construye el html para mostrar el buscador de usuarios.
     * 
     * @return void
     */
    public function showSearch()
    {

        $sizewidth = 470;
        $numberPageThisSql = ceil($this->_objMaster->getNumberPageUsersByTabLoginNameDependency($this->
            _valueSearch, $this->_pkDependency));
        $arrayDependency = $this->_getDependency();
		
        $objPaginator = new Class_Pagination();
        $objPaginator->lenguage = 'spanish';
		$objPaginator->numberLink = 20;

?><html>
	<link rel="stylesheet" type="text/css" href="<?PHP echo Class_Config::get('urlApp') ?>/Public/Styles/site.css" />
	<script src="<?PHP echo Class_Config::get('urlApp') ?>/Components/Library/Search/Search.js.php" type="text/javascript" language="javascript"></script>
	<head>
		<title><?PHP echo $this->_message[$this->_language]['titleSearch']; ?></title>
		
	<style>
	
		/*Filas Impares del buscador*/
		.cmbDependency {
			font:Verdana, Arial, Helvetica, sans-serif;
			font-size: 10px;
		}
		/*Filas Impares del buscador*/
		.searchPar {
		    background-color:#FFFFFF;
			font: Verdana, Arial, Helvetica, sans-serif;
			font-size: 10px;
		}
		/*Filas Pares del buscador*/
		.searchImpar {
		    background-color:#F4F4F4;
			font: Verdana, Arial, Helvetica, sans-serif;
			font-size: 10px;
		}
	</style>
	</head>
	<body onLoad="document.post.txtValueSearch.select();document.post.txtValueSearch.focus();">
		<form action="<?PHP echo Class_Config::get('urlApp') ?>/Components/Library/Search/Index.php" method="get" name="post" >
	 	<table  width="<?PHP echo $sizewidth ?>" align="center" >
	 	<tr>
		  	<td>
		
		<div id="divSearchFilter">
			<fieldset>
				<legend class="text"><?PHP echo $this->_message[$this->_language]['searchUser']; ?></legend>	
					<table border="0">
						<tr>
							<td colspan="2">
								<select class="cmbDependency" name="cmbDependency">
									<option value="0"><?PHP echo $this->_message[$this->_language]['allDependency']; ?></option>
									<?PHP
										while($dataDependency = next($arrayDependency))
										{
										if($this->_pkDependency == $dataDependency[0])
										{
										?><option value="<?PHP echo $dataDependency[0] ?>" selected ><?PHP echo $dataDependency[1] ?></option>
										<?PHP	
										}
										else{
										?><option value="<?PHP echo $dataDependency[0] ?>" ><?PHP echo $dataDependency[1] ?></option><?PHP
											}
										}
									?>
								</select>
							
							</td>
							</tr>
							<tr>
							<td width="10">
								<input type="text" name="txtValueSearch" id="txtValueSearch" size="30" class="textBoxForm" value="<?PHP echo $this->_valueSearch; ?>" />
							</td>
							<td > 
						<input type="submit" name="btnSearch" id="btnSearch" class="buttonForm" value="<?PHP echo $this->_message[$this->_language]['search']; ?>" />
							</td>
						</tr>
					</table>
			</fieldset>					
		</div>
		<div id="divPaginator" align="center">
		<?PHP echo $objPaginator->showLinkPaginator($this->_numberPageShow, $numberPageThisSql); ?>
		</div>
			</td>
		  </tr>	
		</table>
	  <?PHP
	  
	  if(!empty($this->_return))
	  {
	  ?>	
	  <table width="<?PHP echo $sizewidth ?>" align="center" border="0" >
	  	<tr>
	  		<td valign="top" >
	  		<table  class='titleTable' align='center' border='0' cellspacing='2' cellpadding='2' width="<?PHP echo
$sizewidth ?>">
			<tr>
				<th><a href="<?PHP echo Class_Config::get('urlApp') ?>/Components/Library/Search/Index.php?txtValueSearch=<?PHP echo $this->_valueSearch?>&cmbDependency=<?PHP echo $this->_pkDependency?>&orderBy=tag&typeOrder=<?PHP echo $this->_typeOrder?>&_pagi_pg=<?PHP echo $this->_numberPageShow?>&nameControlToReturnPk=<?PHP echo $this->
_getPkReturn()?>&nameControlToReturnValue=<?PHP echo $this->
_getValueReturn()?>"><?PHP echo $this->_message[$this->_language]['tab']; ?></a></th>
				<th><a href="<?PHP echo Class_Config::get('urlApp') ?>/Components/Library/Search/Index.php?txtValueSearch=<?PHP echo $this->_valueSearch?>&cmbDependency=<?PHP echo $this->_pkDependency?>&orderBy=login&typeOrder=<?PHP echo $this->_typeOrder?>&_pagi_pg=<?PHP echo $this->_numberPageShow?>&nameControlToReturnPk=<?PHP echo $this->
_getPkReturn()?>&nameControlToReturnValue=<?PHP echo $this->
_getValueReturn()?>"><?PHP echo $this->_message[$this->_language]['login']; ?></a></th>
				<th><a href="<?PHP echo Class_Config::get('urlApp') ?>/Components/Library/Search/Index.php?txtValueSearch=<?PHP echo $this->_valueSearch?>&cmbDependency=<?PHP echo $this->_pkDependency?>&orderBy=name&typeOrder=<?PHP echo $this->_typeOrder?>&_pagi_pg=<?PHP echo $this->_numberPageShow?>&nameControlToReturnPk=<?PHP echo $this->
_getPkReturn()?>&nameControlToReturnValue=<?PHP echo $this->
_getValueReturn()?>"><?PHP echo $this->_message[$this->_language]['name']; ?></a></th>
			<th>
				<?PHP echo $this->_message[$this->_language]['dependency']; ?>
			</th>
			</tr>		
<?PHP
	    $styleRow = "searchPar";
        $return = $this->_return;

        if (isset($return) and is_array($return)) {
            foreach ($return as $key => $value) {

                $name = $value[3] . " " . $value[4] . " " . $value[5];

                $styleRow = $styleRow == "searchPar" ? "searchImpar" : "searchPar";
?>
			<tr class='<?PHP echo $styleRow ?>' align='left' title="<?PHP echo $this->_message[$this->_language]['rol']; ?>: <?PHP echo $value[6] ?>  
<?PHP echo $this->_message[$this->_language]['dependency']; ?>:<?PHP echo $value[7] ?>"
>
			<td><?PHP echo $value[1] ?></td><td><?PHP echo $value[2] ?></td>
			<td><?PHP echo $name ?></td><td><?PHP echo  $value[8] ?></td>
			<td>
			<a href='#' onclick = "assing(<?PHP echo "'" . $this->_getPkReturn() . "','" .
$this->_getValueReturn() . "','" . $value[0] . "','" . $name . "'" ?>);" >
			<img src='<?PHP echo Class_Config::get('urlServerImages') ?>/Edit.png' border='0' /></a></td>
			</tr>
		<?PHP
            }
        }
?><tr>
				<td align="right" colspan="8" class="endTable"><?PHP echo $this->_message[$this->
_language]['registers']; ?>: <?PHP 
				if(isset($key))	echo $key + 1; ?></td>
			</tr>
			</table>
	  		</td>
  		</tr>
	  </table>
	  <?PHP
	  }
	  else{
	  	?>
	  	<br />
	  	<div align="center" class="textAlert"><?PHP echo $this->_message[$this->_language]['notResult'];?></div>
	  	<?PHP
	  }
	  
	  ?>
	  <input type="hidden" name="nameControlToReturnPk" value="<?PHP echo $this->
_getPkReturn() ?>" />
	  <input type="hidden" name="nameControlToReturnValue" value="<?PHP echo $this->
_getValueReturn() ?>" />
	  </form>
	  <center><a href="#" onClick="window.close();"><?PHP echo $this->_message[$this->
_language]['close']; ?></a></center>
</body>
</html>
<?PHP
    }
}
?>