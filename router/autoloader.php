,<?php
/**
 * Autoloader for classes.
 *
 * @param string $class the name of the class.
 */
 spl_autoload_register(function ($class) {
     $path = "{$class}.php";
    if (is_file($path)) {
        include($path);
    };
 });

//
// spl_autoload_register(function ($class_name) {
//     include $class_name . '.php';
// });
