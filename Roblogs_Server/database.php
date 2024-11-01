<?php

class Database{
    private $db;
    public function __construct(){
        try { $this->db = new PDO("mysql:host=localhost;dbname=newroblogs", "root", ""); } catch (PDOException $e){ exit("Failed Loading Roblogs Data"); }
    }

    public function Prepare_Data($sql,$Array = array()){
        $Result_Array = array();
        $request = $this->db->prepare($sql);
        $request->execute($Array);

        while($result = $request->fetch()){
            $Result_Array[] = $result;
        }
        return $Result_Array;
    }

    public function Prepare_Data_BindValue($sql,$array = array()){
        $Result_Array = array();
        $request = $this->db->prepare($sql);

        foreach($array as $data){

            $Order = $data[0];
            $Thing = $data[1];
            $PDO_Type = isset($data[2]) ? $data[2] : PDO::PARAM_STR;

            $request->bindValue($Order,$Thing,$PDO_Type);
        }

        $request->execute();
        while($z = $request->fetch()){
            $Result_Array[] = $z;
        }

        return $Result_Array;
    }

    public function FetchColumn($sql,$Array = array()){
        $request = $this->db->prepare($sql);
        $request->execute($Array);
        $result = $request->fetchColumn();
        $request->closeCursor();
        return $result;  
    }

    public function Execute($sql,$array = array()){

        $request = $this->db->prepare($sql);
        foreach($array as $data){

            $Order = $data[0];
            $Thing = $data[1];
            $PDO_Type = isset($data[2]) ? $data[2] : PDO::PARAM_STR;

            $request->bindValue($Order,$Thing,$PDO_Type);
        }
        $request->execute();

        $Final = $request->rowCount();
        return $Final > 0 ? true : false;
    }
    
    /**If Created returns Item ID */
    public function Execute_LastID($sql,$array = array()){

        $request = $this->db->prepare($sql);
        foreach($array as $data){

            $Order = $data[0];
            $Thing = $data[1];
            $PDO_Type = isset($data[2]) ? $data[2] : PDO::PARAM_STR;

            $request->bindValue($Order,$Thing,$PDO_Type);
        }
        $request->execute();
        return $this->db->lastInsertId();
    }
}


class DB_Build extends Database{


    












}




?>