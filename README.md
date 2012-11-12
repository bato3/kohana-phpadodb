kohana-phpadodb
===============

Wrapper for PHP AdoDB: http://adodb.sourceforge.net



Instalation
===========

Put adodb libary to `vendor/adodb5` direcory or set $config['libdir']


Usage
=====

It is mix required methots from `Database` class and native PHPAdoDB class.  :)


Configuration
-------------
config/database.php Part
```php
'instancename' => array
	(
		'type'       => 'adodb',
		'connection' => array(
			/**
			 * The following options are available for Php AdoDB:
			 *
			 * string   dbdriver     Adodb driver name or DSN
			 * string   hostname     server hostname
			 * string   database     database name
			 * string   username     database username
			 * string   password     database password
			 * boolean  persistent   use persistent connections? 
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'dbdriver'   => 'ado',
			'hostname'   => '',
			'database'   => FALSE,
			'username'   => FALSE,
			'password'   => FALSE,
			'persistent' => FALSE,
		),
		'caching'      => FALSE,
		'profiling'    => TRUE,
		'libdir'       => FALSE,
		/**
		 * ADODB_ASSOC_CASE
		 * You can control the associative fetch case for certain drivers which behave differently.
		 * 
		 * 0 = assoc lowercase field names. $rs->fields['orderid']
		 * 1 = assoc uppercase field names. $rs->fields['ORDERID']
		 * 2 = use native-case field names. $rs->fields['OrderID'] -- this is the default since ADOdb 2.90
		 */
		'assoc_case'   => 2,
		/**
		  * $ADODB_FETCH_MODE
		  * We don't have defined const :(
		  * define('ADODB_FETCH_DEFAULT',0);
		  * define('ADODB_FETCH_NUM',1);
		  * define('ADODB_FETCH_ASSOC',2);
		  * define('ADODB_FETCH_BOTH',3);
		  */
		'fetch_mode'   => 0,
	),
```


Usage
-----
Adodb like usage:
```php
$db = Database::instance('instancename');
$rs = $db->Execute($sql);
```


Kohana like usage:
```php
$rs = DB:query('foo :)', $sql)->param(':param','value')->execute('instancename');
```

TODO
====
Imlement in `ADORecordSet $rs` `Database_Result` funcionality, first ::as_array()
(ArrayAccess | SeekableIterator | Traversable | Iterator | Countable)

