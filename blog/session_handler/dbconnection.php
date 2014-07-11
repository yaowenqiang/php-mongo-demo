<?php
/**
 * mongodb connection /**
  *
  */
 class DBConnection
 {

     const HOST     = '127.0.0.1';
     const PORT     = 27017;
     /*const DBNAME   = 'myblogsite';*/
     const DBNAME   = 'acmeproducts_mongo';
     private static $instance;
     public $connection;
     public $database;
     /**
      * __construct
      */
     private function __construct()
     {
         $connectionString = sprintf('mongodb://%s:%d',
             DBConnection::HOST,
             DBConnection::PORT
         );
         try {
             $this->connection = new MongoClient($connectionString);
             $this->database = $this->connection->selectDB(DBConnection::DBNAME);
         } catch (MongoConnectionException  $e) {
                die("Failed to connect to database ").$e->getMessage();
         }
     }
    /**
     * instantiate function
     * @return void
     * @author Steve Francia <steve.francia@gmail.com>
     */
    static public function instantiate()
    {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }
    /**
     * get collection
     *
     * @return void
     */
    public function getCollection($name)
    {
        return $this->database->selectCollection($name);
    }
 }
