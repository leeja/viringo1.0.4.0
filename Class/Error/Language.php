<?PHP

	class Class_Error_Language
	{
		
		public static function get( $key )
		{
			$message['Spanish']['error']  = 'Error en la Aplicación contactese con el Administrador';
			$message['English']['error']  = 'Application Error contact the System Administrator';
			
			$language = Class_Config::get('language');
			
			if(!empty($key) or $message[$language][$key]) 
				return $message[$language][$key];
			Class_Error::messageError('Error in Class_Error_Language, key not found' );
		}
		
	}