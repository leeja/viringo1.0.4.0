<?PHP

	class Class_Authentication_Language
	{
		
		public static function get( $key )
		{
			$message['Spanish']['userValid']  = 'Usuario Valido';
			$message['English']['userValid']  = 'User Valid';
			
			$message['Spanish']['serverNotFound']  = 'El Servidor se encuentra fuera de servicio';
			$message['English']['serverNotFound']  = 'Server not found';
			
			$message['Spanish']['userNotValid']  = 'Usuario No Valido';
			$message['English']['userNotValid']  = 'User Not Valid';
			
			$language = Class_Config::get('language');
			
			if(!empty($key) or $message[$language][$key]) 
				return $message[$language][$key];
			Class_Error::messageError('Error in Class_Authentication_Language, key not found');
		}
		
	}