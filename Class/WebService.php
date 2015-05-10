<?php


class Class_WebService 
{
     private $_options;
     private $_data;
    
    public function __construct()
    {
        $this->_options = array(
                        'uri' => Class_Config::get('urlApp')
                        , 'encoding' => 'UTF-8'
                        );
    }

    public  function getOptionsServer()
    {
        return $this->_options;
    }
    
    public function setData($data)
    {
        $this->_data = $data;
    }
    
    public function getData()
    {
        return $this->_data;
    }


}

?>
