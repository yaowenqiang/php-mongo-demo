<?php
/**
 * mongodb connection /**
  *
  */
 class DBConnection
 {

     const HOST     = 'localhost';
     const PORT     = 27017;
     const DBNAME   = 'myblogsite';
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
