<?php

class DbSql
{
    const TYPE_CHAR = 0;
    const TYPE_INT = 1;
    const TYPE_FLOAT = 2;
    const TYPE_ARRAY = 3;
    const TYPE_TEXT = 4;

	public $pdo;
	public $db_name;

    // Do not create instances directly :
    // use "newWithParams" or "newWithConfig" static functions instead.
	public function __construct(){}

	public static function newWithParams($db_host, $db_name, $db_user, $db_pwd='', $db_type = 'mysql')
	{
        $instance = new self();
        $instance->db_name = $db_name;
        $instance->pdo = new PDO($db_type.':host='.$db_host.';dbname='.$db_name, $db_user, $db_pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $instance->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $instance;
    }

    public static function newWithConfig($config)
    {
        return self::newWithParams($config['db_host'], $config['db_name'], $config['db_user'], $config['db_pwd']);
    }

    // ----------------------------------------------------------
    //  Existence
    // ----------------------------------------------------------
	public function tableExists($table_name)
    {
        $sql = "SHOW TABLES LIKE ".$this->pdo->quote($table_name);
        $stmt = $this->pdo->query($sql);
        return (count($stmt->fetchAll(PDO::FETCH_ASSOC)) > 0);
    }

    public function columnExists($table_name, $col)
    {
        //$sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ".$this->pdo->quote($this->db_name)." AND TABLE_NAME = ".$this->pdo->quote($table_name)." AND COLUMN_NAME = ".$this->pdo->quote($col);
        $sql = "SHOW COLUMNS FROM `$table_name` LIKE ".$this->pdo->quote($col);
        $stmt = $this->pdo->query($sql);
        return (count($stmt->fetchAll()) > 0);
    }

    // ----------------------------------------------------------
    //  Table operations
    // ----------------------------------------------------------
    public function createTable($table_name, array $structure = array())
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name`(";
        if(count($structure) > 0)
        {
            $fields = array();
            foreach($structure as $col)
                $fields[] = "`".$col["colName"]."` ".$col["colType"]." ".$col["colNull"]." ".$col["colExtra"];
            $sql .= implode(",", $fields);
        }
        else
        {
            $sql .= "`id` INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY, `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        }
        $sql .= ")ENGINE=MyISAM DEFAULT CHARSET=utf8";

        $stmt = $this->pdo->query($sql);
        return $stmt;
    }

    public function deleteTable($table_name)
    {
        $sql = "DROP TABLE `$table_name`";
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }

    public function clearTable($table_name)
    {
        $sql = "TRUNCATE TABLE `$table_name`";
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }

    public function createColumn($table_name, $col, $type)
    {
        $type_sql = "VARCHAR(256)";
        switch($type){
            case self::TYPE_INT:
                $type_sql = "INT(32)";
                break;
            case self::TYPE_FLOAT:
                $type_sql = "DOUBLE(10, 2)";
                break;
            case self::TYPE_ARRAY:
                $type_sql = "TEXT";
                break;
            case self::TYPE_TEXT:
                $type_sql = "TEXT";
                break;
            default:
                break;
        }
        $sql = "ALTER TABLE $table_name ADD `$col` $type_sql NOT NULL";
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }

    public function getNumRows($table_name, array $where = array())
    {
        $sql = "SELECT COUNT(*) AS num_items FROM `$table_name` AS a";
        $sql .= $this->createRequestWhere($where);
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["num_items"];
    }

    public function createNested($table_name, $item)
    {
        // shift items with parentId = 0
        $sql = "UPDATE $table_name SET sortOrder=sortOrder+1 WHERE parentId=0";
        $stmt = $this->pdo->query($sql);

        if(is_array($item)){
            $item["parentId"] = 0;
            $item["sortOrder"] = 0;
        }
        $this->create($table_name, $item);
    }

    public function deleteNested($table_name, $itemId, $sortOrder)
    {
        // shift items in same branch
        $sql = "UPDATE $table_name SET sortOrder=sortOrder-1 WHERE sortOrder>".$this->pdo->quote($sortOrder);
        $stmt = $this->pdo->query($sql);

        $this->delete($table_name, array('id' => $itemId));
    }

    public function moveNested($table_name, $itemId, $parentId, $sortOrder, $newParentId, $newSortOrder)
    {
        $parentId = intVal($parentId);
        $sortOrder = intVal($sortOrder);
        $newParentId = intVal($newParentId);
        $newSortOrder = intVal($newSortOrder);

        if($newParentId != $parentId)
        {
            // shift items in target tree
            $sql = "UPDATE $table_name SET sortOrder=sortOrder+1".
                " WHERE parentId=".$this->pdo->quote($newParentId)." AND sortOrder>=".$this->pdo->quote($newSortOrder);
            $stmt = $this->pdo->query($sql);

            // modify moved item
            $sql = "UPDATE $table_name SET parentId=".$this->pdo->quote($newParentId).", sortOrder=".$this->pdo->quote($newSortOrder).
                " WHERE id=".$this->pdo->quote($itemId);
            $stmt = $this->pdo->query($sql);

            // update order in source tree
            $sql = "UPDATE $table_name SET sortOrder=sortOrder-1".
                " WHERE parentId=".$this->pdo->quote($parentId)." AND sortOrder>".$this->pdo->quote($sortOrder);
            $stmt = $this->pdo->query($sql);
        }
        else
        {
            if($newSortOrder > $sortOrder)
            {
                // shift items being between source et target positions
                $sql = "UPDATE $table_name SET sortOrder=sortOrder-1".
                    " WHERE parentId=".$this->pdo->quote($parentId).
                    " AND sortOrder>".$this->pdo->quote($sortOrder).
                    " AND sortOrder<=".$this->pdo->quote($newSortOrder);
                $stmt = $this->pdo->query($sql);

                // modify moved item
                $sql = "UPDATE $table_name SET sortOrder=".$this->pdo->quote($newSortOrder).
                    " WHERE id=".$this->pdo->quote($itemId);
                $stmt = $this->pdo->query($sql);
            }
            else if($newSortOrder < $sortOrder)
            {
                // shift items being between source et target positions
                $sql = "UPDATE $table_name SET sortOrder=sortOrder+1".
                    " WHERE parentId=".$this->pdo->quote($parentId).
                    " AND sortOrder>=".$this->pdo->quote($newSortOrder).
                    " AND sortOrder<".$this->pdo->quote($sortOrder);
                $stmt = $this->pdo->query($sql);

                // modify moved item
                $sql = "UPDATE $table_name SET sortOrder=".$this->pdo->quote($newSortOrder).
                    " WHERE id=".$this->pdo->quote($itemId);
                $stmt = $this->pdo->query($sql);
            }
        }
        return $stmt;
    }
    
    // -----------------------------------------------------------------
    //	CRUD
    // -----------------------------------------------------------------
    public function create($table, $params = array())
	{
		$keys = array("`id`");
		$values = array("NULL");
		if(is_array($params)){
		    foreach($params as $key => $value)
            {
                $keys[] = "`".$key."`";
                $values[] = $this->pdo->quote($value);
            }
		}
		$keys = implode(",", $keys);
		$values = implode(",", $values);
	
		$sql = "INSERT INTO `$table` ($keys) VALUES ($values)";
		$stmt = $this->pdo->query($sql);

		if($stmt){
		    return $this->read($table, array("id" => $this->pdo->lastInsertId()));
		}
		return $stmt;
	}
	
	public function read($table, array $where = array(), array $joins = array())
	{
        $sql = $this->createSelectRequest($table, $where, array(), null, null, $joins);
        //throw new Exception($sql);
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function readAll($table, array $where = array(), array $orderby = array(), $limit = null, $offset = null, array $joins = array())
    {
        $sql = $this->createSelectRequest($table, $where, $orderby, $limit, $offset, $joins);
        //throw new Exception($sql);
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function update($table, array $where = array(), array $params = array())
	{
	    $values = array();
        foreach($params as $key => $value)
            $values[] = "a.".$key."=".$this->pdo->quote($value);

        if(count($values) > 0)
        {
            $values = implode(",", $values);
            $sql = "UPDATE `$table` AS a SET ".$values;
            $sql .= $this->createRequestWhere($where);
            $stmt = $this->pdo->query($sql);
            return $stmt;
        }
	}

	public function delete($table, array $where = array())
    {
        $sql = "DELETE a FROM $table AS a";
        $sql .= $this->createRequestWhere($where);
        //throw new Exception($sql);
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }

    // ----------------------------------------------------------
    //  "SELECT" full request
    // ----------------------------------------------------------
	private function createSelectRequest($table, array $where = array(), array $orderby = array(), $limit = null, $offset = null, array $joins = array())
	{
	    $sql = "SELECT a.*";

        $tableAlias = 'a';
        $fields = array();
        if(!empty($joins)){
            foreach($joins as $join_table => $params){
                ++$tableAlias;
                foreach($params['fields'] as $col => $alias){
                    $fields[] = "$tableAlias.$col AS $alias";
                }
            }
            $sql .= ', '.implode(", ", $fields);
        }

        $sql .= " FROM `$table` AS a";

        $tableAlias = 'a';
        $where_request_join = '';

        if(!empty($joins)){
            foreach($joins as $join_table => $params){
                ++$tableAlias;
                $where_join = "";

                if(isset($params['where_join']) && !empty($params['where_join']))
                    foreach($params['where_join'] as $col => $value)
                        $where_join .= " AND $tableAlias.$col=".$this->pdo->quote($value);

                if(isset($params['where_select']) && !empty($params['where_select']))
                    foreach($params['where_select'] as $col => $value)
                        $where_request_join .= " AND $tableAlias.$col=".$this->pdo->quote($value);

                $sql .= " LEFT JOIN $join_table AS $tableAlias ON (a.".$params['col_src']." = $tableAlias.".$params['col_tgt']."$where_join)";
            }
        }

        $where_request = $this->createRequestWhere($where);
        if($where_request_join)
            $where_request .= $where_request_join;
        $sql .= $where_request;
        $sql .= $this->createRequestOrderBy($orderby);

        // TODO : 2 where dans le join : celui qui permet de sélectionner dans la jointure et le where global
        //$sql .= $where_join;

        //throw new Exception($sql);

        if($limit !== null)
            $sql .= " LIMIT ".$limit;
        if($offset !== null)
            $sql .= " OFFSET ".$offset;

        return $sql;
	}

    // ----------------------------------------------------------
    //  "WHERE" part of the request
    // ----------------------------------------------------------
	private function createRequestWhere($params)
    {
        if(!empty($params))
        {
            $where = array();

            // Check the first element to understand the format. 2 possibilities :
            // - $where = array("col1" => "value1", "col2" => "value2")
            // - $where = array(array("type" => "type1", "col" => "col1", "value" => "value1"), array(...), ...)

            if(!isset($params[0]) || !is_array($params[0]))
            {
                foreach($params as $name => $value)
                    $where[] = "a.".$name."=".$this->pdo->quote($value);
            }
            else
            {
                foreach($params as $where_field){
                    if(!isset($where_field["type"]))
                    {
                        $where[] = "a.".$where_field["col"]."=".$this->pdo->quote($where_field["value"]);
                    }
                    if($where_field["type"] == "text" ||
                        $where_field["type"] == "email" ||
                        $where_field["type"] == "url" ||
                        $where_field["type"] == "tel" ||
                        $where_field["type"] == "textarea")
                    {
                        $where[] = "a.".$where_field["col"]." LIKE ".$this->pdo->quote("%".$where_field["value"]."%");
                    }
                    else if($where_field["type"] == "number")
                    {
                        $where[] = "a.".$where_field["col"]."=".$this->pdo->quote($where_field["value"]);
                    }
                    else if($where_field["type"] == "select")
                    {
                        $where[] = "a.".$where_field["col"]."=".$this->pdo->quote($where_field["value"]);
                    }
                    else if($where_field["type"] == "date")
                    {
                        $sign = "=";
                        if(isset($where_field["info"])){
                            if($where_field["info"] == "-1") $sign = "<=";
                            else if($where_field["info"] == "1") $sign = ">=";
                        }
                        $where[] = "a.".$where_field["col"].$sign.$this->pdo->quote($where_field["value"]);
                    }
                    else if($where_field["type"] == "checkbox")
                    {
                        if($where_field["value"] == "1")
                            $where[] = "a.".$where_field["col"]."=1";
                        else if($where_field["value"] == "-1")
                            $where[] = "a.".$where_field["col"]."=0";
                    }
                }
            }
            if(!empty($where))
            {
                $where = " WHERE ".implode(" AND ", $where);
                return $where;
            }
        }
        return "";
    }

    // ----------------------------------------------------------
    //  "ORDER BY" part of the request
    // ----------------------------------------------------------
    private function createRequestOrderBy($params)
    {
        if(!empty($params))
        {
            $orderby = array();
            foreach($params as $order)
            {
                //if(!isset($order["col"]))
                  //  throw new Exception(serialize($params));
                $orderby[] = $order["col"]." ".($order['asc'] == "true" ? "ASC" : "DESC");
            }
            if(!empty($orderby))
                return " ORDER BY ".implode(", ", $orderby);
        }
        return "";
    }

    // -----------------------------------------------------------------
    //	Export : $params = array("orderby" => jsonArray, "columns" => jsonArray)
    // -----------------------------------------------------------------
    public function exportCsv($table_name, $orderby, $delimiter = ";", $ext = '.csv', $charset = null)
    {
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$table_name.$ext);
        $output = fopen('php://output', 'w');

        $sql = "SHOW COLUMNS FROM `$table_name`";
        $stmt = $this->pdo->query($sql);
        $colNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($colNames as &$colName)
            $colName = $colName["Field"];

        fputcsv($output, $colNames, $delimiter);

        $params = array();
        $limit = 5;

        $numRows = $this->getNumRows($table_name);

        for($offset=0; $offset<$numRows; $offset += $limit)
        {
            $items = $this->readAll($table_name, array(), array(), $limit, $offset);

            foreach($items as $i => $item){
                $values = array();
                foreach($colNames as $colName){
                    if($charset){
                        // This is for Excel :
                        $values[] = isset($item[$colName]) ? iconv('UTF-8', $charset, $item[$colName]) : "";
                    }
                    else{
                        // This is for CSV :
                        $values[] = isset($item[$colName]) ? $item[$colName] : "";
                    }
                }
                fputcsv($output, $values, $delimiter);
            }
        }
    }
    public function exportExcel($table_name, $orderby)
    {
        $this->exportCsv($table_name, $orderby, ';', '.csv', 'Windows-1252');
    }
    public function exportSql($table_name, $config)
    {
        $file_path = __DIR__.'/tmp_table_dump_'.uniqId().'.sql';
        $command = sprintf($config["mysql_cmd"]." -d ".$config['db_name']." $table_name -u ".$config['db_user']." --password=".$config['db_pwd']." --no-create-db=false --no-data=false > ".$file_path);
        $result = exec($command);

        require_once(__DIR__."/Utilities/FileDownloader.php");
        $downloader = new FileDownloader();
        $downloader->downloadFromServerToClient($file_path);

        unlink($file_path);
    }

    public function saveDb($config)
    {
        $file_path = __DIR__.'/tmp_dump_'.date('Y-m-d-H-i-s').'.sql';
        $command = sprintf($config["mysql_cmd"]." -d -h".$config['db_host']." -u".$config['db_user']." -p".$config['db_pwd']." ".$config['db_name']." --no-create-db=false --no-data=false > ".$file_path);
        $result = exec($command);

        require_once(__DIR__."/Utilities/FileDownloader.php");
        $downloader = new FileDownloader();
        $downloader->downloadFromServerToClient($file_path);

        unlink($file_path);
    }

    // ----------------------------------------------------------
    //  Utilities
    // ----------------------------------------------------------
    public static function valueType($value)
    {
        $type = self::TYPE_CHAR;
        if(is_array($value))
            $type = self::TYPE_ARRAY;
        else if(filter_var($value, FILTER_VALIDATE_INT))
            $type = self::TYPE_INT;
        else if(filter_var($value, FILTER_VALIDATE_FLOAT))
            $type = self::TYPE_FLOAT;
        else if(strlen(strval($value)) > 200)
            $type = self::TYPE_TEXT;
        return $type;
    }

    public static function valueCast($value, $type)
    {
        switch($type){
            case self::TYPE_CHAR:
            case self::TYPE_TEXT:
                $value = strval($value);
                break;
            case self::TYPE_INT:
                $value = intval($value);
                break;
            case self::TYPE_FLOAT:
                $value = floatval($value);
                break;
            case self::TYPE_ARRAY:
                $value = serialize($value);
                break;
            default:
                break;
        };
        return $value;
    }
}
