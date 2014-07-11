<?php
require('dbconnection.php');
define('LOGNAME','access_log');
//create collection from the mongo shell
//db.createCollection('access_log',{capped:true,size:100000})
/**
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
        $request['page'] = $_SERVER['SCRIPT_NAME'];
        $request['viewed_at'] = new MongoDate($_SERVER['REQUEST_TIME']);
        $request['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        //split the query string and store HTTP
        //parameters/values in an array
        if (!empty($_SERVER['QUERY_STRING'])){
            $params = array();
            foreach ($explode('&',$_SERVER['QUERY_STRING']) as $parameter) {
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
