<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para cargar el formulario de parametros para correr Reportes.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2011 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  01/03/2012
 * @access public
 */
class Class_Report_Form {
    
    private $_action;
    private $_input;
    private $_headReport;
    
    /**
     * Extensión de los Reportes
     * 
     * @var string
     */
    const EXTENSION_REPORT = 'rptdesign';

    /**
     * Carga la lista de reportes alojados en un ubicación
     * 
     * @param string $pathLoadReport (Ruta de los reportes a cargar con el formulario)
     * @param string $pathReport (Ruta principal de los Reportes)
     */
    public function loadListReport($pathLoadReport = 'LoadReport', $pathReport = 'Components/Reports')
    {
        
        $path = Class_Config::get('pathServer').$pathReport.DIRECTORY_SEPARATOR.$pathLoadReport;
        $arrayListReport = null;
        if(is_dir($path)){
            
            $directory = dir($path);
            
            while (false !== ($entry = $directory->read())) {
               
                if(pathinfo($entry, PATHINFO_EXTENSION) == self::EXTENSION_REPORT){
                    
                     $objReport = new Class_Report($pathLoadReport.DIRECTORY_SEPARATOR.pathinfo($entry, PATHINFO_FILENAME));
                     $headerReport = $objReport->getDataHeadReport();
                     $titleReport = (string)$headerReport['titleReport'];
                     if(empty($titleReport))
                         $arrayListReport[pathinfo($entry, PATHINFO_FILENAME)] = (string)pathinfo($entry, PATHINFO_FILENAME);
                     else
                         $arrayListReport[pathinfo($entry, PATHINFO_FILENAME)] = $titleReport;
                     
                    }  
               }
            $directory->close();
        }
        echo "<fieldset>";
        echo "<form action='".Class_Config::get('urlApp').DIRECTORY_SEPARATOR.'Report'.DIRECTORY_SEPARATOR.'LoadFormReport'."' method='post' id='idFormLoadReport' >";
        echo "<span class='labelFormResponse' >".Class_Report_Language::get('selectReport')."</span> <select id='nameReport' name='nameReport' onChange='showFormReports();' class='comboForm'>";
        echo "<option >....</option>";
        if(isset($arrayListReport)){
        foreach($arrayListReport as $key => $value){
            
            echo "<option value='".$key."'>".$value."</option>";
        }
        }
        echo "</select>";
        echo "</form>";
        echo "</fieldset>";
        
        echo "<div id='formReport'>";
        
        echo "</div>";
        
    }
    
    /**
     * Setea el arreglo de parametros
     * 
     * @param array $array 
     */
    public function setInput($array)
    {
        $this->_input = $array;
    }
    
    /**
     * Setea el arreglo de atributos de la cabecera del reporte
     * 
     * @param array $array 
     */
    public function setHeadReport($array)
    {
        $this->_headReport = $array;
    }
    
    
    /**
     * Muestra el Formulario con los parametros de entrada del reporte
     * 
     * @param type $nameReport (Nombre del reporte a cargar)
     */
    public function showForm($nameReport)
    {
        
        if(!empty($nameReport)){
         
           $objReport = new Class_Report('LoadReport/'.$nameReport);
           $array = $objReport->getParameters();
           $arrayHead = $objReport->getDataHeadReport();
            
           $this->setInput($array);
           $this->setHeadReport($arrayHead);
           
        
        
        $this->_action = Class_Config::get('urlApp').DIRECTORY_SEPARATOR.'Report'.DIRECTORY_SEPARATOR.'runReport'.DIRECTORY_SEPARATOR.'nameReport'.$nameReport;
        
        $numberIsRequired = 0;
        
        echo "<span class='titleForm'>".$this->_headReport['titleReport']."</span>";
        echo "<br />";
        echo "<br />";
        echo "<form action='".$this->_action."' method='post' id='idFormReportLoad'>";
        echo "<table >";
            for($i = 0; $i < count($this->_input); $i++){
                
                $isHidden = $this->_input[$i]['isHiddenParametersReport'];
                $nameParameter = Class_App::aUtf8($this->_input[$i]['nameParametersReport']);
                $dafaultValueParameter = Class_App::aUtf8($this->_input[$i]['defaultValueParametersReport']);
                $promptTextPatameters = Class_App::aUtf8($this->_input[$i]['promptTextPatametersReport']);
                $helpTextPatameter = Class_App::aUtf8($this->_input[$i]['helpTextPatametersReport']);
                $selectionListValue =  Class_App::aUtf8($this->_input[$i]['selectionListValue']);
                $selectionListLabel = Class_App::aUtf8($this->_input[$i]['selectionListLabel']);
                $controlTypePatameter = $this->_input[$i]['controlTypePatametersReport'];
                $requiredParameter = $this->_input[$i]['requiredParametersReport'];
                //$formatParameter = $this->_input[$i]['formatParametersReport'];
                if($requiredParameter) $numberIsRequired++;
                
                if($isHidden)
                     echo "<input type='hidden' name='".$nameParameter."' id='".$nameParameter."' value='".$dafaultValueParameter."' />";
                else{
                    echo "<tr>";
                    echo "<td class='labelFormResponse'>".$promptTextPatameters;
                    if ($requiredParameter) echo " <span class='textAlert'>*</span>";
                    echo ":</td>";
                    if($controlTypePatameter == 'list-box' or $controlTypePatameter == 'combo-box'){
                        echo "<td><select name='".$nameParameter."' id='".$nameParameter."' title='".$helpTextPatameter."' class='comboForm'>";
                        $count = count($selectionListValue);
                        for($j = 0;$j < $count; $j++){
                            echo "<option value='".$selectionListValue[$j]."'>".$selectionListLabel[$j]."</value>";
                        }
                        echo "</select></td>";
                    }   
                    elseif($controlTypePatameter =='check-box'){
                        $checked['true'] = 'checked';
                        $checked['false'] = '';
                        echo "<td><input type='checkbox' name='".$nameParameter."' id='".$nameParameter."' ".$checked[$dafaultValueParameter]." title='".$helpTextPatameter."'/></td>";
                    }
                    elseif($controlTypePatameter  == 'radio-button'){
                        $radio[] = null;
                        $radio[$dafaultValueParameter] = 'checked';

                        $count = count($selectionListValue);
                         for($j = 0;$j < $count; $j++){
                            if(isset($radio[$selectionListValue[$j]]))
                                echo "<td><input type='radio' name='".$nameParameter."' id='".$nameParameter."' ".$radio[$selectionListValue[$j]]." title='".$helpTextPatameter."' value='".$selectionListValue[$j]."'/><span class='labelFormResponse'>$selectionListValue[$j]</span></td>";
                            else
                                echo "<td><input type='radio' name='".$nameParameter."' id='".$nameParameter."' title='".$helpTextPatameter."' value='".$selectionListValue[$j]."'/><span class='labelFormResponse'>$selectionListValue[$j]</span></td>";
                        }
                    }     
                    else{
                        echo "<td><input type='text' name='".$nameParameter."' id='".$nameParameter."' value='".$dafaultValueParameter."' title='".$helpTextPatameter."' class='textBoxForm'/></td>";
                    }
                    echo "</tr>";
                }
             }
        echo "<tr><td colspan = '2' align='center'><input name='btnLoadReport' type='submit' value='".Class_Report_Language::get('loadReport')."' class='buttonForm'/></td></tr>";
        echo "</table>";
        echo "<input type='hidden' name='nameReport' value='".$nameReport."' />";
        echo "<input type='hidden' name='flagLoadReport' value='".sha1($nameReport)."' />";
        echo "<input type='hidden' name='numberParameters' value='".$i."' />";
        echo "<form/>";
        if($numberIsRequired > 0)
            echo "<span class='textAlert'>".Class_Report_Language::get('isRequired')."</span>";
        }
        else
           Class_Error::messageError (Class_Report_Language::get('notNameReport'));
    }
     
    /**
     *
     * Ejecuta el reporte a partir del formulario creado
     * 
     * @param type $nameReport Nombre del Reporte
     */
    public function runReport($nameReport)
    {
    
     $flagLoadReport = Class_SendData::post('flagLoadReport');
     if($flagLoadReport == sha1($nameReport)){
             
             $numberParameters = Class_SendData::post('numberParameters');
             
             if($numberParameters > 0)
             {
                 $objReport = new Class_Report('LoadReport/'.$nameReport);    
                 $array = $objReport->getParameters();

                 if(isset($array) and is_array($array)){
                    foreach($array as $key => $value){

                        $typeData = $value['typeParametersReport'];
                        $nameField = $value['nameParametersReport'];
                        $valueField = Class_SendData::post($nameField);
                    
                    switch($typeData){
                        
                        case 'string': 
                        case 'time':
                        case 'dateTime':
                                        $parametersObject[$nameField] = new Class_Object_String();
                                        $parametersObject[$nameField]->setValue((string)$valueField);
                                         break;
                        case 'integer':
                                        $parametersObject[$nameField] = new Class_Object_Int();
                                        $parametersObject[$nameField]->setValue((int)$valueField);
                                         break;
                                     
                        case 'decimal':
                                        $parametersObject[$nameField] = new Class_Object_Float();
                                        $parametersObject[$nameField]->setValue((double)$valueField);
                                         break;
                        case 'float':
                                        $parametersObject[$nameField] = new Class_Object_Float();
                                        $parametersObject[$nameField]->setValue((float)$valueField);
                                         break;
                                     
                        case 'boolean':
                                        $parametersObject[$nameField] = new Class_Object_Boolean();
                                        $parametersObject[$nameField]->setValue((boolean)$valueField);
                                         break;
                        case 'date':
                                        $parametersObject[$nameField] = new Class_Object_Date();
                                        $parametersObject[$nameField]->setValue($valueField);
                                         break;
                        default: 
                                        $parametersObject[$nameField] = new Class_Object_String();
                                        $parametersObject[$nameField]->setValue((string)$valueField);
                                        break;
                    }
                    
                }
             }
             
             $objReport->setParameters($parametersObject, true);
              
             if(is_object($parametersObject['outFormat']))
                 $objReport->setFormat($parametersObject['outFormat']->getValue());
             
             }
             $objReport->run();
              
             exit(0);
           }
    }
}
