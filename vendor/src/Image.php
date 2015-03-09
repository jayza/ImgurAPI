<?php
class Image {
  /**
  * @var object $request Contains an instance of the Request class.
  */
  private $request;

  public function __construct() {
    $this->request = new Request();
  }

  /**
  * Find an image by its id.
  * @param string $id The id of the image.
  * @return Request object
  */
  public function find($id) {
    return $this->request->get('image/' . $id);
  }

  /**
  * Upload an image either by using base64 or by uploading via a form.
  * @param mixed[] $image Array that contains the appropriate data for uploading an image.
  * @param string $type The type of the image that is being uploaded.
  * @return Request object
  */
  public function upload($image, $type = 'file') {
    $tmp_image = ($type == 'file') ? $image['tmp_name'] : $image['image'];

    if (getimagesize($tmp_image) && filesize($tmp_image) <= 10000000) {
      $image['image'] = file_get_contents($tmp_image);

      if ($type == 'base64') {
        $image['image'] = base64_encode($image['image']);
      }

      $data = array(
        'image' => $image['image'],
        'type' => $type,
      );

      if (!empty($image['title'])) {
        $data['title'] = $image['title'];
      }
      if (!empty($image['description'])) {
        $data['description'] = $image['description'];
      }
      if (!empty($image['album'])) {
        $data['album'] = $image['album'];
      }

      return $this->request->post('image', $data);
    }
    
    throw new ImgurException('File needs to be an image and not exceed the size limit of 10MB.');
    return;
  }

  /**
  * Delete an image by id.
  * @param string $id The id of the image to delete.
  * @return Request object 
  */
  public function delete($id) {
    return $this->request->delete('image/' . $id);
  }

  /**
  * Edit the title and/or description of an image.
  * @param string $id The id of the image to edit.
  * @param array $data Array containing title and description
  * @return Request object
  */
  public function edit($id, $data) {
    return $this->request->put('image/' . $id, $data);
  }

  /**
  * Favorite an image
  * @param string $id The id of the image to favorite.
  * @return Request object
  */
  public function favorite($id) {
    return $this->request->post('image/' . $id . '/favorite');
  }

  /**
  * Publish image to Imgur.
  * @param strind $id The id of the image to publish.
  * @return Request object
  */
  public function publish($id, $data = array()) {
    if (empty($data['title'])) {
      $data['title'] = $this->find($id)->output()->title;
    }

    return $this->request->post('gallery/image/' . $id, $data);
  }

  /**
  * Unpublish image to Imgur.
  * @param strind $id The id of the image to publish.
  * @return Request object
  */
  public function unpublish($id) {
    return $this->request->delete('gallery/' . $id);
  }
}