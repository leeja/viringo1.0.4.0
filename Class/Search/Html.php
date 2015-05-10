<?PHP

	class Class_Search_Html extends Class_Search
	{
		
		public function __construct()
		{
		
		$valueSearch = Class_SendData::post('txtValueSearch');
		$this->return = $this->_daoSearch( $valueSearch );
		
			?>
<html>
	<link rel="stylesheet" type="text/css" href="<?PHP echo Class_Config::get('urlApp') ?>/Public/Styles/site.css" />
	<script src="<?PHP echo Class_Config::get('urlApp') ?>/Components/Library/Search/Search.js.php" type="text/javascript" language="javascript"></script>
	<head>
		<title>Buscador</title>
	</head>
	<body>
		<table  class='titleTable' align='center' border='0' cellspacing='2' cellpadding='2' >
			<tr>
				<th>Ficha</th>
				<th>Login</th>
				<th>Nombre</th>
				<th>Rol</th>
				<th>Dependencia</th>
			</tr>		
		
<?PHP

	$styleRow = "search1";
	$return = $this->return;

	if(isset($return) and is_array($return)){
		foreach($return as $key => $value){
			
			$name = $value[3]." ".$value[4]." ".$value[5];
			
			$styleRow = $styleRow == "search1" ? "search2" : "search1";
		?>
		
			<tr class='<?PHP echo $styleRow ?>' align='left'>
			<td><?PHP echo $value[1] ?></td><td><?PHP echo $value[2] ?></td>
			<td><?PHP echo $name ?></td>
			<td><?PHP echo $value[6] ?></td><td><?PHP echo $value[7] ?></td>
			<td>
			<a href='#' onclick = "assing(<?PHP echo $this->getReturnValue().",'".$value[0]."','".$name."'" ?>);" >
			<img src='<?PHP echo Class_Config::get('urlServerImages') ?>/Edit.png' border='0' /></a></td>
			</tr>
			
		<?PHP
		}
	}

?>
		<tr>
			<td align="right" colspan="8" class="endTable">Registros: <?PHP echo $key + 1 ?></td>
		</tr>
		</table>
		<?PHP
		$objPaginator = new Class_Pagination();
		echo $objPaginator->showLinkPaginator(1, 20);
		?>
	</body>
</html>
			<?
		}
			
	}
?>
