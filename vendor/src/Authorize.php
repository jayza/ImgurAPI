<?php
class Authorize {
  /**
  * @var string $client_id Contains the client id that has been given from registering an application on Imgur.
  * @var string $client_secret Contains the client secret that has been given from registering an application on Imgur.
  * @var string|false $code Should contain an authorization code which is given from Imgur when logging in otherwise FALSE.
  * @var string $code_type Contains the code type, either code or pin.
  */
  private $client_id;
  private $client_secret;
  private $code;
  private $code_type;

  public function __construct() {
    $this->client_id = Settings::getCredential('client_id');
    $this->client_secret = Settings::getCredential('client_secret');
    $this->code = (isset($_GET['code']) && isset($_GET['state']) && $_GET['state'] == Settings::getPublic('auth_state')) 
      ? $_GET['code'] : FALSE;

    if ($this->code) {

      if (Settings::getCredential('grant_type') == 'authorization_code') {
        $this->code_type = 'code';
      } elseif (Settings::getCredential('grant_type') == 'pin') {
        $this->code_type = 'pin';
      } 

      $this->getToken();
    } 
  }

  /**
  * Function to retrieve an access token after being given either an authorization code or refresh token.
  * @return object Object contains access token, refresh token and expiration time.
  */
  public function getToken($refresh_token = FALSE) {
    if ($refresh_token) {
      $data = array(
        'refresh_token' => $refresh_token,
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
        'grant_type' => 'refresh_token',
      );
    } else {
      $data = array(
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
        'grant_type' => Settings::getCredential('grant_type'),
        $this->code_type => $this->code,
      );
    }

    $ch = curl_init(Settings::getPublic('token_url'));

    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response);

    if ($response->access_token) {
      $session = new Session();
      $session->setSession('imgur_access_token', $response->access_token);
      $session->setSession('imgur_expires_in', $response->expires_in + time());

      if ($response->refresh_token) {
        $session->setSession('imgur_refresh_token', $response->refresh_token);
      }
    }

    return $response;
  }

  /**
  * Function to make a check if time has expired, 
  * if this is true then it checks for a refresh token and tries to fetch a new access token.
  * @return bool Returns TRUE if the access token is set, otherwise FALSE.
  */
  public function checkAccess() {
    $session = new Session();
    
    if ($session->expired()) {
      unset($_SESSION['imgur_access_token']);
      unset($_SESSION['imgur_expires_in']);
      
      if ($session->getRefreshToken()) {
        $refresh = $this->getToken($_SESSION['imgur_refresh_token']);
        if ($refresh->access_token) {
          $session->setSession('imgur_access_token', $refresh->access_token);
          $session->setSession('imgur_expires_in', $refresh->expires_in + time());
          $session->setSession('imgur_refresh_token', $refresh->refresh_token);
        }
      }
    }
    if ($session->getAccessToken()) {
      return TRUE;
    }
    return FALSE;
  }

}