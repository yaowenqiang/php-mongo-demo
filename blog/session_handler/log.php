<?php
require('dbconnection.php');
define('LOGNAME','access_log');
//create collection from the mongo shell
//db.createCollection('access_log',{capped:true,size:100000})
////max means the maximum rows can be stored  in the collection
//db.createCollection('access_log',{capped:true,size:100000,max:100})
//if the collection size is larger then 100000 bytes,the oldest documents will be deleted
//in a capped collection,the order of the documents is natural,this means the record will be returned in the inserting order,oldest first,but can be reversed using sort({$nature:-1})
//we can't delete documents from a capped collection, but can drop the collection
//Specifying the size of a regular collection
//db.createcollection('nocapped_coll',{size:10000})
/**
 * convert a regular collection to a capped one
 * db.runCommand({'convertToCapped':'regular_coll',size:100000})
 * the logger /**
  *
  */
 class Logger
 {

     /**
      *
      */
    private $_dbconnection;
    private $_db;
    public  function __construct()
    {
        $this->_dbconnection = DBConnection::instantiate();
        //obtain a reference to the collection where the data
        //will be logged
        $this->_collection = $this->_dbconnection->getCollection(LOGNAME);
    }
    public function logRequest($data = array())
    {
        $request = array();
        //obtain HTTP request information by ACCESSING $_SERVER
        $request['page'] = $_SERVER['SCRIPT_NAME'];
        $request['viewed_at'] = new MongoDate($_SERVER['REQUEST_TIME']);
        $request['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $request['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        //split the query string and store HTTP
        //parameters/values in an array
        if (!empty($_SERVER['QUERY_STRING'])){
            $params = array();
            foreach (explode('&',$_SERVER['QUERY_STRING']) as $parameter) {
                list($key,$value) = explode('=',$parameter);
                $params[$key] = $value;
            }
        }
        $request['query_params'] = $params;
        //add additional log data,if any
        if (!empty($data)) {
            $request = array_merge($request,$data);
        }
        $this->_collection->insert($request);

    }
 }
