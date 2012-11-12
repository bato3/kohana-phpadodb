<?php defined('SYSPATH') or die('No direct access allowed.');

class Kohana_Database_Adodb	extends Database{
  
  protected $_adodb_path = NULL;
  
  
  
  protected function __construct($name, array $config){
    global $ADODB_COUNTRECS, $ADODB_CACHE_DIR, $ADODB_LANG, $ADODB_FETCH_MODE,
           $ADODB_FORCE_TYPE, $ADODB_ANSI_PADDING_OFF; 
    //define('ADODB_ASSOC_CASE',2);
    
    
    parent::__construct($name, $config);
    
    $this->_adodb_path = $config['libdir']?$config['libdir']
               :dirname(__FILE__).strtr('/../../../vendor/adodb5/','/',DIRECTORY_SEPARATOR);
    
               
    define('ADODB_ASSOC_CASE', Arr::get($config,'assoc_case',2));    
    include_once($this->_adodb_path.DIRECTORY_SEPARATOR.'adodb.inc.php');
    
    $ADODB_FETCH_MODE = Arr::get($config,'fetch_mode', 0);
    
    if(Arr::get($config,'use_active_record',FALSE)){
      include_once($this->_adodb_path.DIRECTORY_SEPARATOR.'adodb-active-record.inc.php');
      $this->connect();
      Activerecord::SetDatabaseAdapter($this->_connection);
    }
  }



  public function connect(){
    
    if ($this->_connection)
      if ($this->_connection->IsConnected())
        return;
    
    // Extract the connection parameters, adding required variabels
    extract($this->_config['connection'] + array(
        'database'   => '',
        'username'   => '',
        'password'   => '',
        'persistent' => FALSE,
    ));
    // Prevent this information from showing up in traces
    unset($this->_config['connection']['username'], $this->_config['connection']['password']);
 
    $this->_connection = ADONewConnection($dbdriver);
    
    $scheme = Arr::get( parse_url($dbdriver), 'scheme', FALSE);
    
    
    if($scheme === FALSE && empty($hostname) )
      throw new Database_Exception(':error',
            array(':error' => __('Not enought connect params')),
            E_USER_ERROR);
    
    if(!$persistent)
      $this->_connection->Connect($hostname, $username, $password, $database);
    else
      $this->_connection->PConnect($hostname, $username, $password, $database);
    
  }
  
  
  
  
  
  
  
  
  
  public function begin($mode = NULL){
    $this->_connection or $this->connect();
    
    if($mode)
      $this->_connection->SetTransactionMode($mode);
    
    return $this->_connection->BeginTrans();
  }
  
  
  public function commit(){
    $this->_connection or $this->connect();
    return $this->_connection->CommiTrans();
  }
  
  public function rollback(){
    $this->_connection or $this->connect();
    return $this->_connection->RollbackTrans();
  }
  
  
  public function escape($value){
    $this->_connection or $this->connect();
    return $this->_connection->Quote($value);
  }
  
  
  public function list_columns($table, $like = NULL, $add_prefix = FALSE){
    if($like !== NULL || $add_prefix !== FALSE)
      throw new Kohana_Exception('Database method :method is not full supported by :class',
        array(':method' => __FUNCTION__, ':class' => __CLASS__));
    
    $this->_connection or $this->connect();
    return $this->_connection->MetaColumns($table);
  }
  
  
  public function list_tables($like = NULL){
    if($like !== NULL)
      throw new Kohana_Exception('Database method :method is not full supported by :class',
        array(':method' => __FUNCTION__, ':class' => __CLASS__));
    
    $this->_connection or $this->connect();
    return $this->_connection->MetaTables();
  }
  
  public function set_charset($charset){
    throw new Kohana_Exception('Database method :method is not supported by :class',
        array(':method' => __FUNCTION__, ':class' => __CLASS__));
  }
  
  
  public function disconnect(){
    unset(Database::$instances[$this->_instance]);
 
    return TRUE;
  }
  
  
  
  
  
  
  
  
  
  public function __call($name, $arguments) {
    $this->_connection or $this->connect();
    $rm = new ReflectionMethod(get_class($this->_connection), $name);
    return $rm->invokeArgs($this->_connection, $arguments);
  }
  
  
  
  
  
  
  
  
  
  
  public function query($type, $sql, $as_object = FALSE, array $params = NULL){
    return $this->_connection->execute($sql);
  }
  
  
  
  
  
  
  /*
  protected $_prepare_sql = NULL;
  public function query($type, $sql, $as_object = FALSE, array $params = NULL){
    $db = clone $this;
    $db->_prepare_sql = $sql;
    return $db;
  }
  
  protected $_parameters = Array();
  public function param($param, $value){
    // Add or overload a new parameter
    $this->_parameters[$param] = $value;
 
    return $this;
  }
  
  public function bind($param, & $var){
    // Bind a value to a variable
    $this->_parameters[$param] =& $var;
 
    return $this;
 }
 
  public function parameters(array $params){
    // Merge the new parameters in
    $this->_parameters = $params + $this->_parameters;
 
    return $this;
  }
  
  
  
  
  public function compile(){
    // Import the SQL locally
    $sql = $this->_prepare_sql;
 
    if ( ! empty($this->_parameters))
    {
        // Quote all of the values
        $values = array_map(array($this, 'quote'), $this->_parameters);
 
        // Replace the values in the SQL
        $sql = strtr($sql, $values);
    }
 
    return $sql;
  }
  
  
  public function execute($sql = NULL,$inputarr=false){
    if($sql !== NULL)
      return $this->_connection->execute($sql, $inputarr); 
  
    $this->_connection or $this->connect();
    
    return $this->_connection->execute($this->compile());
  }
  */
  
}