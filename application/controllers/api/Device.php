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
* Auth API.
* @author Vim Ji <vim.jxl@gmail.com>
* Date Created: 2018-10-03
*/
class Device extends REST_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
    // $this->load->model(array('tank_auth/users', 'locations_model', 'incentive_program_model', 'card_balance', 'user_tokens', 'user_mobile_account', 'variables'));
    // $this->load->model(array('user_third','referral_program_model','user_profiles'));
    // $this->load->library('tank_auth');
    // $this->lang->load('tank_auth');
  }

  public function start_machine_post()
  {
    $wx_username = $this->post('wx_username');
    $duration = $this->post('duration');

    if (empty($wx_username) or empty($duration))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username,
        'duration' => $duration
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    //设置你的AccessKeyId/AccessSecret/ProductKey
    $accessKeyId = "LTAIwOrIrQK8GLc2";
    $accessSecret = "kQ07a09Bm72qgAfLivTlxXhGfv2JDC";
    $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
    $client = new DefaultAcsClient($iClientProfile);

    $request = new Iot\PubRequest();
    $request->setProductKey("a1dSHKlSbBX");


    $content = [
      'cmd' => 'switch',
      'para' => [
        'action' => 'on',
        'time' => (int)$duration
      ]
    ];

    $request->setMessageContent(base64_encode(json_encode($content)));

    $request->setTopicFullName("/a1dSHKlSbBX/test/get"); //消息发送到的Topic全名.
    $response = $client->getAcsResponse($request);
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
    if (empty($wx_username))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    //设置你的AccessKeyId/AccessSecret/ProductKey
    $accessKeyId = "LTAIwOrIrQK8GLc2";
    $accessSecret = "kQ07a09Bm72qgAfLivTlxXhGfv2JDC";
    $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
    $client = new DefaultAcsClient($iClientProfile);

    $request = new Iot\PubRequest();
    $request->setProductKey("a1dSHKlSbBX");

    $content = [
      'cmd' => 'switch',
      'para' => [
        'action' => 'off'
      ]
    ];

    $request->setMessageContent(base64_encode(json_encode($content)));

    $request->setTopicFullName("/a1dSHKlSbBX/test/get"); //消息发送到的Topic全名.
    $response = $client->getAcsResponse($request);
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
    if (empty($wx_username) or empty($firmware_name))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username,
        'firmware_name' => $firmware_name
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    //设置你的AccessKeyId/AccessSecret/ProductKey
    $accessKeyId = "LTAIwOrIrQK8GLc2";
    $accessSecret = "kQ07a09Bm72qgAfLivTlxXhGfv2JDC";
    $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
    $client = new DefaultAcsClient($iClientProfile);

    $request = new Iot\PubRequest();
    $request->setProductKey("a1dSHKlSbBX");

    $url = base_url()."api/Downloader/get_firmware?filename=".$firmware_name;
    $content = [
      'cmd' => 'ota',
      'para' => [
        'url' => $url
      ]
    ];

    $request->setMessageContent(base64_encode(json_encode($content)));

    $request->setTopicFullName("/a1dSHKlSbBX/test/get"); //消息发送到的Topic全名.
    $response = $client->getAcsResponse($request);
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
    if (empty($wx_username))
    {
      $message = [
        'status' => '201',
        'wx_username' => $wx_username
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    //设置你的AccessKeyId/AccessSecret/ProductKey
    $accessKeyId = "LTAIwOrIrQK8GLc2";
    $accessSecret = "kQ07a09Bm72qgAfLivTlxXhGfv2JDC";
    $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
    $client = new DefaultAcsClient($iClientProfile);

    $request = new Iot\PubRequest();
    $request->setProductKey("a1dSHKlSbBX");
  
    $request->setMessageContent("Y2hlY2sgbWFjaGluZSBzdGF0dXM=");  //check machine status

    $request->setTopicFullName("/a1dSHKlSbBX/test/get"); //消息发送到的Topic全名.
    $response = $client->getAcsResponse($request);
    // print_r($response);

    $message = [
      'status' => '200',
      'wx_username' => $wx_username,
      'message' => $response
    ];

    $this->set_response($message, $message['status']);

  }
}
