<?php
require('dbconnection.php');
require('dbconnection.php');
class User
{
    const COLLECTION = 'users';
    private $_mongo;
    private $_collection;
    private $_user;
    /**
     * __construct function
     *
     * @return void
     * @author yaowenqiang
     */
    public function __construct()
    {
        $this->_mongo = DBConnection::instantiate;
        $this->_collection = $this->_mongo->getCollection(User::COLLECTION);
        if ($this->isLoggedIn()) {
            $this->_loadData();
        }
    }
    /**
     * isloggedin function
     *
     * @return void
     * @author yaowenqiang
     */
    public function isLoggedIn()
    {
        return $_SESSION['user_id'];
    }

    /**
     * user authenticate function
     *
     * @return void
     * @author yaowenqiang
     */
    public function authenticate($username,$password)
    {
        $query = array(
            'username'=>$username,
            'password'=>$password
        );
        $this->_user->_collection->findOne($query);
        if (empty($this->_user)) {
            return false;
        }
        $_SESSION['user_id'] = (string) $this->_user['id'];
        return true;
    }
    /**
     * logout function
     *
     * @return void
     * @author yaowenqiang
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
    }
    /**
     * geet attr function
     *
     * @return void
     * @author yaowenqiang
     */
    public function _get($attr)
    {
        if (empty($this->_user)) {
            return null;
        }
        switch ($attr) {
            case 'address':
                $address = $this->_user['address'];
                return sprintf('Town: %s,Planet: %s',$address['town'],$address['planet']);
            case 'town':
                return $this->_user['address']['town'];
            case 'planet':
                return $this->_user['address']['planet'];
            case 'password':
                return NULL;
            default:
                return (isset($this->_user[$attr]))?
                    $this->_user[$attr]:NULL;
        }
    }
    /**
     * load data function
     *
     * @return void
     * @author yaowenqiang
     */
    private function _loadData()
    {
        $id = new MongoId($_SESSION['user_id']);
        $this->_user = $this->_collection->findOne(array('_id'=>$id));
    }

}

