<?php defined('SYSPATH') or die('No direct access allowed.');



class Kohana_Activerecord extends ADOdb_Active_Record{
  public static function factory($name, $pkeys = NULL){
    
     return new Activerecord($name, $pkeys);
  }
}