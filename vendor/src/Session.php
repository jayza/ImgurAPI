<?php
class Session {
  /**
  * @var string|false $access_token Should contain a access token or FALSE otherwise.
  * @var string|false $refresh_token Should contain a refresh token or FALSE otherwise.
  * @var int|false $expires_in Should contain a UNIX Timestamp integer or FALSE otherwise.
  */
  private $access_token;
  private $refresh_token;
  private $expires_in;
  
  public function __construct() {
    $this->access_token = isset($_SESSION['imgur_access_token']) ? $_SESSION['imgur_access_token'] : FALSE;
    $this->refresh_token = isset($_SESSION['imgur_refresh_token']) ? $_SESSION['imgur_refresh_token'] : FALSE;
    $this->expires_in = isset($_SESSION['imgur_expires_in']) ? $_SESSION['imgur_expires_in'] : FALSE;;
  }

  /**
  * Function to get access token.
  * @return string|false Depending if the access token is saved in session
  */
  public function getAccessToken() {
    return isset($this->access_token) ? $this->access_token : FALSE;
  }

  /**
  * Function to get refresh token.
  * @return string|false Depending if the refresh token is saved in session
  */
  public function getRefreshToken() {
    return isset($this->refresh_token) ? $this->refresh_token : FALSE;
  }

  /**
  * Function to determine whether or not the access token time has expired.
  * @return bool TRUE if expired and FALSE otherwise
  */
  public function expired() {
    return ($this->expires_in <= time()) ? TRUE : FALSE;
  }

  /**
  * Function to set a session.
  * @return void
  */
  public function setSession($name, $value) {
    $_SESSION[$name] = $value;
  }
}