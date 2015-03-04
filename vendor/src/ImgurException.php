<?php
class ImgurException extends Exception {

  public function __construct($message, $code = 0) {
    parent::__construct($message, $code);
  }

  public function message() {
    return parent::getMessage();
  }

  public function code() {
    return parent::getCode();
  }
}