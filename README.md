# ORM

Membres du projet :
- FELIX Paul
- WIRTZ Thibault
- DUBOUIS Hugo
- MARLY Yanis

# Prérequis 

Un serveur (wamp par exemple) avec :
* Apache
* PHP
* MYSQL

# Pour tester le tp

* Cloner ce dépôt
* Verifier le fichier conf.ini dans le dossier conf pour qu'il correspondent a votre serveur sql
* Créer une base de données ayant comme titre : tdorm
* Insérer le fichier sql : article.sql
* Si vous lancer le fichier index.php dans votre navigateur, un article sera ajouté dans la base de données
* Vous pouvez modifier le fichier index.php pour changer l'action souhaitée

# Classes et méthodes

## ConnectionFactory
Permet de gerer la connexion à la table
* makeConnection(array $tab) : Créer la connexion
* getConnection(): Retourne la connexion

## Query
Permet de créer des requêtes SQL
* table(string $table) : Crée un objet Query. Retourne lui même
* where(string $col, string $op, mixed $val) : Crée une condition WHERE. $op ne peut que être ces signes suivant : =, >, <, =>, <=, like. Retourne un objet Query
* select(array $fields) : Crée une condition SELECT. Retourne un objet Query
* insert(array $tab) : Insére une donnée dans la table. Retourne l'id de la ligne créer
* get() : Execute la commande sql préparée. Retourne un tableau
* delete() : Execute la commande DELETE selon la condition WHERE.

## Article
Crée un article. Il hérite des méthodes de Model
* cateorie() : Retourne la catégorie de l'article

## Categorie
Crée une catégorie. Il hérite des méthodes de Model
* articles() : Retourne les articles qui sont de cet catégorie

## Model
* __get() : Getter de Model
* __set() : Setter de Model
* delete() : Supprime cet objet de la table
* insert() : Insére cet objet dans la table.
* all() : Retourne toute la table
* find(mixed $where, [array $select = NULL]) : Retourne une ou plusieurs lignes du résultat
* first(mixed $where, [array $select = NULL]) : Retourne la premiére ligne du résultat
* belongs_to(Model $table, int $id) : Permet de suivre une association de 
multiplicité 1
* has_many(Model $table, int $id) : Permet de suivre une association de 
multiplicité n 
