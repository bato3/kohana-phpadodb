<?php defined('SYSPATH') or die('No direct script access.');


if (!defined('ADODB_ERROR_HANDLER_TYPE'))  
  define('ADODB_ERROR_HANDLER_TYPE',E_USER_ERROR); 
define('ADODB_ERROR_HANDLER','adodb_throw');






/**
* Default Error Handler. This will be called with the following params
*
* @param $dbms		the RDBMS you are connecting to
* @param $fn	  	the name of the calling function (in uppercase)
* @param $errno		the native error number from the database
* @param $errmsg	the native error msg from the database
* @param $p1		$fn specific parameter - see below
* @param $p2		$fn specific parameter - see below
*/

function adodb_throw($dbms, $fn, $errno, $errmsg, $p1, $p2, $thisConnection){
  
  $params = Array();
  //$params['']
  switch($fn) {
		case 'EXECUTE':
			$params['sql'] = $p1;
			$params['params'] = $p2;
			$s = "$dbms error: [$errno: $errmsg] in $fn(\"$p1\")\n";
			break;
	
		case 'PCONNECT':
		case 'CONNECT':
			$params['user'] = $thisConnection->user;
			$s = "$dbms error: [$errno: $errmsg] in $fn($p1, '$user', '****', $p2)\n";
			break;
		default:
			$s = "$dbms error: [$errno: $errmsg] in $fn($p1, $p2)\n";
			break;
		}
	
		$params['dbms'] = $dbms;
		if ($thisConnection) {
			$params['host'] = $thisConnection->host;
			$params['database'] = $thisConnection->database;
		}
		$params['fn'] = $fn;
		$params['msg'] = $errmsg;
  
	if (!is_numeric($errno)) $errno = E_USER_ERROR;
	
	
  throw new Database_Exception($s,
            $params,
            $errno);
  //global $ADODB_EXCEPTION;
	/*
	if (error_reporting() == 0) return; // obey @ protocol
	if (is_string($ADODB_EXCEPTION)) $errfn = $ADODB_EXCEPTION;
	else $errfn = 'ADODB_EXCEPTION';
	throw new $errfn($dbms, $fn, $errno, $errmsg, $p1, $p2, $thisConnection);
	*/
}
