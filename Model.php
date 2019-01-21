<?php

require_once('./Query.php');

abstract class Model {
    
    private $tabArgs = [];

    public function __construct(array $tab) {
        $this->tabArgs = $tab;
    }

    public function __get($property) {
        $keys = array_keys($this->tabArgs);
        for($i=0; $i < sizeof($keys); $i++) {
            if ($keys[$i] == $property) {
                return $this->tabArgs[$keys[$i]];
            }
        }
        return $this->$property();
        throw new \Exception('Les paramètres sont invalides !');
    }

    public function __set($property, $value) {
        $keys = array_keys($this->tabArgs);
        $find = 'false';
        for($i=0; $i < sizeof($keys); $i++) {
            if ($keys[$i] == $property) {
                $this->tabArgs[$keys[$i]] = $value;
                $find = 'true';
            }
        }
        if ($find == 'false') {
            throw new \Exception('Les paramètres ou la valeur sont/est invalide(s) !');
        }
    }

    public function delete() {
        $query = Query::table($this->table);
        $query->where($this->primaryKey, '=', $this->tabArgs[$this->primaryKey]);
        $query->delete();
    }

    public function insert() {
        $query = Query::table($this->table);
        return  $query->insert($this->tabArgs);
    }

    public static function all() {
        $newclass = static::class;
        $table = new $newclass();
        $query = Query::table($table->table)->get();
        $tab=array();

        foreach($query as $raw){
            array_push($tab,new $newclass($raw));
        }

        return $tab;
    }

    public static function find($where, $select = NULL){
        $nbArgs=func_num_args();
        $newclass = static::class;
        $table = new $newclass();
        $query = Query::table($table->table);

        if(is_int($where)) {
            $query->where('id', '=', $where)->get();
        } elseif (isset($where[1]) 
                && (!(is_array($where[0])))
                && ($where[1] == "=" 
                || $where[1] == "<=" 
                || $where[1] == ">=" 
                || $where[1] == "<" 
                || $where[1] == ">" 
                || $where[1] == "like")) {
            $query->where($where[0],$where[1],$where[2]);
        } else {
            for($i=0; $i < count($where); $i++) {
                $query->where($where[$i][0],$where[$i][1],$where[$i][2]);
            }
        }
        if(isset($select)) {
            $query->select($select);
        }
        $query = $query->get();

        return $query;
    }

    public static function first($where, $select = NULL){
        $nbArgs=func_num_args();
        $newclass = static::class;
        $table = new $newclass();
        $query = Query::table($table->table);

        if(is_int($where)) {
            $query->where('id', '=', $where)->get();
        } elseif (isset($where[1]) 
                && (!(is_array($where[0])))
                && ($where[1] == "=" 
                || $where[1] == "<=" 
                || $where[1] == ">=" 
                || $where[1] == "<" 
                || $where[1] == ">" 
                || $where[1] == "like")) {
            $query->where($where[0],$where[1],$where[2]);
        } else {
            for($i=0; $i < count($where); $i++) {
                $query->where($where[$i][0],$where[$i][1],$where[$i][2]);
            }
        }
        if(isset($select)) {
            $query->select($select);
        }
        $query = $query->get();

        return $query[0];
    }

    public function belongs_to($table,$id){
        return $table::first($this->tabArgs[$id]);
    }

    public function has_many($table,$id){
        return $table::find([$id,"=",$this->tabArgs[$this->primaryKey]]);
    }
}