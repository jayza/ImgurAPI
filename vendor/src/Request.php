<?php
class Request {
  private $access_token;
  public $api_url = 'https://api.imgur.com/3/';

  function __construct($access_token) {
    $this->access_token = $access_token;
  }

  function get($endpoint) {
    $headers = array(
      'Authorization: Bearer ' . $this->access_token,
    );

    $ch = curl_init($this->api_url . $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response);
  }
}