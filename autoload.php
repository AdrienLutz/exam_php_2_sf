<?php
spl_autoload_register(function ($class_name) {


    if(str_ends_with($class_name, 'Controller')){
        require 'Controller/'.$class_name.".php";
    } else if(str_ends_with($class_name, "Manager")){
        require 'Model/Manager/'.$class_name.'.php';
    } else {
        require 'Model/Class/'.$class_name.'.php';
    }

});
 require "vendor/autoload.php";
?>
