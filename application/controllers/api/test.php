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
class Test extends REST_Controller {

  function __construct()
  {
    parent::__construct();

    // $this->load->model(array('tank_auth/users', 'locations_model', 'incentive_program_model', 'card_balance', 'user_tokens', 'user_mobile_account', 'variables'));
    // $this->load->model(array('user_third','referral_program_model','user_profiles'));
    // $this->load->library('tank_auth');
    // $this->lang->load('tank_auth');
  }

  public function start_post()
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
    $request->setMessageContent("SGVsbG8lMkMlMjBMaW5jb2xuLg=="); //hello world Base64 String.
    $request->setTopicFullName("/a1dSHKlSbBX/test/get"); //消息发送到的Topic全名.
    $response = $client->getAcsResponse($request);
    // print_r($response);

    $message = [
      'status' => '200',
      'message' => $response
    ];

    $this->set_response($message, $message['status']);

    // $remember = FALSE;

    // $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth'));
    // $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

    // if (!$login || !$password) {
    //   $message = [
    //     'status' => REST_Controller::HTTP_BAD_REQUEST,
    //     'message' => 'Required fields missing or incorrect.',
    //   ];

    //   $this->response($message, $message['status']);
    // }

    // if ($this->tank_auth->login($login, $password, $remember, $data['login_by_username'], $data['login_by_email'])) {
    //   // success
    //   $user = $this->users->get_user_by_login($login);
    //   unset($user->password);

    //   $user_phone = $this->user_third->select_user_phone($user->id);
    //   //$user_email = $this->user_third->select_user_email($user->id);
    //   $user_bonus = $this->user_third->select_user_bonus($user_phone,$user->id);
    //   $referring  = $this->referral_program_model->select_referring($user->id);
    //   $referred   = $this->referral_program_model->select_referred($user->id);
    //   $referred_first   = $this->referral_program_model->select_referred_first($user->id);

    //   $this->user_tokens->delete($user->id);

    //   $token = md5(microtime().rand());

    //   $user_token = array(
    //     'user_id' => $user->id,
    //     'token' => $token,
    //     'timestamp' => time(),
    //   );

    //   $this->user_tokens->insert($user_token);

    //   $message = [
    //     'status' => REST_Controller::HTTP_OK,
    //     'user_id' => $user->id,
    //     'user_level' => $user->level,
    //     'phone' => isset($user_phone) ? $user_phone : '',
    //     'bonus' => isset($user_bonus) ? $user_bonus : '0',
    //     'autorefill' => $user->auto_status ? '1' : '0',
    //     'referring' => $referring ? '1' : '0',
    //     'referred' => $referred ? '1' : '0',
    //     'account_referred' => $referred_first ? '1' : '0',
    //     //'email' => $user_email ? $user_email : '',
    //     'token' => $token,
    //   ];

    //   $current_user_mobile_account = $this->user_mobile_account->get($user->id);

    //   if (!$current_user_mobile_account) {
    //     $message = [
    //       'status' => REST_Controller::HTTP_NOT_FOUND,
    //       'message' => 'User account not found.',
    //     ];

    //     $this->response($message, $message['status']);
    //   }

    //   $message['account_number'] = $current_user_mobile_account->account_number;
    //   $message['account_balance'] = strval($current_user_mobile_account->balance+$current_user_mobile_account->bonus_balance);

    //   if ($user->level == $this->config->item('user_tenant', 'tank_auth')) {
    //     $message['zipcode'] = $user->zipcode;

    //     if ($user->cardnumber) {
    //       $message['card_number'] = $user->cardnumber;
    //       $message['card_balance'] = (string)$this->card_balance->get($user->cardnumber);
    //     }
    //   }

    //   $this->response($message, $message['status']);
    // } else {
    //   $errors = $this->tank_auth->get_error_message();

    //   // fail
    //   foreach ($errors as $k => $v) {
    //     $data['errors'][$k] = $this->lang->line($v) ? $this->lang->line($v) : $v;

    //     $message = [
    //       'status' => REST_Controller::HTTP_BAD_REQUEST,
    //       'message' => implode(', ', $data['errors']),
    //     ];
    //   }
	   //  if(strpos($message['message'], 'This account\'s access is restricted') !== false) {
    //   	$message['message'] = 'Account is deactivated.';
	   //  }
    //   $this->response($message, $message['status']);
    // }
  }

 //  public function logout_get()
 //  {
 //    $token = $this->get('token');

 //    if ($this->user_tokens->delete_via_token($token)) {
 //      $this->response(NULL, REST_Controller::HTTP_OK);
 //    }

 //    $this->response(NULL, REST_Controller::HTTP_NOT_FOUND);
 //  }

 //  public function register_post()
 //  {
 //    // get all POST fields.
 //    $username = $this->post('username') ? $this->post('username') : '';
 //    $email = $this->post('email');

 //    $password = $this->post('password');
 //    $confirm_password = $this->post('confirm_password');

 //    $cardnumber = $this->post('cardnumber') ? $this->post('cardnumber') : '';
 //    $confirm_cardnumber = $this->post('confirm_cardnumber');

 //    $cvc = $this->post('cvc') ? $this->post('cvc') : '';

 //    $credit_first = $this->post('credit_first') ? $this->post('credit_first') : '';
 //    $confirm_credit_first = $this->post('confirm_credit_first');

 //    $credit_last = $this->post('credit_last') ? $this->post('credit_last') : '';
 //    $confirm_credit_last = $this->post('confirm_credit_last');

 //    $sitecode = $this->post('sitecode');
 //    $location_id = $this->post('location_code');

 //    $suite = $this->post('suite') ? $this->post('suite') : '';
 //    $phone = $this->post('phone') ? $this->post('phone') : '';
 //    $alert = $this->post('alert') ? $this->post('alert') : 0;
 //    $referred_code = $this->post('referred_code') ? $this->post('referred_code') : '';
 //    // check if required fields are present or not.
 //    if (!$email || !$password || !$confirm_password || !$sitecode || !$location_id) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Required fields missing or incorrect.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // email validation.
 //    if (!valid_email($email)) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Email address given is not a valid one.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // password validation.
 //    if (!ctype_alnum($password)) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Password should contain only letters and digits, at least 1 digit required.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    if (strlen($password) > $this->config->item('password_max_length', 'tank_auth') || strlen($password) < $this->config->item('password_min_length', 'tank_auth')) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Password must be between 6 and 16 characters.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check if password is confirmed correctly.
 //    if ($confirm_password != $password) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Password does not match.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    if (strlen($location_id) > 12) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Location ID should exceed 12 characters.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // required fields validation over, time to check other fields depending on location information.

 //    // get location via Location ID and site code posted.
 //    $location = $this->locations_model->get_via_uln_sitecode($location_id, $sitecode);

 //    // check if location exists in database or not.
 //    if (!$location) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_NOT_FOUND,
 //        'message' => 'Location not found.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check if location is mobile compatible.
 //    if (!$location->mobile_compatibility) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Location is not mobile compatible.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check location device type.
 //    if ($location->device_type != 'ultra') {
 //      // check if card number is present.
 //      if ($cardnumber != '') {
 //        // check length of card number.
 //        if (strlen($cardnumber) != 7) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # should be 7 digits.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if card number is confirmed correctly.
 //        if ($confirm_cardnumber != $cardnumber) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # does not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if card number is taken by another user.
 //        if (!$this->_valid_cardnumber($cardnumber)) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # ' . $cardnumber . ' is already registered, please use another one.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if cvc is needed.
 //        if ($this->variables->get('card_verification_status')->value
 //          && ($cardnumber < $this->config->item('cvc_mode_bypass_card_range')['min']
 //          || $cardnumber > $this->config->item('cvc_mode_bypass_card_range')['max'])) {

 //          // check if cvc is present.
 //          if (!$cvc) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => 'Required fields missing or incorrect.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }

 //          // contact socket and do card verification.
 //          $this->load->library('sockets');
 //          $response = $this->sockets->card_verification($this->variables->get('card_verification_server_ip')->value, $this->variables->get('card_verification_server_port')->value, $cardnumber);

 //          if (isset($response['error'])) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => $response['error'].", ".mailto($this->variables->get('help_desk_email')->value,'contact administrator').'.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }

 //          if (!$response['cvc'] || $response['cvc'] != $cvc) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => 'Card Verification Failed. Please check your card number and card verification code.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }
 //        }
 //      }
 //    } else {
 //      if ($credit_first != '' && $credit_last != '') {
 //        // check length of credit first and credit last.
 //        if (strlen($credit_first) != 6 || strlen($credit_last) != 4) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Please give first 6 digits and last 4 digits of your credit card number.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check field confirmation.
 //        if ($confirm_credit_first != $credit_first) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'First 6 digits of credit card number do not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        if ($confirm_credit_last != $credit_last) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Last 4 digits of credit card number do not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if value are taken by other users.
 //        if (!$this->_valid_credit_card_number($credit_first, $credit_last)) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Credit Card # ' . $credit_first . str_repeat('*', 10) . $credit_last . ' is already registered, please use another one.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }
 //      }
 //    }

 //    $email_activation = $this->config->item('email_activation', 'tank_auth');

 //    // validation over, create resident user now.
 //    if (!is_null($data = $this->tank_auth->create_user($username, $email, $password, $email_activation))) {
 //      unset($data['password']); // Clear password (just for any case)

 //      // update user profile after user created.
 //      $update_data = array(
 //        'cardnumber' => $location->device_type != 'ultra' ? $cardnumber : '',
 //        'cvc' => $location->device_type != 'ultra' ? $cvc : '',
 //        'credit_first' => $location->device_type == 'ultra' ? $credit_first : '',
 //        'credit_last' => $location->device_type == 'ultra' ? $credit_last : '',
 //        'devicetype' => $location->device_type,
 //        'sitecode' => str_repeat('0', 6-strlen($sitecode)) . $sitecode,
 //        'uln' => $location_id . str_repeat(' ', 12-strlen($location_id)),
 //        'remark' => $location->location_name,
 //        'suite' => $suite,
 //        'zipcode' => $location->zipcode,
 //        'phone' => $phone,
 //        'alert' => $alert,
 //      );

 //      $this->db->where('id', $data['user_id']);
 //      $this->db->update('user_profiles', $update_data);

 //      // create user mobile account after user created.
 //      $user_mobile_account_data = array(
 //        'user_id' => $data['user_id'],
 //        'account_number' => str_repeat('0', 12-strlen($data['user_id'])) . $data['user_id'],
 //        'balance' => 0,
 //        'tx_counter' => 0,
 //        'offline_tx_counter' => 0,
 //        'max_offline_tx_counter' => 5
 //      );

 //      if (!is_null($location_incentive_program = $this->incentive_program_model->get_via_location_id($location->id))
 //        && !$location_incentive_program->disabled
 //        && (
 //          $location_incentive_program->expire_date == 0
 //          || date('Y-m-d', strtotime($location_incentive_program->expire_date)) >= date('Y-m-d', time('today'))
 //        )
 //      ) {
 //        $user_mobile_account_data['bonus_balance'] = $location_incentive_program->amount;
 //      }

 //      //When SMS is closed, determine the location and give the user bonus.
 //      $sms_verification = $this->variables->get('sms_verification')->value;
 //      if(empty(trim($phone))
 //        && $sms_verification == 'close'
 //        && !is_null($location_incentive_program = $this->incentive_program_model->get_via_location_id($location->id))
 //        && !$location_incentive_program->disabled
 //        && ($location_incentive_program->expire_date == 0 || date('Y-m-d', strtotime($location_incentive_program->expire_date)) >= date('Y-m-d', time('today')))
 //      ) {
 //         $user_mobile_account_data['bonus_balance'] = $location_incentive_program->amount;
 //         $user_profiles_mark = $this->referral_program_model->update_user_profiles($data['user_id']);
 //      }

 //      $this->db->insert('user_mobile_account', $user_mobile_account_data);

 //      //update referral register data
 //      if($referred_code && $phone)
 //      {
 //            $referred_info = $this->referral_program_model->find_sms_code($phone,$referred_code); //查询用户在user_refered_friend表的记录信息

 //            if($referred_info)
 //            {
 //                //add referred amount
 //                $referred_location_bonus = 0;
 //                $location_info = $this->referral_program_model->get_uln_location_id(trim($location_id));

 //                if($location_info)
 //                {
 //                   $referred_location_bonus = $this->referral_program_model->find_referral_location_amount($location_info->id);
 //                   if(!$referred_location_bonus)
 //                   {
 //                      $referred_location_bonus = $this->referral_program_model->get_referal_group($location_info->id);
 //                   }
 //                }

 //                if($referred_location_bonus)
 //                {
 //                   $referral_res = $this->referral_program_model->update_referral_register($referred_code,$phone,$data['user_id']);
 //                   $set_refered_banus = $this->referral_program_model->set_refered_banus($referred_info[0]->id,$referred_location_bonus);
 //                   $update_user_bonus_res = $this->referral_program_model->update_user_bonus($data['user_id'],$referred_location_bonus);
 //                }else{
 //                   $referral_res = $this->referral_program_model->update_referral_register($referred_code,$phone,$data['user_id']);
 //                }
 //            }
 //      }

 //      $data['site_name'] = $this->config->item('website_name', 'tank_auth');

 //      if ($email_activation) {
 //        // send "activate" email
 //        $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
 //        $this->_send_email('activate', $data['email'], $data);
 //      } else {
 //        if ($this->config->item('email_account_details', 'tank_auth')) {
 //          // send "welcome" email
 //          $this->_send_email('welcome', $data['email'], $data);
 //        }
 //      }

 //      $message = [
 //        'status' => REST_Controller::HTTP_OK,
 //        'message' => 'Congratulations! You’ve successfully registered to '.$this->config->item('washboard_name').'!'
 //      ];

 //      $this->response($message, $message['status']);
 //    } else {
 //      $errors = $this->tank_auth->get_error_message();

 //      // fail
 //      foreach ($errors as $k => $v) {
 //        $data['errors'][$k] = $this->lang->line($v) ? $this->lang->line($v) : $v;

 //        $message = [
 //          'status' => REST_Controller::HTTP_BAD_REQUEST,
 //          'message' => implode(', ', $data['errors']),
 //        ];
 //      }

 //      $this->response($message, $message['status']);
 //    }
 //  }

 //  public function sms_send_post()
 //  {
 //    $country_code = preg_replace('/\D/', '', $this->post('country_code'));
 //    $phone = preg_replace('/\D/', '', $this->post('phone'));
 //    $message = ['sms_status' => 'open'];

 //    $variables = $this->variables->get('sms_verification');
 //    if($variables && $variables->value == 'close') {
 //      $message = array_merge($message,['sms_status' => 'close']);
 //      $message += [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'SMS Verification Closed.',
 //      ];
 //      $this->response($message, $message['status']);
 //    }

 //    if(empty($country_code) || strlen($phone) < 9) {
 //      $message += [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Please input the valid mobile phone number (Optional).',
 //      ];
 //      $this->response($message, $message['status']);
 //    }

 //    $this->load->model('user_phone');
 //    $phone_data = $this->user_phone->get($country_code, $phone);
 //    $phone_data = $phone_data ? $phone_data : json_decode('{"sms_code":"","sms_time":""}');

 //    if($phone_data->sms_time > 0 && $phone_data->sms_time + 60 > $_SERVER['REQUEST_TIME']) {
 //      $left_time = $phone_data->sms_time + 60 - $_SERVER['REQUEST_TIME'];
 //      $message += [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => "Please try again after {$left_time} senconds",
 //      ];
 //      $this->response($message, $message['status']);
 //    }

 //    if($phone_data->sms_time + 300 > $_SERVER['REQUEST_TIME']) {
 //      $sms_code = $phone_data->sms_code;
 //    } else {
 //      $sms_code = mt_rand(1000, 9999);
 //    }

 //    $this->user_phone->replace([
 //      'phone' => $phone,
 //      'country_code' => $country_code,
 //      'sms_code' => $sms_code,
 //      'sms_time' => $_SERVER['REQUEST_TIME'],
 //    ]);

 //    //exit('sms_code: '.$sms_code);

 //    $this->load->library('cdyne', $this->config->item('cdyne_setup'));

 //    $sms_phone = $country_code.$phone;
 //    $sms_message = "Please use the code {$sms_code} to verify your [{$_SERVER['HTTP_HOST']}] account.";
 //    $cdyne_response = $this->cdyne->SimpleSMSSend($sms_phone, $sms_message);

 //    if(!$cdyne_response) {
 //      $message += [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'SMS Service Error, please try again later',
 //      ];
 //      $this->response($message, $message['status']);
 //    }

 //    if($cdyne_response->SMSError == 0) {
 //      if($cdyne_response->Queued == true) {
 //        $i = 5;
 //        while($i-- > 0) {
 //          sleep(4);
 //          $cdyne_response2 = $this->cdyne->GetMessageStatus($cdyne_response->MessageID);
 //          if($cdyne_response2) {
 //            if($cdyne_response2->Queued == false || $cdyne_response2->Sent == true) {
 //              $cdyne_response = $cdyne_response2;
 //              break;
 //            }
 //          }
 //        }
 //        if($cdyne_response->Queued == true) {
 //          $this->cdyne->CancelMessage($cdyne_response->MessageID);
 //          $message += [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'SMS Service is busy, please try again later',
 //          ];
 //          $this->response($message, $message['status']);
 //        }
 //      }
 //      if($cdyne_response->Sent == true) {
 //        $message += [
 //          'status' => REST_Controller::HTTP_OK,
 //          'message' => 'Verification Code Sent.',
 //        ];
 //        $this->response($message, $message['status']);
 //      }
 //    }

 //    $cdyne_errorcode = array(
 //      0 => 'No Error',
 //      1 => 'STOP from Phone Number',
 //      2 => 'License Key Invalid',
 //      3 => 'Phone Number Invalid',
 //      4 => 'Message Invalid',
 //      5 => 'Scheduled DateTime Is Not UTC',
 //      6 => 'Invalid Assigned DID',
 //      7 => 'Not Found (Occurs for Invalid MessageID)',
 //      8 => 'Internal Error',
 //      9 => 'Contact Cdyne Account Suspended'
 //    );

 //    $message += [
 //      'status' => REST_Controller::HTTP_BAD_REQUEST,
 //      'message' => isset($cdyne_errorcode[$cdyne_response->SMSError]) ? $cdyne_errorcode[$cdyne_response->SMSError] : 'Unknow'
 //    ];
 //    $this->response($message, $message['status']);
 //  }

 //  private function _sms_check()
 //  {
 //      $country_code = preg_replace('/\D/', '', $this->post('country_code'));
 //      $phone = preg_replace('/\D/', '', $this->post('phone'));
 //      $ver_code = preg_replace('/\D/', '', $this->post('ver_code'));

 //      $country_code = $country_code ? $country_code : '1';

 //      if(empty($country_code) || empty($phone) || empty($ver_code)) {
 //        return 0;
 //      }

 //      $this->load->model('user_phone');
 //      $phone_data = $this->user_phone->get($country_code, $phone);
 //      $phone_data = $phone_data ? $phone_data : json_decode('{"sms_code":"","sms_time":""}');

 //      if($ver_code != $phone_data->sms_code || $phone_data->sms_time + 300 < $_SERVER['REQUEST_TIME']) {
 //        $message = [
 //          'status' => REST_Controller::HTTP_BAD_REQUEST,
 //          'message' => 'Verification Code error or expired.',
 //        ];
 //        $this->response($message, $message['status']);
 //      }

 //      if($phone_data->bonus > 0) {
 //        return 3;
 //      }

 //      // exist phone number return
 //      // $this->load->model(array('user_profiles','registered_numbers'));
 //      // if($this->user_profiles->get_exist_phone($phone) || $this->registered_numbers->get_exist_phone($phone)){
 //      //   return 2;
 //      // }

 //      return 1;
 //  }

	// private function _bonus_sms_check($country_code, $phone, $ver_code)
	// {
	// 	$country_code = $country_code ? $country_code : '1';
	// 	$this->load->model('user_phone');
	// 	$phone_data = $this->user_phone->get($country_code, $phone);
	// 	$phone_data = $phone_data ? $phone_data : json_decode('{"sms_code":"","sms_time":""}');

	// 	if($ver_code != $phone_data->sms_code) {
	// 		$message = [
	// 			'status' => REST_Controller::HTTP_BAD_REQUEST,
	// 			'error_type' => '1',
	// 			'message' => 'Verification Code error.',
	// 		];
	// 		$this->response($message, $message['status']);
	// 	} elseif($phone_data->sms_time + 300 < $_SERVER['REQUEST_TIME']){
	// 		$message = [
	// 			'status' => REST_Controller::HTTP_BAD_REQUEST,
	// 			'error_type' => '2',
	// 			'message' => 'Verification Code expired.',
	// 		];
	// 		$this->response($message, $message['status']);
	// 	}

	// 	if($phone_data->bonus > 0) {
	// 		return 3;
	// 	}
	// 	return 1;
	// }

 //  public function register_verficasion_post()
 //  {
 //    // get all POST fields.
 //    $username = $this->post('username') ? $this->post('username') : '';
 //    $email = $this->post('email');

 //    $password = $this->post('password');
 //    $confirm_password = $this->post('confirm_password');

 //    $cardnumber = $this->post('cardnumber') ? $this->post('cardnumber') : '';
 //    $confirm_cardnumber = $this->post('confirm_cardnumber');

 //    $cvc = $this->post('cvc') ? $this->post('cvc') : '';

 //    $credit_first = $this->post('credit_first') ? $this->post('credit_first') : '';
 //    $confirm_credit_first = $this->post('confirm_credit_first');

 //    $credit_last = $this->post('credit_last') ? $this->post('credit_last') : '';
 //    $confirm_credit_last = $this->post('confirm_credit_last');

 //    $sitecode = $this->post('sitecode');
 //    $location_id = $this->post('location_code');

 //    $suite = $this->post('suite') ? $this->post('suite') : '';
 //    $alert = $this->post('alert') ? $this->post('alert') : 0;
 //    $referred_code = $this->post('referred_code') ? $this->post('referred_code') : '';

 //    $country_code = preg_replace('/\D/', '', $this->post('country_code'));
 //    $phone = preg_replace('/\D/', '', $this->post('phone'));

 //    // check if required fields are present or not.
 //    if (!$email || !$password || !$confirm_password || !$sitecode || !$location_id) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Required fields missing or incorrect.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // email validation.
 //    if (!valid_email($email)) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Email address given is not a valid one.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // password validation.
 //    if (!ctype_alnum($password)) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Password should contain only letters and digits, at least 1 digit required.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    if (strlen($password) > $this->config->item('password_max_length', 'tank_auth') || strlen($password) < $this->config->item('password_min_length', 'tank_auth')) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Password must be between 6 and 16 characters.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check if password is confirmed correctly.
 //    if ($confirm_password != $password) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Password does not match.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    if (strlen($location_id) > 12) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Location ID should exceed 12 characters.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // required fields validation over, time to check other fields depending on location information.

 //    // get location via location id and site code posted.
 //    $location = $this->locations_model->get_via_uln_sitecode($location_id, $sitecode);

 //    // check if location exists in database or not.
 //    if (!$location) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_NOT_FOUND,
 //        'message' => 'Location not found.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check if location is mobile compatible.
 //    if (!$location->mobile_compatibility) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Location is not mobile compatible.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check location device type.
 //    if ($location->device_type != 'ultra') {
 //      // check if card number is present.
 //      if ($cardnumber != '') {
 //        // check length of card number.
 //        if (strlen($cardnumber) != 7) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # should be 7 digits.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if card number is confirmed correctly.
 //        if ($confirm_cardnumber != $cardnumber) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # does not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if card number is taken by another user.
 //        if (!$this->_valid_cardnumber($cardnumber)) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # ' . $cardnumber . ' is already registered, please use another one.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if cvc is needed.
 //        if ($this->variables->get('card_verification_status')->value
 //          && ($cardnumber < $this->config->item('cvc_mode_bypass_card_range')['min']
 //          || $cardnumber > $this->config->item('cvc_mode_bypass_card_range')['max'])) {

 //          // check if cvc is present.
 //          if (!$cvc) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => 'Required fields missing or incorrect.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }

 //          // contact socket and do card verification.
 //           $this->load->library('sockets');
 //          $response = $this->sockets->card_verification($this->variables->get('card_verification_server_ip')->value, $this->variables->get('card_verification_server_port')->value, $cardnumber);

 //            if (isset($response['error'])) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => $response['error'].", ".mailto($this->variables->get('help_desk_email')->value,'contact administrator').'.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }

 //          if (!$response['cvc'] || $response['cvc'] != $cvc) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => 'Card Verification Failed. Please check your card number and card verification code.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }
 //        }
 //      }
 //    } else {
 //      if ($credit_first != '' && $credit_last != '') {
 //        // check length of credit first and credit last.
 //        if (strlen($credit_first) != 6 || strlen($credit_last) != 4) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Please give first 6 digits and last 4 digits of your credit card number.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check field confirmation.
 //        if ($confirm_credit_first != $credit_first) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'First 6 digits of credit card number do not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        if ($confirm_credit_last != $credit_last) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Last 4 digits of credit card number do not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if value are taken by other users.
 //        if (!$this->_valid_credit_card_number($credit_first, $credit_last)) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Credit Card # ' . $credit_first . str_repeat('*', 10) . $credit_last . ' is already registered, please use another one.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }
 //      }
 //    }

 //    $email_activation = $this->config->item('email_activation', 'tank_auth');

 //    $phone_status = $this->_sms_check();

 //    // validation over, create resident user now.
 //    if (!is_null($data = $this->tank_auth->create_user($username, $email, $password, $email_activation))) {
 //      unset($data['password']); // Clear password (just for any case)

 //      // update user profile after user created.
 //      $update_data = array(
 //        'cardnumber' => $location->device_type != 'ultra' ? $cardnumber : '',
 //        'cvc' => $location->device_type != 'ultra' ? $cvc : '',
 //        'credit_first' => $location->device_type == 'ultra' ? $credit_first : '',
 //        'credit_last' => $location->device_type == 'ultra' ? $credit_last : '',
 //        'devicetype' => $location->device_type,
 //        'sitecode' => str_repeat('0', 6-strlen($sitecode)) . $sitecode,
 //        'uln' => $location_id . str_repeat(' ', 12-strlen($location_id)),
 //        'remark' => $location->location_name,
 //        'suite' => $suite,
 //        'zipcode' => $location->zipcode,
 //        'phone' => $phone_status > 0 ? $phone : '',
 //        'country_code' => $phone_status > 0 ? $country_code : 1,
 //        'phone_status' => $phone_status > 0 ? 1 : 0,
 //        'alert' => $alert,
 //      );

 //      $this->db->where('id', $data['user_id']);
 //      $this->db->update('user_profiles', $update_data);

 //      // create user mobile account after user created.
 //      $user_mobile_account_data = array(
 //        'user_id' => $data['user_id'],
 //        'account_number' => str_repeat('0', 12-strlen($data['user_id'])) . $data['user_id'],
 //        'balance' => 0,
 //        'tx_counter' => 0,
 //        'offline_tx_counter' => 0,
 //        'max_offline_tx_counter' => 5
 //      );

 //      if ($phone_status == 1
 //        && !is_null($location_incentive_program = $this->incentive_program_model->get_via_location_id($location->id))
 //        && !$location_incentive_program->disabled
 //        && ($location_incentive_program->expire_date == 0 || date('Y-m-d', strtotime($location_incentive_program->expire_date)) >= date('Y-m-d', time('today')))
 //      ) {
 //        $this->user_phone->update($country_code, $phone, ['bonus' => 1]);
 //        $user_mobile_account_data['bonus_balance'] = $location_incentive_program->amount;
 //      }

 //      //When SMS is closed, determine the location and give the user bonus.
 //      $sms_verification = $this->variables->get('sms_verification')->value;
 //      if(empty(trim($phone))
 //        && $sms_verification == 'close'
 //        && !is_null($location_incentive_program = $this->incentive_program_model->get_via_location_id($location->id))
 //        && !$location_incentive_program->disabled
 //        && ($location_incentive_program->expire_date == 0 || date('Y-m-d', strtotime($location_incentive_program->expire_date)) >= date('Y-m-d', time('today')))
 //      ) {
 //         $user_mobile_account_data['bonus_balance'] = $location_incentive_program->amount;
 //         $user_profiles_mark = $this->referral_program_model->update_user_profiles($data['user_id']);
 //      }

 //      $this->db->insert('user_mobile_account', $user_mobile_account_data);

 //      if($referred_code && $phone)
 //      {
 //            $referred_info = $this->referral_program_model->find_sms_code($phone,$referred_code); //查询用户在user_refered_friend表的记录信息

 //            if($referred_info)
 //            {
 //                //add referred amount
 //                $referred_location_bonus = 0;

 //                $location_info = $this->referral_program_model->get_uln_location_id(trim($location_id));

 //                if($location_info)
 //                {
 //                    $referred_locat_bonus    = $this->referral_program_model->find_referring_location_amount($location_info->id);
 //                    $referred_group_bonus    = $this->referral_program_model->get_referring_group($location_info->id);

 //                    if($referred_locat_bonus && $referred_group_bonus){
 //                       $referred_location_bonus = strtotime($referred_locat_bonus->date_added) > strtotime($referred_group_bonus->date_added) ? $referred_locat_bonus->referred_bonus : $referred_group_bonus->referred_bonus;
 //                    }else{
 //                       $referred_location_bonus = isset($referred_locat_bonus->referred_bonus) && $referred_locat_bonus->referred_bonus ? $referred_locat_bonus->referred_bonus : $referred_group_bonus->referred_bonus;
 //                    }
 //                }

 //                if($referred_location_bonus)
 //                {
 //                   $referral_res = $this->referral_program_model->update_referral_register($referred_code,$phone,$data['user_id']);
 //                   $set_refered_banus = $this->referral_program_model->set_refered_banus($referred_info[0]->id,$referred_location_bonus);
 //                   $update_user_bonus_res = $this->referral_program_model->update_user_bonus($data['user_id'],$referred_location_bonus);
 //                }else{
 //                   $referral_res = $this->referral_program_model->update_referral_register($referred_code,$phone,$data['user_id']);
 //                }
 //            }
 //      }

 //      $data['site_name'] = $this->config->item('website_name', 'tank_auth');

 //      if ($email_activation) {
 //        // send "activate" email
 //        $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
 //        $this->_send_email('activate', $data['email'], $data);
 //      } else {
 //        if ($this->config->item('email_account_details', 'tank_auth')) {
 //          // send "welcome" email
 //          $this->_send_email('welcome', $data['email'], $data);

 //          // add send phone verification email
 //          if($phone_status == 0){
 //            $this->_send_email('phoneverification', $data['email'], $data);
 //          }
 //        }
 //      }

 //      $message = [
 //        'status' => REST_Controller::HTTP_OK,
 //        'message' => 'Congratulations! You’ve successfully registered to '.$this->config->item('washboard_name').'!'
 //      ];

 //      $this->response($message, $message['status']);
 //    } else {
 //      $errors = $this->tank_auth->get_error_message();

 //      // fail
 //      foreach ($errors as $k => $v) {
 //        $data['errors'][$k] = $this->lang->line($v) ? $this->lang->line($v) : $v;

 //        $message = [
 //          'status' => REST_Controller::HTTP_BAD_REQUEST,
 //          'message' => implode(', ', $data['errors']),
 //        ];
 //      }

 //      $this->response($message, $message['status']);
 //    }
 //  }

 //  //check the sms and update the user's bonus
	// public function update_user_bonus_post()
	// {
	// 	// get all POST fields.
	// 	$user_id = $this->post('user_id');
	// 	$ver_code = preg_replace('/\D/', '', $this->post('ver_code'));
	// 	$country_code = preg_replace('/\D/', '', $this->post('country_code'));
	// 	$phone = preg_replace('/\D/', '', $this->post('phone'));

	// 	// check if required fields are present or not.
	// 	if (!$user_id || !$ver_code || !$country_code || !$phone) {
	// 		$message = [
	// 			'status' => REST_Controller::HTTP_BAD_REQUEST,
	// 			'error_type' => '5',
	// 			'message' => 'Required fields missing or incorrect.',
	// 		];

	// 		$this->response($message, $message['status']);
	// 	}

	// 	//validate the sms verification code
	// 	$phone_status = $this->_bonus_sms_check($country_code, $phone, $ver_code);

	// 	if($phone_status >0 ) {
	// 		//bind mobile phone
	// 		$user_profiles['phone'] = $phone;
	// 		$user_profiles['country_code'] = $country_code;
	// 		$user_profiles['phone_status'] = 1;
	// 		$this->user_profiles->update($user_id, $user_profiles);
	// 	}

	// 	//get user's location
	// 	$user_data = $this->users->get_user_by_id($user_id, 1);
	// 	$location = $this->locations_model->get_via_uln_sitecode($user_data->uln, $user_data->sitecode);
	// 	if ($phone_status != 1 || $user_data->incentive_bonus == 1) {
	// 		$message = [
	// 			'status' => REST_Controller::HTTP_BAD_REQUEST,
	// 			'error_type' => '3',
	// 			'message' => 'You have already been rewarded.',
	// 		];
	// 		$this->response($message, $message['status']);
	// 	} elseif (!is_null($location_incentive_program = $this->incentive_program_model->get_via_location_id($location->id))
	// 		&& !$location_incentive_program->disabled
	// 		&& ($location_incentive_program->expire_date == 0 || date('Y-m-d', strtotime($location_incentive_program->expire_date)) >= date('Y-m-d', time('today')))
	// 	) {
	// 		//update user's bonus
	// 		$this->user_phone->update($country_code, $phone, ['bonus' => 1]);
	// 		$user_mobile_account = $this->user_mobile_account->get($user_id);
	// 		$user_mobile_account_data['bonus_balance'] = $location_incentive_program->amount + $user_mobile_account->bonus_balance;
	// 		$this->user_mobile_account->update($user_id, $user_mobile_account_data);

	// 		$message = [
	// 			'status' => REST_Controller::HTTP_OK,
	// 			'error_type' => '0',
	// 			'message' => 'Add the bonus successfully.'
	// 		];

	// 		$this->response($message, $message['status']);
	// 	} else {
	// 		$message = [
	// 			'status' => REST_Controller::HTTP_BAD_REQUEST,
	// 			'error_type' => '4',
	// 			'message' => 'Bonus Program is disabled or expired.',
	// 		];
	// 		$this->response($message, $message['status']);
	// 	}
	// }

 //  private function _valid_cardnumber($cardnumber)
 //  {
 //    return !$this->users->cardnumber_exist($cardnumber);
 //  }

 //  private function _valid_credit_card_number($credit_first, $credit_last)
 //  {
 //    return !$this->users->credit_card_number_exist($credit_first, $credit_last);
 //  }

 //  private function _send_email($type, $email, &$data)
 //  {
 //    $this->config->load('email', TRUE);
 //    $email_config = $this->config->item('email');
 //    $this->load->library('email', $email_config);

 //    $this->email->from($this->variables->get('help_desk_email')->value, $this->config->item('website_name', 'tank_auth'));
 //    $this->email->reply_to($this->variables->get('help_desk_email')->value, $this->config->item('website_name', 'tank_auth'));
 //    $this->email->to($email);
 //    $this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
 //    $this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
 //    $this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
 //    $this->email->send();
 //  }

 //  public function third_login_post()
 //  {

 //    $userid   = $this->post('userid');
 //    $name     = $this->post('name');
 //    $nickname = $this->post('nickname');
 //    $email    = $this->post('email');
 //    $img      = $this->post('img');
 //    $source   = $this->post('source');

 //    if (!$userid || !$name || !$source) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Required fields missing or incorrect.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    $res = $this->user_third->get_third_id($userid, $source);

 //    if(!isset($res[0]->uid))
 //    {
 //        $user_third_info  = array('uid'      => $userid,
 //                              'name'     => $name,
 //                              'nickname' => $nickname,
 //                              'email'    => $email,
 //                              'image'    => $img,
 //                                 );

 //       $third_id = $this->user_third->insert_user_info($user_third_info,$source);

 //       $message = [
 //        'status'  => 206,
 //        'user_id' => $userid,
 //        'message' => 'Please continue to add user information.',
 //       ];

 //       $this->response($message, $message['status']);
 //    }else{
 //         if(!isset($res[0]->userid)){
 //          $message = [
 //            'status'  => 206,
 //            'user_id' => $userid,
 //            'message' => 'Please continue to add user information.',
 //          ];

 //          $this->response($message, $message['status']);
 //         }else{
 //            $user = $this->user_third->get_third_uids($res[0]->userid);
 //         }
 //    }

 //    $message = $this->make_login_info($user);
 //    $this->response($message, $message['status']);
 //  }

 //  public function third_register_post()
 //  {
 //    // get all POST fields.
 //    $userid = $this->post('userid');
 //    $username = $this->post('username') ? $this->post('username') : '';
 //    $email = $this->post('email');

 //    $cardnumber = $this->post('cardnumber') ? $this->post('cardnumber') : '';
 //    $confirm_cardnumber = $this->post('confirm_cardnumber');

 //    $cvc = $this->post('cvc') ? $this->post('cvc') : '';

 //    $credit_first = $this->post('credit_first') ? $this->post('credit_first') : '';
 //    $confirm_credit_first = $this->post('confirm_credit_first');

 //    $credit_last = $this->post('credit_last') ? $this->post('credit_last') : '';
 //    $confirm_credit_last = $this->post('confirm_credit_last');

 //    $sitecode = $this->post('sitecode');
 //    $location_id = $this->post('location_code');

 //    $suite = $this->post('suite') ? $this->post('suite') : '';
 //    $alert = $this->post('alert') ? $this->post('alert') : 0;

 //    $country_code = preg_replace('/\D/', '', $this->post('country_code'));
 //    $phone = preg_replace('/\D/', '', $this->post('phone'));
 //    $referred_code = $this->post('referred_code') ? $this->post('referred_code') : '';

 //    // check if required fields are present or not.
 //    if (!$email || !$sitecode || !$location_id) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Required fields missing or incorrect.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // email validation.
 //    if (!valid_email($email)) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Email address given is not a valid one.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    if (strlen($location_id) > 12) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Location ID should exceed 12 characters.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // required fields validation over, time to check other fields depending on location information.

 //    // get location via location id and site code posted.
 //    $location = $this->locations_model->get_via_uln_sitecode($location_id, $sitecode);

 //    // check if location exists in database or not.
 //    if (!$location) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_NOT_FOUND,
 //        'message' => 'Location not found.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check if location is mobile compatible.
 //    if (!$location->mobile_compatibility) {
 //      $message = [
 //        'status' => REST_Controller::HTTP_BAD_REQUEST,
 //        'message' => 'Location is not mobile compatible.',
 //      ];

 //      $this->response($message, $message['status']);
 //    }

 //    // check location device type.
 //    if ($location->device_type != 'ultra') {
 //      // check if card number is present.
 //      if ($cardnumber != '') {
 //        // check length of card number.
 //        if (strlen($cardnumber) != 7) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # should be 7 digits.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if card number is confirmed correctly.
 //        if ($confirm_cardnumber != $cardnumber) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # does not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if card number is taken by another user.
 //        if (!$this->_valid_cardnumber($cardnumber)) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Laundry Card # ' . $cardnumber . ' is already registered, please use another one.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if cvc is needed.
 //        if ($this->variables->get('card_verification_status')->value
 //          && ($cardnumber < $this->config->item('cvc_mode_bypass_card_range')['min']
 //          || $cardnumber > $this->config->item('cvc_mode_bypass_card_range')['max'])) {

 //          // check if cvc is present.
 //          if (!$cvc) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => 'Required fields missing or incorrect.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }

 //          // contact socket and do card verification.
 //           $this->load->library('sockets');
 //          $response = $this->sockets->card_verification($this->variables->get('card_verification_server_ip')->value, $this->variables->get('card_verification_server_port')->value, $cardnumber);

 //            if (isset($response['error'])) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => $response['error'].", ".mailto($this->variables->get('help_desk_email')->value,'contact administrator').'.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }

 //          if (!$response['cvc'] || $response['cvc'] != $cvc) {
 //            $message = [
 //              'status' => REST_Controller::HTTP_BAD_REQUEST,
 //              'message' => 'Card Verification Failed. Please check your card number and card verification code.',
 //            ];

 //            $this->response($message, $message['status']);
 //          }
 //        }
 //      }
 //    } else {
 //      if ($credit_first != '' && $credit_last != '') {
 //        // check length of credit first and credit last.
 //        if (strlen($credit_first) != 6 || strlen($credit_last) != 4) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Please give first 6 digits and last 4 digits of your credit card number.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check field confirmation.
 //        if ($confirm_credit_first != $credit_first) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'First 6 digits of credit card number do not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        if ($confirm_credit_last != $credit_last) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Last 4 digits of credit card number do not match.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }

 //        // check if value are taken by other users.
 //        if (!$this->_valid_credit_card_number($credit_first, $credit_last)) {
 //          $message = [
 //            'status' => REST_Controller::HTTP_BAD_REQUEST,
 //            'message' => 'Credit Card # ' . $credit_first . str_repeat('*', 10) . $credit_last . ' is already registered, please use another one.',
 //          ];

 //          $this->response($message, $message['status']);
 //        }
 //      }
 //    }

 //    $email_activation = $this->config->item('email_activation', 'tank_auth');

 //    $phone_status = $this->_sms_check();

 //    // validation over, create resident user now.
 //    if (!is_null($data = $this->tank_auth->create_user($username, $email, $password='FFFFFF', $email_activation))) {
 //      unset($data['password']); // Clear password (just for any case)

 //      if(isset($data['user_id']) and isset($userid)){
 //        $res = $this->user_third->update_third_info_api($userid,$data['user_id']);
 //      }

 //      // update user profile after user created.
 //      $update_data = array(
 //        'cardnumber' => $location->device_type != 'ultra' ? $cardnumber : '',
 //        'cvc' => $location->device_type != 'ultra' ? $cvc : '',
 //        'credit_first' => $location->device_type == 'ultra' ? $credit_first : '',
 //        'credit_last' => $location->device_type == 'ultra' ? $credit_last : '',
 //        'devicetype' => $location->device_type,
 //        'sitecode' => str_repeat('0', 6-strlen($sitecode)) . $sitecode,
 //        'uln' => $location_id . str_repeat(' ', 12-strlen($location_id)),
 //        'remark' => $location->location_name,
 //        'suite' => $suite,
 //        'zipcode' => $location->zipcode,
 //        'phone' => $phone_status > 0 ? $phone : '',
 //        'country_code' => $phone_status > 0 ? $country_code : 1,
 //        'phone_status' => $phone_status > 0 ? 1 : 0,
 //        'alert' => $alert,
 //      );

 //      $this->db->where('id', $data['user_id']);
 //      $this->db->update('user_profiles', $update_data);

 //      // create user mobile account after user created.
 //      $user_mobile_account_data = array(
 //        'user_id' => $data['user_id'],
 //        'account_number' => str_repeat('0', 12-strlen($data['user_id'])) . $data['user_id'],
 //        'balance' => 0,
 //        'tx_counter' => 0,
 //        'offline_tx_counter' => 0,
 //        'max_offline_tx_counter' => 5
 //      );

 //      if ($phone_status == 1
 //        && !is_null($location_incentive_program = $this->incentive_program_model->get_via_location_id($location->id))
 //        && !$location_incentive_program->disabled
 //        && ($location_incentive_program->expire_date == 0 || date('Y-m-d', strtotime($location_incentive_program->expire_date)) >= date('Y-m-d', time('today')))
 //      ) {
 //        $this->user_phone->update($country_code, $phone, ['bonus' => 1]);
 //        $user_mobile_account_data['bonus_balance'] = $location_incentive_program->amount;
 //      }

 //      $this->db->insert('user_mobile_account', $user_mobile_account_data);

 //      //update referral register data

 //      if($referred_code && $phone)
 //      {
 //            $referred_info = $this->referral_program_model->find_sms_code($phone,$referred_code); //查询用户在user_refered_friend表的记录信息

 //            if($referred_info)
 //            {
 //                //add referred amount
 //                $referred_location_bonus = 0;

 //                $location_info = $this->referral_program_model->get_uln_location_id(trim($location_id));

 //                if($location_info)
 //                {
 //                    $referred_locat_bonus    = $this->referral_program_model->find_referring_location_amount($location_info->id);
 //                    $referred_group_bonus    = $this->referral_program_model->get_referring_group($location_info->id);

 //                    if($referred_locat_bonus && $referred_group_bonus){
 //                       $referred_location_bonus = strtotime($referred_locat_bonus->date_added) > strtotime($referred_group_bonus->date_added) ? $referred_locat_bonus->referred_bonus : $referred_group_bonus->referred_bonus;
 //                    }else{
 //                       $referred_location_bonus = isset($referred_locat_bonus->referred_bonus) && $referred_locat_bonus->referred_bonus ? $referred_locat_bonus->referred_bonus : $referred_group_bonus->referred_bonus;
 //                    }
 //                }

 //                if($referred_location_bonus)
 //                {
 //                   $referral_res = $this->referral_program_model->update_referral_register($referred_code,$phone,$data['user_id']);
 //                   $set_refered_banus = $this->referral_program_model->set_refered_banus($referred_info[0]->id,$referred_location_bonus);
 //                   $update_user_bonus_res = $this->referral_program_model->update_user_bonus($data['user_id'],$referred_location_bonus);
 //                }else{
 //                   $referral_res = $this->referral_program_model->update_referral_register($referred_code,$phone,$data['user_id']);
 //                }
 //            }
 //      }


 //      $data['site_name'] = $this->config->item('website_name', 'tank_auth');

 //      if ($email_activation) {
 //        // send "activate" email
 //        $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
 //        $this->_send_email('activate', $data['email'], $data);
 //      } else {
 //        if ($this->config->item('email_account_details', 'tank_auth')) {
 //          // send "welcome" email
 //          $this->_send_email('welcome', $data['email'], $data);

 //          // add send phone verification email
 //          if($phone_status == 0){
 //            $this->_send_email('phoneverification', $data['email'], $data);
 //          }
 //        }
 //      }

 //      /*
 //      $message = [
 //        'status' => REST_Controller::HTTP_OK,
 //        'message' => 'Congratulations! You’ve successfully registered to Washboard!'
 //      ];
 //      */

 //      $user = $this->user_third->get_third_uids($data['user_id']);
 //      $message = $this->make_login_info($user);

 //      $this->response($message, $message['status']);
 //    } else {
 //      $errors = $this->tank_auth->get_error_message();

 //      // fail
 //      foreach ($errors as $k => $v) {
 //        $data['errors'][$k] = $this->lang->line($v) ? $this->lang->line($v) : $v;

 //        $message = [
 //          'status' => REST_Controller::HTTP_BAD_REQUEST,
 //          'message' => implode(', ', $data['errors']),
 //        ];
 //      }

 //      $this->response($message, $message['status']);
 //    }
 //  }

 //  public function make_login_info($user)
 //  {
 //     if(isset($user->banned) && $user->banned == 1){
 //        $message['message'] = 'Users are banned.';
 //        return $message;
 //     }

 //     if (isset($user->id)) {

 //      unset($user->password);

 //      $user_phone = $this->user_third->select_user_phone($user->id);
 //      $user_bonus = $this->user_third->select_user_bonus($user_phone);
 //      $user_email = $this->user_third->select_user_email($user->id);
 //      $user_zipcode = $this->user_third->select_user_zipcode($user->id);
 //      $referring  = $this->referral_program_model->select_referring($user->id);
 //      $referred   = $this->referral_program_model->select_referred($user->id);
 //      $referred_first   = $this->referral_program_model->select_referred_first($user->id);
 //      $auto_status = $this->user_profiles->get($user->id)->auto_status;

 //      $this->user_tokens->delete($user->id);

 //      $token = md5(microtime().rand());

 //      $user_token = array(
 //        'user_id' => $user->id,
 //        'token' => $token,
 //        'timestamp' => time(),
 //      );

 //      $this->user_tokens->insert($user_token);

 //      $message = [
 //        'status' => REST_Controller::HTTP_OK,
 //        'user_id' => $user->id,
 //        'user_level' => $user->level,
 //        'phone' => isset($user_phone) ? $user_phone : '',
 //        'bonus' => isset($user_bonus) ? $user_bonus : '0',
 //        'autorefill' => $auto_status ? '1' : '0',
 //        'referring' => $referring ? '1' : '0',
 //        'referred' => $referred ? '1' : '0',
 //        'account_referred' => $referred_first ? '1' : '0',
 //        'email' => isset($user_email) ? $user_email : '',
 //        'zipcode' => isset($user_zipcode) ? $user_zipcode : '',
 //        'token' => $token,
 //      ];

 //      $current_user_mobile_account = $this->user_mobile_account->get($user->id);

 //      if (!$current_user_mobile_account) {
 //        $message = [
 //          'status' => REST_Controller::HTTP_NOT_FOUND,
 //          'message' => 'User account not found.',
 //        ];

 //        return $message;
 //      }

 //      $message['account_number'] = $current_user_mobile_account->account_number;
 //      $message['account_balance'] = strval($current_user_mobile_account->balance+$current_user_mobile_account->bonus_balance);

 //      if ($user->level == $this->config->item('user_tenant', 'tank_auth')) {
 //        if ($user->cardnumber) {
 //          $message['card_number'] = $user->cardnumber;
 //          $message['card_balance'] = (string)$this->card_balance->get($user->cardnumber);
 //        }
 //      }

 //      return $message;
 //    } else {
 //              $message['message'] = 'User does not exist.';
 //           }
 //    return $message;
 //  }

}
