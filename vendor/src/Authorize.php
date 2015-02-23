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

    return json_decode($response);
  }

  function checkAccess() {
    // If time has expired then unset the access token session.
    if (isset($_SESSION['imgur_expires_in']) && isset($_SESSION['imgur_access_token']) && $_SESSION['imgur_expires_in'] <= time()) {
      unset($_SESSION['imgur_access_token']);
    }
    if (isset($_SESSION['imgur_access_token'])) {
      return true;
    }
    return false;
  }

}