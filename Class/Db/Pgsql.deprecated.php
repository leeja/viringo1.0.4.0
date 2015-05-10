<?php
/**
 * @deprecated
 */
class Class_Db_Pgsql implements Class_Interface_DataBase {

    private $_conex;
    private $_cursor = true;
    protected $_nameDataBase;
    private $_prefixDb;
    private $_result;
    private $_conection;
    private $_schema;

    public function connectDataBase($typeUser = null, $nameDataBase = null, $urlServer = null, $userDataBase = null, $passwordUserDataBase = null, $portServer = null) {

        $this->_conection = pg_connect("host=" . $urlServer .
                " port=" . $portServer .
                " dbname=" . $nameDataBase .
                " user=" . $userDataBase .
                " password=" . $passwordUserDataBase) or die("No se puede conectar al servidor, consulte con su administrador!!!");

        $this->_nameDataBase = $nameDataBase;
        $this->_prefixDb = Class_Config::get('prefixDb');
        $this->_schema = 'public';

        if ($this->_conection) {
            return $this->_conection;
        } else {
            return "No se puede conectar al servidor, consulte con su administrador!!!";
        }
    }

    public function disconnectDataBase() {
        pg_close();
    }

    public function executeQuerySelect($sql) {
        $this->_result = pg_query($this->_conection, $sql);
        return $this->_result;
    }

    public function executeQueryUpdate($sql) {
        $this->_result = pg_query($this->_conection, $sql);
        return $this->_result;
    }

    public function exploreAllArraySelect() {
        $valueReturn = 0;
        if (isset($this->_result))
            $valueReturn = pg_fetch_all($this->_result);
        return $valueReturn;
    }

    public function exploreArraySelect($result) {
        return pg_fetch_array($result);
    }

    public function exploreRowSelect($result) {
        return pg_fetch_row($result);
    }

    public function exploreAssocSelect($result) {
        return pg_fetch_assoc($result);
    }

//Returns the number of rows in a result
    public function numberRows() {
        $valueReturn = 0;
        if (isset($this->_result))
            $valueReturn = pg_num_rows($this->_result);
        return $valueReturn;
    }

//Returns the number of fields in a result
    public function numberCols() {
        $valueReturn = 0;
        if (isset($this->_result))
            $valueReturn = pg_fetch_all_columns($this->_result);
        return $valueReturn;
    }

//Returns number of affected records (tuples)
    /* public function numberRowAffected() {
      $valueReturn = 0;
      if (isset($this->_result))
      $valueReturn = pg_affected_rows($this->_result);

      return $valueReturn;
      } */
    public function numberRowAffected() {
        $valueReturn = 0;
        if (isset($this->_result)) {
            if ($row = $this->exploreArraySelect($this->_result))
                $valueReturn = $row[0];
        }
        return $valueReturn;
    }

    public function rows() {
        $valueReturn = 0;
        if (isset($this->_result))
            $valueReturn = pg_fetch_row($this->_result);
        return $valueReturn;
    }

    public function executeQueryStoreProcedure($nameStoreProcedure, $arraySetVariable = NULL, $arrayValueVariable = NULL, $arrayTypeDataVariable = NULL, $arraySizeDataVariable = NULL, $debugger = FALSE, $die = TRUE) {
        try {
            $sql = 'select ' . $this->_nameDataBase . '.' . $this->_schema . '.' . $this->_prefixDb . '_' . $nameStoreProcedure .
                    '(';
            $sql .= "'refcursor'";
            if (!is_array($arrayValueVariable) || count($arrayValueVariable) == 0)
                $arrayValueVariable = null;
            else
                $sql .= ",";

            if (isset($arrayValueVariable)) {
                foreach ($arrayValueVariable as $k => $v) {
//$v = Class_App::aUtf8($v);
                    if ($arrayTypeDataVariable[$k] === Class_Object::DATA_STRING or $arrayTypeDataVariable[$k] === Class_Object::DATA_DATE
                            or $arrayTypeDataVariable[$k] === Class_Object::DATA_EMAIL or $arrayTypeDataVariable[$k] === Class_Object::DATA_NAME) {
                        if (isset($v))
                            $sql .= "'" . (pg_parameter_status($this->_conection, "server_encoding") == 'UTF8' ? Class_App::utf8($v) : $v) . "',";
                        else
                            $sql .= "NULL,";
                    }
                    else {
                        if (!isset($v))
                            $v = 'null';
                        $sql .= $v . ',';
                    }
                }
                $sql = substr($sql, 0, (strlen($sql) - 1)); //para quitarle la ultima coma
            }

            $sql .= ');';
            $sql .= "FETCH ALL IN refcursor";

            $this->_cursor = false;

            if ($debugger == true) {
                if ($die == true) {
                    die($sql);
                    exit(0);
                } else
                    echo $sql;
            }

            /* if ($this->_countStoreProcedure > 0)
              $this->_pgsql->next_result();
              $this->_countStoreProcedure++; */

            $this->_result = $this->executeQuerySelect($sql);

            if (empty($this->_result)) {
                $stringError = 'Error Query';
                $stringError .= '<br/><b>Error SQL:</b>' . $this->_pgsql->error;
                $stringError .= '<br/><b>SQL:</b>' . $sql;
                throw new Exception($stringError);
            }

            return $this->_result;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function executeUpdateStoreProcedure($nameStoreProcedure, $arraySetVariable = NULL, $arrayValueVariable = NULL, $arrayTypeDataVariable = NULL, $arraySizeDataVariable = NULL, $debugger = FALSE, $die = TRUE) {
        try {

//$array_temp[(pg_parameter_status($conection, "server_encoding") == 'UTF8' ? utf8_decode($value) : $value )] = ISO_decode($value);

            $sql = 'select ' . $this->_nameDataBase . '.' . $this->_schema . '.' . $this->_prefixDb . '_' . $nameStoreProcedure .
                    '(';
            if (isset($arrayValueVariable)) {
                foreach ($arrayValueVariable as $k => $v) {
//$v = Class_App::aUtf8($v);
                    if ($arrayTypeDataVariable[$k] === Class_Object::DATA_STRING or $arrayTypeDataVariable[$k] === Class_Object::DATA_DATE
                            or $arrayTypeDataVariable[$k] === Class_Object::DATA_EMAIL or $arrayTypeDataVariable[$k] === Class_Object::DATA_NAME) {
                        if (isset($v))
                            $sql .= "'" . (pg_parameter_status($this->_conection, "server_encoding") == 'UTF8' ? Class_App::utf8($v) : $v) . "',";
                        else
                            $sql .= "NULL,";
                    }
                    else {
                        if (!isset($v))
                            $v = 'null';
                        $sql .= $v . ',';
                    }
                }
                $sql = substr($sql, 0, (strlen($sql) - 1)); //para quitarle la ultima coma
            }

            $sql .= ')';

            if ($debugger == true) {
                if ($die == true) {
                    die($sql);
                    exit(0);
                } else
                    echo $sql;
            }

            /*
              if ($this->_countStoreProcedure > 0)
              $this->_pgsql->next_result();
              $this->_countStoreProcedure++;
             */

            $this->_result = $this->executeQueryUpdate($sql);

            if (empty($this->_result)) {
                $stringError = 'Error Query';
                $stringError .= '<br/><b>Error SQL:</b>' . $this->_pgsql->error;
                $stringError .= '<br/><b>SQL:</b>' . $sql;
                throw new Exception($stringError);
            }

            return $this->_result;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

