<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

include_once 'aliyun-openapi-php-sdk-master/aliyun-php-sdk-core/Config.php';
use \Iot\Request\V20180120 as Iot;

/**
* Device API.
* @author Vim Ji <vim.jxl@gmail.com>
* Date Created: 2018-10-03
*/
class Device extends REST_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
  }

  private function send_message_by_iot($content, $devicename)
  {
    //设置你的AccessKeyId/AccessSecret/ProductKey
    $accessKeyId = $this->config->item('accessKeyId');
    $accessSecret = $this->config->item('accessSecret');
    $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
    $client = new DefaultAcsClient($iClientProfile);

    $request = new Iot\PubRequest();
    $request->setProductKey($this->config->item('ProductKey'));

    $request->setMessageContent(base64_encode(json_encode($content)));

    $request->setTopicFullName('/'.$this->config->item('ProductKey').'/'.$devicename.'/get'); //消息发送到的Topic全名.
    $response = $client->getAcsResponse($request);
    // print_r($response);
    return $response;
  }

  public function start_machine_post()
  {
    $wx_username = $this->post('wx_username');
    $duration = $this->post('duration');
    $devicename = $this->post('devicename');

    if (empty($wx_username) or empty($duration) or empty($devicename))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username,
        'duration' => $duration,
        'devicename' => $devicename
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    $content = [
      'cmd' => 'switch',
      'para' => [
        'action' => 'on',
        'time' => (int)$duration
      ]
    ];

    $response = $this->send_message_by_iot($content,$devicename);
    // print_r($response);

    $message = [
      'status' => '200',
      'wx_username' => $wx_username,
      'duration' => $duration,
      'message' => $response
    ];

    $this->set_response($message, $message['status']);

  }

  public function close_machine_post()
  {
    $wx_username = $this->post('wx_username');
    $devicename = $this->post('devicename');

    if (empty($wx_username) or empty($devicename))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username,
        'devicename' => $devicename
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    $content = [
      'cmd' => 'switch',
      'para' => [
        'action' => 'off'
      ]
    ];

    $response = $this->send_message_by_iot($content,$devicename);
    // print_r($response);

    $message = [
      'status' => '200',
      'wx_username' => $wx_username,
      'message' => $response
    ];

    $this->set_response($message, $message['status']);

  }

  public function ota_upgrade_post()
  {
    $wx_username = $this->post('wx_username');
    $firmware_name = $this->post('firmware_name');
    $devicename = $this->post('devicename');

    if (empty($wx_username) or empty($firmware_name) or empty($devicename))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username,
        'firmware_name' => $firmware_name,
        'devicename' => $devicename
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    $url = base_url()."api/Downloader/get_firmware?filename=".$firmware_name;

    $content = [
      'cmd' => 'ota',
      'para' => [
        'url' => $url
      ]
    ];

    $response = $this->send_message_by_iot($content,$devicename);
    // print_r($response);

    $message = [
      'status' => '200',
      'wx_username' => $wx_username,
      'firmware_name' => $firmware_name,
      'message' => $response
    ];

    $this->set_response($message, $message['status']);

  }

 public function check_machine_status_post()
  {
    $wx_username = $this->post('wx_username');
    $devicename = $this->post('devicename');

    if (empty($wx_username) or empty($devicename))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username,
        'devicename' => $devicename
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    $content = "Y2hlY2sgbWFjaGluZSBzdGF0dXM=";

    $response = $this->send_message_by_iot($content,$devicename);
    // print_r($response);

    $message = [
      'status' => '200',
      'wx_username' => $wx_username,
      'message' => $response
    ];

    $this->set_response($message, $message['status']);

  }

}
