<?php
class Authorize {
  private $client_id;
  private $client_secret;
  private $code;
  public $auth_url;
  public $token_url = 'https://api.imgur.com/oauth2/token';

  function __construct($client_id, $client_secret, $code) {
    $this->client_id = $client_id;
    $this->client_secret = $client_secret;
    $this->code = $code;

    $this->auth_url = 'https://api.imgur.com/oauth2/authorize?response_type=code&client_id=' . $this->client_id . '&state=authorizing';
  }

  function getToken($refresh_token = FALSE) {
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
        'grant_type' => 'authorization_code',
        'code' => $this->code,
      );
    }

    $ch = curl_init($this->token_url);

    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response);

    if ($response->access_token) {
      $session = new Session;
      $session->setSession('imgur_access_token', $response->access_token);
      $session->setSession('imgur_expires_in', $response->expires_in + time());

      if ($response->refresh_token) {
        $session->setSession('imgur_refresh_token', $response->refresh_token);
      }
    }

    return $response;
  }

  function checkAccess() {
    $session = new Session;
    // If time has expired then unset the access token session.
    if ($session->expired()) {
      unset($_SESSION['imgur_access_token']);
      // Automatic regeneration of access token
      if ($session->getRefreshToken()) {
        $refresh = $this->getToken($_SESSION['imgur_refresh_token']);
        if ($session) {
          $session->setSession('imgur_access_token', $refresh->access_token);
          $session->setSession('imgur_expires_in', $refresh->expires_in + time());
          $session->setSession('imgur_refresh_token', $refresh->refresh_token);
        }
      }
    }
    if ($session->ready()) {
      return true;
    }
    return false;
  }

}