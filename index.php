<?php

require_once('./ConnectionFactory.php');
require_once('./Query.php');
require_once('./Model.php');
require_once('./Article.php');
require_once('./Categorie.php');

$conf = parse_ini_file('conf/conf.ini');
ConnectionFactory::makeConnection($conf);

/* Insère un article */
$article = new Article() ;
$article->nom = 'A12609' ;
$article->descr = 'beau velo de course
rouge' ;
$article->tarif = 59.95;
$article->id_categ = 1;

$article->insert();
/*Trouve avec l'id*/
//var_dump($article->find(66));
/*Trouve avec l'id et ne selectionne que les colonnes demandées*/
//var_dump($article->find(66, ['nom', 'descr']));
/*Trouve avec une condition*/
//var_dump($article->find(['tarif', '>', 66 ]));
/*Trouve par une condition et ne selectionne que les colonnes demandées*/
//var_dump($article->find(['tarif', '>', 66 ], ['nom', 'descr']));
/*Trouve avec plusieurs conditions et ne selectionne que les colonnes demandées*/
//var_dump($article->find([['nom','like','%velo%'],['tarif','<=',100]]));
/*Trouve avec une condition et ne selectionne que la première ligne*/
//var_dump($article->first(['tarif', '>', 0 ]));
