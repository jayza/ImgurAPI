<?php

function __autoload($class) {
  require('src/' . $class . '.php');
}

?>