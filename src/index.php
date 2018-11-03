<?php

$class_name = 'WebSrvReceiver';
spl_autoload_register(function ($class_name) {

    include $class_name . '.php';
});
$class_name= new WebSrvReceiver();
