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
* @author Vim Ji <ctc_business@163.com>
* Date Created: 2018-10-03
*/
class device extends REST_Controller {

  function __construct()
  {
    parent::__construct();

    // $this->load->model(array('tank_auth/users', 'locations_model', 'incentive_program_model', 'card_balance', 'user_tokens', 'user_mobile_account', 'variables'));
    // $this->load->model(array('user_third','referral_program_model','user_profiles'));
    // $this->load->library('tank_auth');
    // $this->lang->load('tank_auth');
  }

  public function start_machine_post()
  {
    $wx_username = $this->post('wx_username');
    $duration = $this->post('duration');

    //设置你的AccessKeyId/AccessSecret/ProductKey
    $accessKeyId = "LTAIwOrIrQK8GLc2";
    $accessSecret = "kQ07a09Bm72qgAfLivTlxXhGfv2JDC";
    $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
    $client = new DefaultAcsClient($iClientProfile);

    $request = new Iot\PubRequest();
    $request->setProductKey("a1dSHKlSbBX");
    // $request->setMessageContent("SGVsbG8lMkMlMjBMaW5jb2xuLg=="); //hello world Base64 String.
    $request->setMessageContent(base64_encode("hello world 1")); //hello world Base64 String.
    $request->setTopicFullName("/a1dSHKlSbBX/test/get"); //消息发送到的Topic全名.
    $response = $client->getAcsResponse($request);
    // print_r($response);

    $message = [
      'status' => '200',
      'message' => $response
    ];

    $this->set_response($message, $message['status']);

  }


}
