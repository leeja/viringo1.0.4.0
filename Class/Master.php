<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * Funciones para obtener Datos de la Base de Datos Maestra.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Master
{

    /**
     * Muestra dependencias con su arbol jerarguico para ser usada en combos
     */
    const TYPE_DEPENDENCY_COMPLETE = 1;

    /**
     * Muestra dependencias solo con siglas para ser usada en combos
     */
    const TYPE_DEPENDENCY_LIGTH = 2;

    /**
     * Conecta a la Base de Datos Master
     * 
     * @access private
     * @param integer $typeUser
     * @return object Class_DataBase
     */
    private function _connectSuperDataBase($typeUser = Class_Interface_DataBase::
        USERSELECT)
    {
        $objDataBase = new Class_SuperDataBase($typeUser, 'master', 'localhost', 'master_r', '248951', '3306', 'Mysql');
        return $objDataBase;

    }

    /**
     * Obtiene todas las dependencias.<br>
     * 
     * <b>[SQL]</b><br>
     * SELECT pkDependency, fkDependency, name, fkLevel, acronym, fkStaff, state FROM master_dependency;
     * 
     * @return array
     */
    public function getAllDependency()
    {
        $objDataBase = $this->_connectSuperDataBase();
        $result = $objDataBase->executeQueryStoreProcedure("get_allDependencies");

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

    /**
     * Obtiene todas las depdencias para mostrar en un combo.<br>
     * TYPE_DEPENDENCY_COMPLETE<br>
     * Ej:  29, 'TL-USPA -> TL-GOTL/TL-SPAD/UNIDAD SEGURIDAD INDUSTRIAL Y PROTECCION AMBIENTAL'<br>
     * <br>
     * TYPE_DEPENDENCY_LIGTH<br>
     * Ej:  29, 'UNIDAD SEGURIDAD INDUSTRIAL Y PROTECCION AMBIENTAL (TL-USPA)', 'TL-USPA'
     * 
     * @param int $type self:TYPE_DEPENDENCY_COMPLETE o self:TYPE_DEPENDENCY_LIGTH
     * @return array
     */
    public function getAllDependencyForCombo($type = self::TYPE_DEPENDENCY_COMPLETE)
    {
        if ($type == self::TYPE_DEPENDENCY_COMPLETE)
            $storeProcedure = "get_dependencyForCombo";
        else
            $storeProcedure = "get_dependencyForCombo1";

        $objDataBase = $this->_connectSuperDataBase();
        $result = $objDataBase->executeQueryStoreProcedure($storeProcedure);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

 public function getAllDependencyForComboOrderAcronym($type = self::TYPE_DEPENDENCY_COMPLETE)
    {
        if ($type == self::TYPE_DEPENDENCY_COMPLETE)
            $storeProcedure = "get_dependencyForCombo";
        else
            $storeProcedure = "get_dependencyForComboOrderAcronym";

        $objDataBase = $this->_connectSuperDataBase();
        $result = $objDataBase->executeQueryStoreProcedure($storeProcedure);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

	public function getAllDependencyForComboOrderAcronymForScr2($stringLevel, $type = self::TYPE_DEPENDENCY_COMPLETE)
    {
        if ($type == self::TYPE_DEPENDENCY_COMPLETE)
            $storeProcedure = "get_dependencyForCombo";
        else
            $storeProcedure = "get_dependencyForComboOrderAcronymForScr2";

        $objDataBase = $this->_connectSuperDataBase();
        $arraySetVariable = array('@InLevel');
        $arrayValueVariable = array($stringLevel);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(50);

        $result = $objDataBase->executeQueryStoreProcedure($storeProcedure, $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

	public function getAllDependencyForComboOrderAcronymByLevel($stringLevel, $type = self::TYPE_DEPENDENCY_COMPLETE)
    {
        if ($type == self::TYPE_DEPENDENCY_COMPLETE)
            $storeProcedure = "get_dependencyForCombo";
        else
            $storeProcedure = "get_dependencyForComboOrderAcronymByLevel";

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InLevel');
        $arrayValueVariable = array($stringLevel);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(50);

        $result = $objDataBase->executeQueryStoreProcedure($storeProcedure, $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

/**
     * Obtiene las Dependencia que jefatura un Usuario.<br>
     *
     * <b>[SQL]</b><br>
     * SELECT d.pkDependency, d.name FROM master_dependency as d
     * WHERE d.fkStaff = InSearch AND d.state = '1';
     *
     * @param int $search
     * @return array
     */
    public function getDependencyByManagerUser($search)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array("@InSearch");
        $arrayValueVariable = array($search);
        $arrayTypeDataVariable = array(Class_Object::DATA_INT);
        $arraySizeDataVariable = array(null);

        $result = $objDataBase->executeQueryStoreProcedure("get_dependencyByManagerUser", $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {        
            $dato[] = $tempRows;
        }
        return $dato;
    }

    /**
     * Verifica que que el usuario y password se encuentra en la Tabla Ldap.
     * 
     * @param string $loginUser
     * @param string $passwordUser
     * @param string $storeProcedure
     * @return bool
     */
    public function getAuthenticates($loginUser, $passwordUser, $storeProcedure = null)
    {
        if (empty($storeProcedure))
            $storeProcedure = 'get_authenticates';

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InLogin', '@InPassword');
        $arrayValueVariable = array(sha1($loginUser), sha1($passwordUser));
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING, Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(50, 50);

        $result = $objDataBase->executeQueryStoreProcedure($storeProcedure, $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        if ((int)$objDataBase->numberRows() === 1) {
            return true;
        } else
            return false;
    }

    /**
     * Obtiene los datos de un usuario.<br>
     * 
     * <b>[SQL]</b><br>
     * SELECT email, pkStaff, login, name, firstlastname, secondlastname, tab, fkRol, fkDependency, state, fkOperation
     * FROM master_staff WHERE login = InLogin or tab = InLogin or pkStaff = InLogin;
     * 
     * @param string $loginUser
     * @return object class_User
     */
    public function getDataUser($loginUser)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InLogin');
        $arrayValueVariable = array($loginUser);
        $arrayTipeDataVariable = array(Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(35);

        $result = $objDataBase->executeQueryStoreProcedure('get_dataUser', $arraySetVariable,
            $arrayValueVariable, $arrayTipeDataVariable, $arraySizeDataVariable);

        if ($tempRows = $objDataBase->exploreRowSelect($result)) {

            $objUser = new Class_User();

            $objUser->setEmail($tempRows[0]);
            $objUser->setPkStaff($tempRows[1]);
            $objUser->setLogin($tempRows[2]);
            $objUser->setName($tempRows[3]);
            $objUser->setFirstLastName($tempRows[4]);
            $objUser->setSecondLastName($tempRows[5]);
            $objUser->setTab($tempRows[6]);
            $objUser->setFkRol($tempRows[7]);
            $objUser->setFkDependency($tempRows[8]);
            $objUser->setState($tempRows[9]);
            $objUser->setFkOperation($tempRows[10]);

            return $objUser;
        } else {
            return null;
        }
    }

    /**
     * Obtiene la Dependencia por pk<br>
     * 
     * <b>[SQL]</b><br>
     * SELECT pkDependency, fkDependency,  name, acronym, fkLevel from master_dependency WHERE pkDependency = InPkDependency;
     * 
     * @param integer $pkDependency
     * @return array
     */
    public function getDependencyById($pkDependency)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array("@InPkDependency");
        $arrayValueVariable = array($pkDependency);
        $arrayTypeDataVariable = array(Class_Object::DATA_INT);
        $arraySizeDataVariable = array(null);

        $result = $objDataBase->executeQueryStoreProcedure("get_dependencyById", $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        if ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;

    }

    /**
     * Obtiene las Dependecias por nivel.<br>
     * 
     * <b>[SQL]</b><br>
     * SELECT d.pkDependency as pkDependency, d.name as nameDependency, d.acronym as acronym, l.name as nameLevel
     * FROM master_dependency as d, master_level as l WHERE d.fkLevel = InFkLevel and d.fkLevel = l.pkLevel;
     * 
     * @param integer $fkLevel
     * @return array
     */
    public function getDependencyByLevel($fkLevel)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array("@InFkLevel");
        $arrayValueVariable = array($fkLevel);
        $arrayTypeDataVariable = array(Class_Object::DATA_INT);
        $arraySizeDataVariable = array(null);

        $result = $objDataBase->executeQueryStoreProcedure("get_dependencyByLevel", $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

    /**
     * Obtiene la Dependencia del Usuario.<br>
     * 
     * <b>[SQL]</b><br>
     * SELECT d.pkDependency, d.name FROM master_dependency as d, master_staff as s
     * WHERE (s.tab = InSearch or s.login = InSearch) AND d.pkDependency = s.fkDependency;
     * 
     * @param string $search
     * @return array
     */
    public function getDependencyByUser($search)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array("@InSearch");
        $arrayValueVariable = array($search);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(35);

        $result = $objDataBase->executeQueryStoreProcedure("get_dependencyByUser", $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        if ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

    /**
     * Obtiene el nombre y descripcion del Rol
     * 
     * <b>[SQL]</b><br>
     * SELECT name, description FROM master_rol WHERE pkRol = InPkRol;
     * 
     * @param integer $pkRol
     * @return string
     */
    public function getDescriptionRolByPkRol($pkRol)
    {

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InPkRol');

        $arrayValueVariable = array($pkRol);
        $arrayTypeDataVariable = array(Class_Object::DATA_INT);
        $arraySizeDataVariable = array(null);

        $result = $objDataBase->executeQueryStoreProcedure('show_rol', $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        if ($tempRows = $objDataBase->exploreRowSelect($result)) {
            return $tempRows[1];
        }
        return false;

    }

    /**
     * Obtiene el numero de paginas, de la tabla Usuarios.<br>
     * 
     * <b>[SQL]</b><br>
     * SET @InNumberRowsByPage = 20;<br>
     *	<br>
     * SELECT count(pkStaff) / @InNumberRowsByPage FROM master_staff WHERE state = '1'  AND ( tab  LIKE @search
     * or login LIKE @search or name LIKE @search or  firstlastname LIKE @search or  secondlastname LIKE @search);
     * 
     * @param string $search
     * @return integer
     */
    public function getNumberPageUsersByTabLoginName($search)
    {

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InSearch');

        $arrayValueVariable = array($search);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(35);

        $result = $objDataBase->executeQueryStoreProcedure('getPageToUsersByTagLoginName',
            $arraySetVariable, $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable, false);

        if ($tempRows = $objDataBase->exploreRowSelect($result)) {
            return $tempRows[0];
        }
        return null;

    }

    /**
     * Obtiene el numero de paginas de la tabla Usuarios, dependiendo de la Dependencia.<br>
     * 
     * @param string $search
     * @param integer $pkDependency
     * @return integer
     */
    public function getNumberPageUsersByTabLoginNameDependency($search, $pkDependency =
        1)
    {

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InSearch', '@InPkDepedency');

        $arrayValueVariable = array($search, $pkDependency);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING, Class_Object::DATA_INT);
        $arraySizeDataVariable = array(35, null);

        $result = $objDataBase->executeQueryStoreProcedure('getPageToUsersByTagLoginNameDependency',
            $arraySetVariable, $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable, false);

        if ($tempRows = $objDataBase->exploreRowSelect($result)) {
            return $tempRows[0];
        }
        return null;

    }

    /**
     * Obtiene el listado de las Operaciones.<br>
     * 
     * <b>[SQL]</b><br>
     * SQL = SELECT pkOperation, name, domain FROM master_operation;
     * 
     * @return array
     */
    public function getOperation()
    {
        $objDataBase = $this->_connectSuperDataBase();

        $objDataBase->executeQueryStoreProcedure('get_Operations');

	 $row = $objDataBase->exploreAllArraySelect();

        if (!isset($row)) {
            $row[0]['Pk_operation'] = 1;
            $row[0]['name'] = Class_Config::get('operation');
            $row[0]['domain'] = Class_Config::get('domain');
        }
	

        return $row;
    }

    /**
     * Obtiene las subDependencias o Dependencias Hijos.<br>
     * 
     * <b>[SQL]</b><br>
     * SELECT d.pKDependency, d.name as nameDependency, d. acronym, l.name as nameLevel
     * FROM master_dependency as d, master_level as l WHERE d.fKDependency = InPKDependency AND l.pkLevel = d.fkLevel;
     * 
     * @param integer $pkDependency
     * @return array
     */
    public function getSubDependencyById($pkDependency)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array("@InPkDependency");
        $arrayValueVariable = array($pkDependency);
        $arrayTypeDataVariable = array(Class_Object::DATA_INT);
        $arraySizeDataVariable = array(null);

        $result = $objDataBase->executeQueryStoreProcedure("get_subDependency", $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }


    /**
     * Obtiene los Usuarios de una Operación.<br>
     * 
     * <b>[SQL]</b><br>
     * SELECT pkStaff as pk, tab as tab, login as login, concat(firstlastname , ' ' , secondlastname , ' ' , name) as name, email as email FROM master_staff
     * WHERE fkOperation = InPkOperation AND state = '1' ORDER BY firstlastname , secondlastname , name;
     * 
     * @param integer $pkOperation
     * @return array
     */
    public function getTabLoginNameEmailAllStaffByOperation($pkOperation)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array("@InPkOperation");
        $arrayValueVariable = array($pkOperation);
        $arrayTypeDataVariable = array(Class_Object::DATA_INT);
        $arraySizeDataVariable = array(null);

        $result = $objDataBase->executeQueryStoreProcedure("get_tabLoginNameEmailAllStaffByOperation",
            $arraySetVariable, $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $dato = array();
        while ($tempRows = $objDataBase->exploreArraySelect($result)) {
            $dato[] = $tempRows;
        }
        return $dato;
    }

    /**
     * Obtiene usuarios que contengan la primera letra de su apellido paterno
     * 
	 * @param string $letter
     * @return array
     */
    public function getUserByLetter($letter)
    {
   
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InChar');

        $arrayValueVariable = array(($letter));
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(1);

        $result = $objDataBase->executeQueryStoreProcedure('search_userByLetter', $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        while ($tempRows = $objDataBase->exploreRowSelect($result)) {
            $dato[] = $tempRows;

        }
        return $dato;
       
    }

    /**
     * Obtiene el listado de usuarios, dependiendo del número de pagina.
     * 
     * @param string $search
     * @param integer $numberPage
     * @return array
     */
    public function getUsersByTabLoginName($search, $numberPage = 1)
    {

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InSearch', '@InNumberPage');

        $arrayValueVariable = array($search, $numberPage);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING, Class_Object::DATA_INT);
        $arraySizeDataVariable = array(35, null);

        $result = $objDataBase->executeQueryStoreProcedure('search_usersByTabLoginName',
            $arraySetVariable, $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable, false);

        while ($tempRows = $objDataBase->exploreRowSelect($result)) {
            $dato[] = $tempRows;
        }
        if (!empty($dato))
            return $dato;
        return null;

    }

    /**
     * Obtiene el listado de Usuarios, dependiendo de la Pagina, la dependencia, el orden y tipo de orden.
     * <br>Usado en el Componente Search.
     * 
     * @param string $search
     * @param integer $numberPage
     * @param integer $pkDependency
     * @param string $orderBy
     * @param string $typeOrder
     * @return array
     */
    public function getUsersByTabLoginNameDependency($search = "", $numberPage = 1,
        $pkDependency = 1, $orderBy, $typeOrder)
    {

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InSearch', '@InNumberPage', '@InPkDepedency',
            '@InOrderBy', '@InTypeOrder');

        $arrayValueVariable = array($search, $numberPage, $pkDependency, $orderBy, $typeOrder);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING, Class_Object::DATA_INT, Class_Object::DATA_INT, Class_Object::DATA_STRING,
            Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(35, null, null, 30, 4);

        $result = $objDataBase->executeQueryStoreProcedure('search_usersByTabLoginNameDependency',
            $arraySetVariable, $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable, false);

        while ($tempRows = $objDataBase->exploreRowSelect($result)) {
            $dato[] = $tempRows;
        }
        if (!empty($dato))
            return $dato;
        return null;

    }

    /**
     * Obtiene el listado de usuarios.
     * 
     * @param string $search
     * @return array
     */
    public function getUserByTabName($search)
    {

        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InSearch');

        $arrayValueVariable = array($search);
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(35);

        $result = $objDataBase->executeQueryStoreProcedure('search_userByTabName', $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        while ($tempRows = $objDataBase->exploreRowSelect($result)) {
            $dato[] = $tempRows;
        }
        if (!empty($dato))
            return $dato;
        return null;
      
    }

    /**
     * Almacena en la tabla LDAP
     * 
     * @param string $loginUser
     * @param string $passwordUser
     * @return integer
     */
    public function insertAuthenticates($loginUser, $passwordUser)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InLogin', '@InPassword');
        $arrayValueVariable = array(sha1($loginUser), sha1($passwordUser));
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING, Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(50, 50);

        $result = $objDataBase->executeUpdateStoreProcedure('add_authenticates', $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $result = $objDataBase->numberRowAffected();

        return $result;
    }
	
    /**
     * Actualiza la tabla Ldap
     * 
     * @param string $loginUser
     * @param string $passwordUser
     * @return integer
     */
    public function updateAuthenticates($loginUser, $passwordUser)
    {
        $objDataBase = $this->_connectSuperDataBase();

        $arraySetVariable = array('@InLogin', '@InPassword');
        $arrayValueVariable = array(sha1($loginUser), sha1($passwordUser));
        $arrayTypeDataVariable = array(Class_Object::DATA_STRING, Class_Object::DATA_STRING);
        $arraySizeDataVariable = array(50, 50);

        $result = $objDataBase->executeUpdateStoreProcedure('change_authenticates', $arraySetVariable,
            $arrayValueVariable, $arrayTypeDataVariable, $arraySizeDataVariable);

        $result = $objDataBase->numberRowAffected();

        return $result;
    }

    /**
     * Verifica si el Usuario se encuentrar en la Tabla User de la Base de Datos Master.
     * 
     * @param mixed $loginUser
     * @param string $nameStoreProcedure
     * @return integer pkTypeUser
     */
    public function verifyUser($fkStaff, $nameStoreProcedure = 'verify_user', $arrayParameters = null)
    {
        $typeUser = null;
	 $nameDataBase = null;
	 $urlServer = null;
	 $userDataBase = null;
	 $passwordUserDataBase = null;
	 $portServerDataBase = null; 
	 $typeDataBase = null;
	
	if(isset($arrayParameters) && is_array($arrayParameters)){
		foreach($arrayParameters as $k => $value)
		{
			$$k = $value;
		}	
	}
	//$typeUser = null, $nameDataBase = null, $urlServer = null,
       // $userDataBase = null, $passwordUserDataBase = null, $portServerDataBase = null, $typeDataBase = null)

	 $objDataBase = new Class_SuperDataBase(Class_Interface_DataBase::USERSELECT , $nameDataBase , $urlServer , $userDataBase , $passwordUserDataBase , $portServerDataBase , $typeDataBase );
	 if(isset($prefixDb)) $objDataBase->setPrefixDb($prefixDb);

        $arraySetVariable = array('@InFkStaff');
        $arrayValueVariable = array($fkStaff);
        $arrayTipeDataVariable = array(Class_Object::getTypeDataSQL(Class_Object::DATA_INT));
        $arraySizeDataVariable = array(3);

        $result = $objDataBase->executeQueryStoreProcedure($nameStoreProcedure, $arraySetVariable,
            $arrayValueVariable, $arrayTipeDataVariable, $arraySizeDataVariable);

        if ($tempRows = $objDataBase->exploreArraySelect($result)) {
            return $tempRows; 
        } else {
            return null;
        }
    }

}