<?php
class Settings {
  /**
  * @var array Array containing secret credentials.
  * @var array Array containing public variables and settings.
  */
  private static $credentials = array();
  private static $public = array();

  /**
  * Function to set a credential.
  * @return void
  */
  public static function setCredential($key, $value) {
    self::$credentials[$key] = $value;
  }

  /**
  * Function to set a public variable.
  * @return void
  */
  public static function setPublic($key, $value) {
    self::$public[$key] = $value;
  }

  /**
  * Function to set a credential.
  * @return mixed|false Returns content of credential.
  */
  public static function getCredential($key) {
    return isset(self::$credentials[$key]) ? self::$credentials[$key] : FALSE;
  }

  /**
  * Function to set a credential.
  * @return mixed|false Returns content of public variable.
  */
  public static function getPublic($key) {
    return isset(self::$public[$key]) ? self::$public[$key] : FALSE;
  }

}