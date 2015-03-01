<?php
class Request {
  /**
  * Function to make a GET request to the Imgur REST API.
  * @return object Object contains the response data from Imgur.
  */
  public function get($endpoint) {
    $session = new Session();

    $headers = array(
      'Authorization: Bearer ' . $session->getAccessToken(),
    );

    $ch = curl_init(Settings::getPublic('api_url') . $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response);
  }
}