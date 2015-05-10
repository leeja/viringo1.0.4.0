<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */
      Class_Security::sessionStart();
      
/**
 * @see class Java.inc
 */    
 include_once("JavaBridge/Java.inc");
                              
/**
 * Funciones para correr Reportes.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2011 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Report
{
	
	private $_nameReport;
	private $_format;
	private $_path;
	private $_url;
	private $_name;
        private $_nameFileReport;
	private $_arrayValues;
	private $_pathImage;
        private $_urlImage;

        private $_sh;
        private $_task;
        private $_nameParametersReport;
        private $_typeParametersReport;
        private $_controlTypePatametersReport;
        private $_promptTextPatametersReport;
        private $_helpTextPatametersReport;
        private $_defaultValueParametersReport;
        private $_hiddenParametersReport;
        private $_isRequiredParametersReport;
        private $_selectionListLabel;
        //private $_formatParametersReport;
        private $_requiredParametersReport;    
        private $_titleReport;
        private $_selectionListValue;
        
        /**
         * Setea la Ruta, el nombre del reporte y formato y carga las variables de entrada del reporte
         * 
         * @param string $nameReport Nombre del Reportes
         * @param string $format Formato de Salida del Reporte
         * @param string $path Ubicacion de los reportes *.rptdesign
         */
	public function __construct( $nameReport, $format = 'pdf', $path = 'Components/Reports/' )
	{
                 
                $this->setPath($path,false);
		$this->setNameReport($nameReport,false);
		$this->setFormat($format,false);
                $this->_load();
	}
        
        
        private function _load()
        {
            //define ("JAVA_HOSTS", "localhost:8080");
            //define ("JAVA_SERVLET", "/JavaBridge/JavaBridge.phpjavabridge");
            
            $ctx = java_context()->getServletContext();
            $birtReportEngine =        java("org.eclipse.birt.php.birtengine.BirtEngine")->getBirtEngine($ctx);
            java_context()->onShutdown(java("org.eclipse.birt.php.birtengine.BirtEngine")->getShutdownHook());
		
            $engine = $birtReportEngine->openReportDesign($this->_nameReport);
            $this->_task = $birtReportEngine->createRunAndRenderTask($engine);
            $this->_sh = $engine->getDesignHandle()->getParameters();
            
            //$title = $engine->getReportName();
            
            
            $this->_titleReport = java_values($engine->getProperty('title'));
            
            if(empty($this->_titleReport)) $this->_titleReport = $this->_nameFileReport;
            
             
            error_reporting(E_ALL & ~E_NOTICE);
		
            $numberParametersReport = (int)java_values($this->_sh->getCount());
             
                $i = 0;
                
		while ($i < $numberParametersReport) {
                    
                     $parmhandle = $this->_sh->get($i);
                     
                     $parmname = $parmhandle->getName();
                     $this->_nameParametersReport[$i] = java_values($parmname);
                     
                     $dt = $parmhandle->getDataType();
                     $this->_typeParametersReport[$i] = java_values($dt);
                    
                     $controlType = $parmhandle->getControlType();
                     $this->_controlTypePatametersReport[$i] = java_values($controlType);
                     
                     $promptText = $parmhandle->getPromptText();
                     $this->_promptTextPatametersReport[$i] = java_values($promptText);
                     if(empty($this->_promptTextPatametersReport[$i])) 
                             $this->_promptTextPatametersReport[$i] = $this->_nameParametersReport[$i];
                     
                     $helpText = $parmhandle->getHelpText();
                     $this->_helpTextPatametersReport[$i] = java_values($helpText);
                     
                     $isRequired = $parmhandle->isRequired();
                     $this->_isRequiredParametersReport[$i] = java_values($isRequired);
                     
                     $hidden = $parmhandle->isHidden();
                     $this->_hiddenParametersReport[$i] = java_values($hidden);
                     
                     $required = $parmhandle->isRequired();
                     $this->_requiredParametersReport[$i] = java_values($required);
                     
                     //$formatParametersReport = $parmhandle->getDisplayFormat();
                     //$this->_formatParametersReport[$i] =  java_values($formatParametersReport);
                     
                     $defaultValue = $parmhandle->getDefaultValue();
                     $this->_defaultValueParametersReport[$i] = java_values($defaultValue);
                     
                     
                     $selectionList = $parmhandle->getProperty('selectionList');
                     
                     $selectionList = java_values($selectionList);
                     if(isset($selectionList))
                     {
                         $numberSelectionList = count($selectionList);
                         for($j = 0;$j < $numberSelectionList; $j++){
                             $this->_selectionListValue[$i][$j] = java_values($selectionList[$j]->getValue());
                             $this->_selectionListLabel[$i][$j] = java_values($selectionList[$j]->getLabel());
                         }
                    }
                    else{
                         $this->_selectionListValue[$i] = null;
                         $this->_selectionListLabel[$i] = null;
                    }
                    $i++;
   		}
               error_reporting(E_ALL);
        }
        
        /**
         * Retorna los parametros usados en el reporte en forma de arreglo("nombre de parametro" => "value")
         * 
         * @return array 
         */
        public function getParameters()
        {
         $tempArray = null;   
         $i = 0;
         $count = count($this->_nameParametersReport);
         while($i<$count){
             $tempArray[$i] = array('nameParametersReport' => $this->_nameParametersReport[$i]
                                    ,'typeParametersReport' => $this->_typeParametersReport[$i]
                                    ,'controlTypePatametersReport' => $this->_controlTypePatametersReport[$i]
                                    ,'promptTextPatametersReport' => $this->_promptTextPatametersReport[$i]
                                    ,'helpTextPatametersReport' => $this->_helpTextPatametersReport[$i]
                                    ,'isRequiredParametersReport' => $this->_isRequiredParametersReport[$i]
                                    ,'isHiddenParametersReport' => $this->_hiddenParametersReport[$i]
                                    ,'defaultValueParametersReport' => $this->_defaultValueParametersReport[$i]
                                    ,'selectionListValue' => $this->_selectionListValue[$i]
                                    ,'selectionListLabel' => $this->_selectionListLabel[$i]
                                    ,'requiredParametersReport' => $this->_requiredParametersReport[$i]
                                    //,'formatParametersReport' => $this->_formatParametersReport[$i]
                                    
                                    );
             $i++;
         }
          return $tempArray;
        }
        
        /**
         * retorna los datos de cabecera del reporte (title, nameFile)
         * 
         * @return array 
         */
        public function getDataHeadReport()
        {
            $tempArray = array('titleReport' => $this->_titleReport,
                                'nameFileReport' => $this->_nameFileReport);
            return $tempArray;
        }
         
           
        /**
         *  Setea la Ubicacion de los Reportes
         *
         * @param string $path  Ubicacion de los reportes *.rptdesign
         */
	public function setPath( $path , $reload = true)
	{
		$this->_path = Class_Config::get('pathServer').$path;
		$this->_url = Class_Config::get('urlApp').'/'.$path;
                $this->_urlImage = Class_Config::get('urlApp').'/'. $path.'/Images';
		$this->_pathImage = Class_Config::get('pathServer').$path.'/Images';
                
                if($reload)  $this->_load();
	}

        /**
         * Setea el Nombre del Reporte
         *
         * @param string $name Nombre del Reporte
         * @return boolean
         */
	public function setNameReport( $name,  $reload = true )
	{
		$this->_nameFileReport = $name;
                
                $temp = explode('/', $this->_nameFileReport);
                $temp1 = $temp[count($temp)-1];
                $this->_nameFileReport = $temp1;
                        
		$name =  $this->_path . $name . '.rptdesign';
	
		if(!file_exists($name)){
			$msgError = 'Not found the file '.$name.'.rptdesign';
			Class_Error::messageError($msgError);
		}
		else{
			$this->_nameReport = $name;
			$this->_name = NAME_SITE."_".$this->_nameFileReport."_".Class_App::getDateTimeNow('America/Lima','dmYHis');
			
		}

                if($reload)  $this->_load();
                return true;
	}

        /**
         * Setea el Formato de salida del Reporte
         *
         * @param string $format Formato de salida del Reporte
         * @return boolean
         */
	public function setFormat( $format,  $reload = true)
	{
		if($format == 'pdf' or $format == 'doc' or $format == 'xls' or $format == 'html'){
			$this->_format = $format;
			
		}
		elseif(!isset($format) or empty($format) ){
			$this->_format = 'pdf';
		}
		else{
			$msgError = 'Not found the format '.$format;
			Class_Error::messageError($msgError);
		} 
                if($reload)  $this->_load();
		return true;	
	}

        /**
         *  Setea los parametros de entrada del Reporte
         *
         * @param array $arrayValues
         */
	public function setParameters( $arrayValues, $objects = false )
	{
		
                if(isset($arrayValues) and is_array($arrayValues))
                {
                    foreach ($arrayValues as $key => $value){
                            if( $objects === false)
                              $this->_arrayValues[$key] = $arrayValues[$key];                      
                            else
                              $this->_arrayValues[$key] = $value->getValue();
                       }
     
                }
		else Class_Error::messageError('Not found the parameters ');
	}

        /**
         * Ejecuta y visualiza los Reportes
         *
         */
	public function run()
	{
	
           $i = 0;
           $count = count($this->_nameParametersReport);
           while($i < $count){
             
                     if(isset($this->_arrayValues[$this->_nameParametersReport[$i]]))
                        $passedinvalue = $this->_arrayValues[$this->_nameParametersReport[$i]];
                     else $passedinvalue = null;
                                       
                     if (isset($passedinvalue)) {
                        
                        switch($this->_typeParametersReport[$i]){
                             
                             case 'integer':
                                
                                 $parameter = new Java("java.lang.Integer", $passedinvalue);
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break;
                             
                             case 'string':
                                 $parameter = new Java("java.lang.String", Class_App::Utf8($passedinvalue));
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break;
                             
                             case 'date':
                                 $number = strtotime($passedinvalue)."000";
                                 $parameter = new Java("java.sql.Date", $number);
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break;
                             
                             case 'float':
                                 //Class_Debug::pointRun($passedinvalue, __FILE__, __LINE__);
                                 $parameter = new java("java.lang.Float", $passedinvalue);
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break;
                             
                             case 'decimal':
                                 
                                 $parameter = new java("java.lang.Double", $passedinvalue);
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break;
                             
                             case 'boolean':
                                 
                                 $parameter = new java("java.lang.Boolean", $passedinvalue);
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break;
                             
                             case 'time':
                                 $number = strtotime($passedinvalue)."000";
                                 $parameter = new Java("java.sql.Time", $number);
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break; 
                            
                             case 'dateTime':
                                 $number = strtotime($passedinvalue)."000";
                                 $parameter = new Java("java.sql.Timestamp", $number);
                                 $this->_task->setParameterValue($this->_nameParametersReport[$i], $parameter);
                                 break;
                             default:
                                 
                             break;
                         }
                              

                     }
                     $i++;
        }
        
          $fmt = null;

	  switch($this->_format) {
	  	
	  case "pdf": 
	    $fmt = new java("org.eclipse.birt.report.engine.api.PDFRenderOption");
	    $fmt->setOutputFormat("pdf");
	    header("Content-type:application/pdf");
	    header("Content-Disposition: attachment; filename=".($this->_name).".pdf");

	    
	    break;
	    
	  case "html": 
	    $fmt = new java("org.eclipse.birt.report.engine.api.HTMLRenderOption");
	    $fmt->setOutputFormat("html");
	    $ih = new java( "org.eclipse.birt.report.engine.api.HTMLServerImageHandler");
	    $fmt->setImageHandler($ih);
		
	    $fmt->setBaseImageURL($this->_urlImage);
	    $fmt->setImageDirectory($this->_pathImage);
	
	    header("Content-type: text/html");
	    header("Content-Disposition: attachment; filename=".($this->_name).".html");

	    break;
	    
	  case "doc":
	    $fmt = new java("org.eclipse.birt.report.engine.api.RenderOption");
	    $fmt->setOutputFormat("doc");
	    header("Content-type: application/msword");
	    header("Content-Disposition: attachment; filename=".($this->_name).".doc");
	    break;
	    
	  case "xls": 
	    $fmt = new java("org.eclipse.birt.report.engine.api.RenderOption");
	    $fmt->setOutputFormat("xls");
	    header("Content-type: application/vnd.ms-excel;");
	    header("Content-Disposition: attachment; filename=".($this->_name).".xls");
	    break;
	    
	  default: Class_Error::messageError("unknown output format $this->_format", E_ERROR );
	  
	  }
			 		  
	  $fmt->setOutputStream($out=new java("java.io.ByteArrayOutputStream"));

	  $this->_task->setRenderOption($fmt);
	  $this->_task->run();
	  $this->_task->close();
	
          echo java_values($out->toByteArray());
	
	}
	
}