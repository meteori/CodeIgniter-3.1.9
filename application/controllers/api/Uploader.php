<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * 
 */
class Uploader extends REST_Controller
{
  
  function images_post()
  {
    $image_file = $_FILES['image_file'];

    if (!$image_file) {
      $this->response([
        'status' => FALSE,
        'message' => 'Missing parameters'
      ], REST_Controller::HTTP_BAD_REQUEST);
    }

    if ($image_file['error'] != 0) {
      $this->response([
        'status' => FALSE,
        'message' => 'File error'
      ], REST_Controller::HTTP_BAD_REQUEST);
    }

    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'gif|jpg|jpeg|png|pdf';
    // $config['max_size']             = 100;
    // $config['max_width']            = 1024;
    // $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('image_file'))
    {
      $error = array('error' => $this->upload->display_errors());

      $this->response([
        'status' => FALSE,
        'message' => $error
      ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
    else
    {
      // should also add database model record insertion here...
      // for example, you might want to link the image uploaded with one particular user, etc

      // $data = array('upload_data' => $this->upload->data());
      $this->response([
        'status' => TRUE,
        'message' => 'Image was uploaded successfully' // $data
      ], REST_Controller::HTTP_CREATED);
    }

    
  }
}