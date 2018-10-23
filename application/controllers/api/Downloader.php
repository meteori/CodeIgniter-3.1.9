<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


/**
* Auth API.
* @author Vim Ji <ctc_business@163.com>
* Date Created: 2018-10-20
*/
class Downloader extends REST_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
  	$this->load->helper('download');//加载插件
  }

  public function get_firmware_get()
  {
  	$filename = $this->get('filename');  

  	$fullpath = 'static/downloads/'.$filename;
  	// print_r(base_url().'static/downloads/Period_fail.mp4');
  	$data = file_get_contents(base_url().$fullpath);//打开文件读取其中的内容
  	force_download($filename,$data);//下载
  }

}