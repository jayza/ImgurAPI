<?php
class Request {
  /**
  * @var string $access_token The access token that is given from the Session class
  */
  private $access_token;

  public function __construct() {
    $session = new Session();
    $this->access_token = $session->getAccessToken();
  }

  /**
  * Function to make a GET request to the Imgur REST API.
  * @param string $endpoint API Endpoint from the Imgur API.
  * @return object Object contains the response data from Imgur (see Imgur Developer Documentation).
  */
  public function get($endpoint) {
    $headers = array(
      'Authorization: Bearer ' . $this->access_token,
    );

    $ch = curl_init(Settings::getPublic('api_url') . $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    if (!$response->success) {
      throw new ImgurException($response->data->error, $response->status);
    }

    return $response;
  }

  /**
  * Function to make a POST request to the Imgur REST API.
  * @param string $endpoint API Endpoint from the Imgur API.
  * @param array $data Array of data to send in the POST request.
  * @return object Object contains the response data from Imgur (see Imgur Developer Documentation).
  */
  public function post($endpoint, $data) {
    $headers = array(
      'Authorization: Bearer ' . $this->access_token,
    );

    $ch = curl_init(Settings::getPublic('api_url') . $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    if (!$response->success) {
      throw new ImgurException($response->data->error, $response->status);
    }

    return $response;
  }

  /**
  * Function to make a PUT request to the Imgur REST API.
  * @param string $endpoint API Endpoint from the Imgur API.
  * @param array $data Array of data to send in the PUT request.
  * @return object Object contains the response data from Imgur (see Imgur Developer Documentation).
  */
  public function put($endpoint, $data) {
    $headers = array(
      'Authorization: Bearer ' . $this->access_token,
    );

    $ch = curl_init(Settings::getPublic('api_url') . $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    if (!$response->success) {
      throw new ImgurException($response->data->error, $response->status);
    }

    return $response;
  }

  /**
  * Function to make a DELETE request to the Imgur REST API.
  * @param string $endpoint API Endpoint from the Imgur API.
  * @return object Object contains the response data from Imgur (see Imgur Developer Documentation).
  */
  public function delete($endpoint) {
    $headers = array(
      'Authorization: Bearer ' . $this->access_token,
    );

    $ch = curl_init(Settings::getPublic('api_url') . $endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    if (!$response->success) {
      throw new ImgurException($response->data->error, $response->status);
    }

    return $response;
  }
}