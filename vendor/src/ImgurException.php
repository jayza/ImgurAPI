<?php
class ImgurException extends Exception {

  public function __construct($message, $code = 0) {
    parent::__construct($message, $code);
  }

  /**
  * Return the Exception class' message variable.
  * @return string 
  */
  public function message() {
    return parent::getMessage();
  }

  /**
  * Return the Exception class' message variable.
  * @return string 
  */
  public function code() {
    return parent::getCode();
  }
}