<?php
  //Config
  $cfg = array(
    'errors'=>false,
    // General
    'root'=>__DIR__,
    'title'=>'Products Inc.',
    // Database
    'dbHostname'=>'localhost',
    'dbUser'=>'root',
    'dbPW'=>'',
    'dbName'=>'prodcat',
    'tablePrefix'=>'prodcat',
    'maxImageFilesize'=>4096,//in kb
    'subtitle'=>'wtf?',//Only shown if current module doesn't set a subtitle itself
    'keywords'=>array()//Current module should add to this list.
  );
?>