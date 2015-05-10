<?PHP

class Class_Object_Reference 
{
    private $_objectModel;
    static $_instance;
   
    public function __construct( $nameObject, $null = false )
    {
        $model = "Application_Models_".ucfirst($nameObject)."Model";
        if(class_exists($model))
            $this->_objectModel = new $model();
        else 
            Class_Error::messageError('Class Not Found');
    }
    
    
    public function getInstance($nameObject, $null = false)
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($nameObject, $null);
        }
        return self::$_instance;
    }
    
    public function getReference( $nameObject )
    {
        $model = "Application_Models_".ucfirst($nameObject)."Model";
        return new $model();
    }
    
    public function getValue( $nameParameter)
    {
        $methodParameter = "get".ucfirst($nameParameter);
        return $this->_objectModel->$methodParameter();
    }
    
    public function setValue( $nameParameter,  $value)
    {
        
        $methodParameter = "set".ucfirst($nameParameter);
        $this->_objectModel->$methodParameter($value);
        
    }
    
}