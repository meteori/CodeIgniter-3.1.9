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
* @author Vim Ji <vim.jxl@gmail.com>
* Date Created: 2018-11-03
*/
class Picshow extends REST_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
  	$this->load->helper('download');//加载插件
    $this->load->model('XXXProducts');
  }

  public function get_products_detail_get()
  {
    $type = $this->get('type');   //new, necklace, earrings, rings
    $dir = './static/images/xxxshow/'.$type;
    $datas = array();
    // $files = array();
    if(@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
      while(($file = readdir($handle)) != false) {
          if($file != ".." && $file != ".") { //排除根目录；
              if(is_dir($dir."/".$file)) { //如果是子文件夹，就跳过
                  // $files[$file] = my_dir($dir."/".$file);
                continue;
              } else { //不然就将文件的名字存入数组；
                  // $files[] = $file;
                  //prepare data;
                  $product = $this->XXXProducts->get_products_by_filename($file);
                  if($product == NULL)
                    continue;

                  $image = base_url().'static/images/xxxshow/'.$type.'/'.$file;
                  $picUrl = base_url().'static/images/xxxshow/bg/'.$product->bg_image;
                  $data = [
                    "name"=> $product->title, 
                    "desc"=> $product->desc, 
                    "picUrl"=> $picUrl, 
                    "image"=> $image, 
                    "jumpType"=> "subjectPage", 
                    "subjectId"=> 0, 
                    "playUrl"=> $product->playurl, 
                    "icon"=> "", 
                    "tag"=> "", 
                    "videoId"=> 0, 
                    "hotDegree"=> "", 
                    "hotType"=> "", 
                    "playTimeIconUrl"=> "", 
                    "webUrl"=> "", 
                    "splitItem"=> "", 
                    "canShare"=> 0, 
                    "ext"=> 0, 
                    "libId"=> 0, 
                    "activityId"=> 0, 
                    "isFavorite"=> 0, 
                    "admireCount"=> 0
                  ];
                  $datas[] = $data;
              }

          }
      }
      closedir($handle);
      // return $files;
    }

    $message = [
      'err_code' => 200,
      'status' => -1,
      'code' => 200,
      'msg' => '',
      'err_msg' => '',
      'data' => $datas
    ];

    $this->set_response($message, $message['code']);

  }

  public function upload_product_post()
  {


  }

}