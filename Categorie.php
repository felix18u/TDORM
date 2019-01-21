<?php

class Categorie extends Model {

    public $table = 'Categorie';
    public $primaryKey = 'id';

    public function __construct($tab = ['id' => null, 'nom'=> null, 'descr' => null]) {
        parent::__construct($tab);
    }

    public function articles(){
        return $this->has_many("Article","id_categ");
    }
}