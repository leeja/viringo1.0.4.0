<?PHP

	class Class_Db_Mssql_Language
	{
		
		public static function get( $key )
		{
			$message['Spanish']['1451']  = 'No se puede eliminar o actualizar un registro en uso';
			$message['English']['1451']  = 'Cannot delete or update a parent row';
			   
			$language = Class_Config::get('language');
			
			if(!empty($key) or $message[$language][$key]) 
				return $message[$language][$key];
			Class_Error::messageError('Error in Class_Error_Language, key not found' );
		}
		
	}