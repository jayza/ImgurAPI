<?php
class Session {
  private $access_token = FALSE;
  private $refresh_token = FALSE;
  private $expires_in = FALSE;
  
  function __construct() {
    if ($_SESSION['imgur_access_token']) {
      $this->access_token = $_SESSION['imgur_access_token'];
    }
    if ($_SESSION['imgur_refresh_token']) {
      $this->refresh_token = $_SESSION['imgur_refresh_token'];
    }
    if ($_SESSION['imgur_expires_in']) {
      $this->expires_in = $_SESSION['imgur_expires_in'];
    }
  }

  function getAccessToken() {
    if ($this->access_token) {
      return $this->access_token;
    }
    return FALSE;
  }

  function getRefreshToken() {
    if($this->refresh_token) {
      return $this->refresh_token;
    }
    return FALSE;
  }

  function ready() {
    if ($this->access_token) {
      return TRUE;
    }
    return FALSE;
  }

  function expired() {
    if ($this->expires_in <= time()) {
      return TRUE;
    }
    return FALSE;
  }

  function setSession($name, $value) {
    $_SESSION[$name] = $value;
  }
}