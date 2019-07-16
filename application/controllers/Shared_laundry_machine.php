<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shared_laundry_machine extends CI_controller
{
  
  public function index()
  {
    $this->load->view('shared_laundry_machine');
  }
}