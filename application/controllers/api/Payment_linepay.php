<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

require 'vendor/autoload.php';

use yidas\linePay\Client;

/**
* Payment_wx API.
* @author Vim Ji <vim.jxl@gmail.com>
* Date Created: 2019-09-28
*/
class Payment_linepay extends REST_Controller {

  function __construct()
  {
    parent::__construct();
  }

  public function test_guzzle_post()
  {
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

    echo $response->getStatusCode(); # 200
    echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
    echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'

    # Send an asynchronous request.
    $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
    $promise = $client->sendAsync($request)->then(function ($response) {
      echo 'I completed! ' . $response->getBody();
    });

    $promise->wait();
  }

  public function demo_line_pay_sdk_post()
  {
    // Create LINE Pay client
    $linePay = new \yidas\linePay\Client([
        'channelId' => '123456',
        'channelSecret' => '123456',
        'isSandbox' => true, 
    ]);

    // Online Request API
    $response = $linePay->request([
        'amount' => 250,
        'currency' => 'TWD',
        'orderId' => 'Your order ID',
        'packages' => [
            [
                'id' => 'Your package ID',
                'amount' => 250,
                'name' => 'Your package name',
                'products' => [
                    [
                        'name' => 'Your product name',
                        'quantity' => 1,
                        'price' => 250,
                        'imageUrl' => 'https://yourname.com/assets/img/product.png',
                    ],
                ],
            ],
        ],
        'redirectUrls' => [
            'confirmUrl' => 'https://yourname.com/line-pay/confirm',
            'cancelUrl' => 'https://yourname.com/line-pay/cancel',
        ],
    ]);

    // Check Request API result (returnCode "0000" check method)
    if (!$response->isSuccessful()) {
        throw new Exception("ErrorCode {$response['returnCode']}: {$response['returnMessage']}");
    }

    // Redirect to LINE Pay payment URL 
    header('Location: '. $response->getPaymentUrl() );
  }

  public function request_post()
  {
    
    $input['isSandbox'] = true;
    $input['channelId'] = '123456';
    $input['channelSecret'] = '123456';
    $input['merchantDeviceProfileId'] = '';
    $input['amount'] = '1';
    $input['currency'] = 'TWD';
    $input['orderId'] = "SN" . date("YmdHis") . (string) substr(round(microtime(true) * 1000), -3);
    $input['productName'] = 'eq-link';
    $input['imageUrl'] = '';
    $input['captureFalse'] = '';
    $input['preapproved'] = true;
    $input['branchName'] = '';
    $input['confirmUrlType'] = '';
    $input['locale'] = '';
    $input['paymenUrlApp'] = '';
    $input['useLimit'] = '';
    $input['rewardLimit'] = '';

    $baseUrl = '';


    // Create an order based on Reserve API parameters
    $orderParams = [
        "amount" => (integer) $input['amount'],
        "currency" => $input['currency'],
        "orderId" => ($input['orderId']) ? $input['orderId'] : "SN" . date("YmdHis") . (string) substr(round(microtime(true) * 1000), -3),
        "packages" => [
            [
                "id" => "pid",
                "amount" => (integer) $input['amount'],
                "name" => "Package Name",
                "products" => [
                    [
                        "name" => $input['productName'],
                        "quantity" => 1,
                        "price" => (integer) $input['amount'],
                        "imageUrl" => ($input['imageUrl']) ? $input['imageUrl'] : 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/LINE_logo.svg/220px-LINE_logo.svg.png',
                    ],
                ],
            ],
        ],
        "redirectUrls" => [
            "confirmUrl" => "{$baseUrl}/confirm.php",
            "cancelUrl" => "{$baseUrl}/index.php",
        ],
        "options" => [  
            "display" => [
                "checkConfirmUrlBrowser" => true,
            ],
        ],
    ];

    // Capture: false
    if (isset($input['captureFalse'])) {
        $orderParams['options']['payment']['capture'] = false;
    }
    // Preapproved
    if (isset($input['preapproved'])) {
        $orderParams['options']['payment']['payType'] = 'PREAPPROVED';
    }
    // BrachName (Refund API doesn't support)
    if ($input['branchName']) {
        $orderParams['options']['extra']['branchName'] = $input['branchName'];
    }
    // ConfirmUrlType
    if ($input['confirmUrlType']) {
        $orderParams['redirectUrls']['confirmUrlType'] = $input['confirmUrlType'];
    }
    // Display locale
    if ($input['locale']) {
        $orderParams['options']['display']['locale'] = $input['locale'];
    }
    // PaymentUrl type
    $paymentUrlType = (isset($input['paymenUrlApp'])) ? 'app' : 'web';
    // PromotionRestriction
    if ($input['useLimit'] || $input['rewardLimit']) {
        $orderParams['options']['extra']['promotionRestriction']['useLimit'] = ($input['useLimit']) ? $input['useLimit'] : 0;
        $orderParams['options']['extra']['promotionRestriction']['rewardLimit'] = ($input['rewardLimit']) ? $input['rewardLimit'] : 0;
    }    

    $this->client->Initialize([
    'channelId' => $input['channelId'],
    'channelSecret' => $input['channelSecret'],
    'isSandbox' => $input['isSandbox'], 
    'merchantDeviceProfileId' => $input['merchantDeviceProfileId'],
    ]);

    $this->client->reserve($orderParams);


    // $out_trade_no = $this->post('out_trade_no');
    // $refund_amt = $this->post('refund_amt');
    // $token = $this->post('token');
    // $token_type = $this->post('token_type');    // 1: system account, 2: wechat code

    // if (empty($out_trade_no) || empty($out_trade_no))
    // {
    //   $message = [
    //     'status' => REST_Controller::HTTP_BAD_REQUEST,
    //     'code' => $out_trade_no
    //   ];

    //   $this->set_response($message, $message['status']);
    //   return;
    // }

    // if(empty($token) || empty($token_type))
    // {
    //   $message = [
    //     'status' => REST_Controller::HTTP_BAD_REQUEST,
    //     'message' => 'Required fields missing or incorrect.',
    //   ];

    //   $this->response($message, $message['status']);
    // }

    // if($token_type == '1')  // 1: system account, 2: wechat code
    // {
    //   // validate user session token.
    //   $result = $this->session_tokens->validation($token);
    //   $user_token = $result['user_token'];
    //   $message = $result['message'];

    //   if ($message) {
    //     $this->response($message, $message['status']);
    //   }
      
    //   if($user_token->banned == 1){
    //     $message = [
    //       'status' => REST_Controller::HTTP_UNAUTHORIZED,
    //       'message' => 'Account is deactivated.',
    //     ];
    //     $this->response($message,$message['status']);
    //   }      
    // }
    // else
    // {
    //   $info = $this->utils->wechat_code_validation($token);
    //   $json = json_decode($info);//对json数据解码
    //   $arr = get_object_vars($json);//返回一个数组。获取$json对象中的属性，组成一个数组  
    //   // log_message('error', 'arr= '.print_r($arr,true));

    //   $openid = !empty($arr['openid']) ? $arr['openid'] : NULL;
    //   $session_key = !empty($arr['session_key']) ? $arr['session_key'] : NULL;

    //   if(empty($openid) or empty($session_key))
    //   {
    //     $message = [
    //       'status' => REST_Controller::HTTP_UNAUTHORIZED,
    //       'message' => $json
    //     ];

    //     $this->set_response($message, $message['status']);
    //     return;
    //   }      
    // }
 
    // require __DIR__ . '/_config.php';

    // Get Base URL path without filename
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);
    $input = $_POST;
    $input['isSandbox'] = (isset($input['isSandbox'])) ? true : false;
    // Merchant config option
    if (isset($input['merchant'])) {
        $merchant = Merchant::getMerchant($input['merchant']);
        $input['channelId'] = $merchant['channelId'];
        $input['channelSecret'] = $merchant['channelSecret'];
    }

    // Create LINE Pay client
    $linePay = new \yidas\linePay\Client([
        'channelId' => $input['channelId'],
        'channelSecret' => $input['channelSecret'],
        'isSandbox' => $input['isSandbox'], 
        'merchantDeviceProfileId' => $input['merchantDeviceProfileId'],
    ]);

    // Create an order based on Reserve API parameters
    $orderParams = [
        "amount" => (integer) $input['amount'],
        "currency" => $input['currency'],
        "orderId" => ($input['orderId']) ? $input['orderId'] : "SN" . date("YmdHis") . (string) substr(round(microtime(true) * 1000), -3),
        "packages" => [
            [
                "id" => "pid",
                "amount" => (integer) $input['amount'],
                "name" => "Package Name",
                "products" => [
                    [
                        "name" => $input['productName'],
                        "quantity" => 1,
                        "price" => (integer) $input['amount'],
                        "imageUrl" => ($input['imageUrl']) ? $input['imageUrl'] : 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/LINE_logo.svg/220px-LINE_logo.svg.png',
                    ],
                ],
            ],
        ],
        "redirectUrls" => [
            "confirmUrl" => "{$baseUrl}/confirm.php",
            "cancelUrl" => "{$baseUrl}/index.php",
        ],
        "options" => [  
            "display" => [
                "checkConfirmUrlBrowser" => true,
            ],
        ],
    ];

    // Capture: false
    if (isset($input['captureFalse'])) {
        $orderParams['options']['payment']['capture'] = false;
    }
    // Preapproved
    if (isset($input['preapproved'])) {
        $orderParams['options']['payment']['payType'] = 'PREAPPROVED';
    }
    // BrachName (Refund API doesn't support)
    if ($input['branchName']) {
        $orderParams['options']['extra']['branchName'] = $input['branchName'];
    }
    // ConfirmUrlType
    if ($input['confirmUrlType']) {
        $orderParams['redirectUrls']['confirmUrlType'] = $input['confirmUrlType'];
    }
    // Display locale
    if ($input['locale']) {
        $orderParams['options']['display']['locale'] = $input['locale'];
    }
    // PaymentUrl type
    $paymentUrlType = (isset($input['paymenUrlApp'])) ? 'app' : 'web';
    // PromotionRestriction
    if ($input['useLimit'] || $input['rewardLimit']) {
        $orderParams['options']['extra']['promotionRestriction']['useLimit'] = ($input['useLimit']) ? $input['useLimit'] : 0;
        $orderParams['options']['extra']['promotionRestriction']['rewardLimit'] = ($input['rewardLimit']) ? $input['rewardLimit'] : 0;
    }

    // Online Reserve API
    $response = $linePay->reserve($orderParams);

    // Log
    saveLog('Request API', $response, true);

    // Check Request API result
    if (!$response->isSuccessful()) {
        die("<script>alert('ErrorCode {$response['returnCode']}: " . addslashes($response['returnMessage']) . "');history.back();</script>");
    }

    // Save the order info to session for confirm
    $_SESSION['linePayOrder'] = [
        'transactionId' => (string) $response["info"]["transactionId"],
        'params' => $orderParams,
        'isSandbox' => $input['isSandbox'], 
    ];
    // Save input for next process and next form
    $_SESSION['config'] = $input;

    // Redirect to LINE Pay payment URL 
    header('Location: '. $response->getPaymentUrl($paymentUrlType) );

  }


}
