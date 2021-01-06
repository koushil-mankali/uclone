<?php
require_once "keys.php";
class Database{

    private $dbname = DNAME;
    private $host = HOST;
    private $username = NAME;
    private $password = PASSWORD;
    private $connection = false;
    private $conn = "";
    private $result = array();

    public function __construct(){
        if($this->connection == false){
            try{
                $this->conn=new PDO($this->host,$this->username,$this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $this->connection = true;
            }catch(PDOException $e){
                die(array_push($this->result,"Error Connection!"));
            }
        }
    }

    public function insert($table,$params = array()){
        if($this->tableExists($table)){

            $tablecols = implode(',',array_keys($params));
            $tablevalues = implode("','",$params);

            $sql = "INSERT INTO $table ($tablecols) VALUES ('$tablevalues')";
            $pre=$this->conn->prepare($sql);
            if($pre->execute()){
                return true;
            }else{
                array_push($this->result,"Unable to Insert Data into Database");
                return false;
            }
        }
    }

    public function update($table,$cols,$where){
        if($this->tableExists($table)){
            $sql = "UPDATE $table SET $cols WHERE $where";
            $pre=$this->conn->prepare($sql);
            if($pre->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            array_push($this->result,"Unable to Update Data!");
            return false;
        }
    }

    public function delete($table,$where=null){
        if($this->tableExists($table)){
            $sql = "DELETE FROM $table";
            if($where != null){
                $sql .= " WHERE $where";
            }
            $pre=$this->conn->prepare($sql);
            if($pre->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            array_push($this->result,"Unable to Delete Data!");
            return false;
        }
    }

    public function select($table,$rows='*',$join=null,$where=null,$order=null,$limit=array()){
        if($this->tableExists($table)){

            $sql = "SELECT $rows FROM $table";

            if($join != null){
                $sql .=" JOIN $join";
            }
            if($where != null){
                $sql .=" WHERE $where";
            }
            if($order != null){
                $sql .=" ORDER BY $order";
            }
            if($limit != null){
                $key = implode(',',array_keys($limit));
                $val = implode("','",$limit);
                $sql .=" LIMIT $key,$val";
            }
            
            $pre=$this->conn->prepare($sql);

            if($pre->execute()){
                $this->result = $pre->fetchAll(PDO::FETCH_ASSOC);
                return true;
            }else{
                array_push($this->result,"Error Fetching Data!");
                return false;
            }
        }
    }

    public function selectg($table,$rows='*',$join=null,$where=null,$grpby=null,$order=null,$limit=array()){
        if($this->tableExists($table)){

            $sql = "SELECT $rows FROM $table";

            if($join != null){
                $sql .=" JOIN $join";
            }
            if($where != null){
                $sql .=" WHERE $where";
            }
            if($grpby != null){
                $sql .=" GROUP BY $grpby";
            }
            if($order != null){
                $sql .=" ORDER BY $order";
            }
            if($limit != null){
                $key = implode(',',array_keys($limit));
                $val = implode("','",$limit);
                $sql .=" LIMIT $key,$val";
            }

            $pre=$this->conn->prepare($sql);

            if($pre->execute()){
                $this->result = $pre->fetchAll(PDO::FETCH_ASSOC);
                return true;
            }else{
                array_push($this->result,"Error Fetching Data!");
                return false;
            }
        }
    }

    public function sqlselect($sqll){
        $pre=$this->conn->prepare($sqll);
        if($pre->execute()){
            $this->result = $pre->fetch(PDO::FETCH_ASSOC);
            return true;
        }else{
            array_push($this->result,"Error Fetching Data!");
            return false;
        }
    }

    public function __destruct(){
        if($this->connection){
            $this->conn=null;
            $this->connection = false;
        }
    }

    public function tableExists($table){
        $sql = "SHOW TABLES FROM $this->dbname LIKE '$table'";
        $tableInDB = $this->conn->prepare($sql);
        if($tableInDB->execute()){
            if($tableInDB->rowCount() == 1){
                return true;
            }else{
                array_push($this->result,"$table Table Doesn't Exists");
                return false;
            }
        }else{
            array_push($this->result,"Error TableExists!");
            return false;
        }
    }

    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }
    
}

?>