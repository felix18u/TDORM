<?php

class Query {

    private $sqltable;
    private $fields = '*';
    private $where = "";
    private $args = [];
    private $sql = '';

    public static function table(string $table) {
        $query = new Query;
        $query->sqltable = $table;
        return $query;
    }

    public function where($col, $op, $val) {
        if(strlen($this->where) == 0){
            $this->where = " WHERE ".$col." ".$op. " ? ";
        } else {
            $this->where .= " AND ".$col." ".$op." ? ";
        }
        array_push($this->args, $val);
        return $this;
    }

    public function get() {
        $pdo = ConnectionFactory::getConnection();
        $this->sql = 'select '.$this->fields.' from '.$this->sqltable.$this->where;
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function select(array $fields) {
        $this->fields = implode(',', $fields);
        return $this;
    }

    public function delete() {
        $pdo = ConnectionFactory::getConnection();
        $this->sql = 'DELETE FROM '.$this->sqltable.$this->where;
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
    }

    public function insert(array $tab) {
        $pdo = ConnectionFactory::getConnection();
        $val = array();
        $i = 0;
        foreach($tab as $tab2) {
            $val[$i] = $tab2;
            $i++;
        }
        if($val[0]==null) {
            $this->sql='insert into '. $this->sqltable.' values (NULL';
        } else {
            $this->sql='insert into '. $this->sqltable.' values ('.$val[0];
        }
        for($j=1; $j < sizeof($val); $j++){
            if($val[$j]==null)
            $this->sql.=',NULL';
            else
            $this->sql.=',"'. $val[$j].'"';
        }
        $this->sql.=')';
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $pdo->lastInsertId();
    }

}