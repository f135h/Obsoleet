<?php

spl_autoload_register(function ($class) {
    require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class . '.php'));
});