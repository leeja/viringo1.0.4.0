<?PHP

	class Class_Report_Language
	{
		
		public static function get( $key )
		{
			$message['Spanish']['selectReport']  = 'Seleccione Reporte';
			$message['English']['selectReport']  = 'Select Report';
                        
                        $message['Spanish']['loadReport']  = 'Cargar Reporte';
			$message['English']['loadReport']  = 'Load Report';
                        
                        $message['Spanish']['isRequired']  = '(*) Campo Requerido';
			$message['English']['isRequired']  = '(*) Field Required';
                        
                        $message['Spanish']['notNameReport']  = 'Nombre de Reporte vacio';
			$message['English']['notNameReport']  = 'Name Report Not Found';
			
			$language = Class_Config::get('language');
			
			if(!empty($key) or $message[$language][$key]) 
				return $message[$language][$key];
			Class_Error::messageError('Error in Class_Report_Language, key not found');
		}
		
	}