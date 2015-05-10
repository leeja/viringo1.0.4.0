<?PHP

	class Class_Db_Mysql_Language
	{
		
		public static function get( $key )
		{
			$message['Spanish']['1451']  = 'No se puede eliminar o actualizar un registro en uso';
			$message['English']['1451']  = 'Cannot delete or update a parent row';
			
                        $message['Spanish']['1452']  = 'No se puede agregar o actualizar registro que ha sido eliminado';
			$message['English']['1452']  = 'Cannot add or update a child row';
                        
                        $message['Spanish']['1048']  = 'Falto ingresar Dato que es Obligatorio';
			$message['English']['1048']  = 'Data cannot be null ';
                        
                        
			$language = Class_Config::get('language');
			
			if(!empty($key) or $message[$language][$key]) 
				return $message[$language][$key];
			Class_Error::messageError('Error in Class_Error_Language, key not found' );
		}
		
	}