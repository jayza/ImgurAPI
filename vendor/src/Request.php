<?php
class Request {
  public $api_url = 'https://api.imgur.com/3/';

  function get($endpoint) {
    $session = new Session;

    $headers = array(
      'Authorization: Bearer ' . $session->getAccessToken(),
    );

    $ch = curl_init($this->api_url . $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response);
  }
}