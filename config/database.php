<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'adodb' => array
	(
		'type'       => 'adodb',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname     server hostname, or socket
			 * string   database     database name
			 * string   username     database username
			 * string   password     database password
			 * boolean  persistent   use persistent connections?
			 * string   dbdriver     Adodb driver or DSN 
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => 'Provider=vfpoledb.1;Data Source=C:\p02_obce\roczne;Collating Sequence=Machine',
			'database'   => FALSE,
			'username'   => FALSE,
			'password'   => FALSE,
			'persistent' => FALSE,
			'dbdriver'   => 'ado',
		),
		'table_prefix' => '',
		'caching'      => FALSE,
		'profiling'    => TRUE,
		'libdir'       => FALSE,
		'assoc_case'   => 2,
		'use_active_record' => FALSE,
		'fetch_mode'   => 0,
	),
);