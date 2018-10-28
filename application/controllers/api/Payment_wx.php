<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
* Payment_wx API.
* @author Vim Ji <vim.jxl@gmail.com>
* Date Created: 2018-10-28
*/
class Payment_wx extends REST_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->model('Payment_model');
  }

  public function onLogin_get()
  {
    $code = $this->get('code');

    if (empty($code))
    {
      $message = [
        'status' => '201',
        'code' => $code
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    $appid = $this->config->item('appid');
    $secret = $this->config->item('secret');
    $code = $code;     //微擎获取前台上传的code值
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';

    $info = file_get_contents($url);//get请求网址，获取数据

    $json = json_decode($info);//对json数据解码

    $arr = get_object_vars($json);//返回一个数组。获取$json对象中的属性，组成一个数组

    $openid = $arr['openid'];

    $session_key = $arr['session_key'];

    if(empty($openid) or empty($session_key))
    {
      $message = [
        'status' => '202',
        'openid' => $openid,
        'session_key' => $session_key,
        'message' => $info
      ];

      $this->set_response($message, $message['status']);
    }
    else
    {
      $message = [
        'status' => '200',
        'openid' => $openid,
        'session_key' => $session_key,
        'message' => $info
      ];

      $this->set_response($message, $message['status']);
    }
  }

  public function pre_sale_post()
  {
    $code = $this->post('code');

    if (empty($code))
    {
      $message = [
        'status' => '201',
        'code' => $code
      ];

      $this->set_response($message, $message['status']);
      return;
    }

    $appid = $this->config->item('appid');
    $secret = $this->config->item('secret');
    // $code = $code;     //微擎获取前台上传的code值
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';

    $info = file_get_contents($url);//get请求网址，获取数据
    $json = json_decode($info);//对json数据解码
    $arr = get_object_vars($json);//返回一个数组。获取$json对象中的属性，组成一个数组

    $openid = $arr['openid'];
    $session_key = $arr['session_key'];

    if(empty($openid) or empty($session_key))
    {
      $message = [
        'status' => '202',
        'openid' => $openid,
        'session_key' => $session_key,
        'message' => $json
      ];

      $this->set_response($message, $message['status']);
      return;
    }
 
    $data['openid'] = $openid;
    $data_total = 1;  //0.01 rmb
    $data['crsNo'] = 'W'.date('YmdHis',time()).'-'.$this->randomkeys(2);
    // $insertId = M('home_order','xxf_witkey_')->add($data);
    $insertId = $this->Payment_model->insert_new_order($data);
    if($insertId)
    {
      $this->insertID = $insertId;
      $this->data_total = $data_total;  //订单总金额，单位分
      /* 调用微信【统一下单】 */
      $this->pay($data_total,$data['openid'],$data['crsNo']);
    }
    else
    {
      // echo $insertId;
      $message = [
        'status' => '203',
        'openid' => $openid,
        'session_key' => $session_key,
        'insertId' => $insertId
      ];

      $this->set_response($message, $message['status']);

    }

    return; 
  }

/* 小程序报名，生成订单 */
  // public function make_order_post(){
  //   $data['openid'] = $this->post('openid');
  //   $data_total = 1;  //0.01 rmb
  //   $data['crsNo'] = 'W'.date('YmdHis',time()).'-'.randomkeys(2);
  //   // $insertId = M('home_order','xxf_witkey_')->add($data);
  //   $insertId = $this->terminals->insert_new_order($data);
  //   if($insertId){
  //       $this->insertID = $insertId;
  //       $this->data_total = $data_total;  //订单总金额，单位分
  //       /* 调用微信【统一下单】 */
  //       $this->pay($data_total,$data['openid'],$data['crsNo']);
  //   }else{
  //       echo $insertId;
  //   }
  //   //echo json_encode($re);
  // }
  


/* 首先在服务器端调用微信【统一下单】接口，返回prepay_id和sign签名等信息给前端，前端调用微信支付接口 */
  private function Pay($total_fee,$openid,$order_id){
      if(empty($total_fee)){
          // echo json_encode(array('state'=>0,'Msg'=>'金额有误'));exit;
        $message = [
          'status' => '204',
          'message' => 'wrong money'
        ];

        $this->set_response($message, $message['status']);
        return;
      }
      if(empty($openid)){
          // echo json_encode(array('state'=>0,'Msg'=>'登录失效，请重新登录(openid参数有误)'));exit;
        $message = [
          'status' => '205',
          'message' => 'openid error'
        ];

        $this->set_response($message, $message['status']);
        return;
      }
      if(empty($order_id)){
          // echo json_encode(array('state'=>0,'Msg'=>'自定义订单有误'));exit;
        $message = [
          'status' => '206',
          'message' => 'self order id error'
        ];

        $this->set_response($message, $message['status']);
        return;
      }
      $appid = $this->config->item('appid');//如果是公众号 就是公众号的appid;小程序就是小程序的appid
      $body = 'anlun tech';
      $mch_id = $this->config->item('merchantid');
      $KEY = $this->config->item('apikey');
      $nonce_str = $this->randomkeys(32);//随机字符串
      $notify_url = 'https://www.anlun.online/api/Payment_wx/payment_wx_notify';  //支付完成回调地址url,不能带参数
      $out_trade_no = $order_id;//商户订单号
      $spbill_create_ip = $this->config->item('SERVER_ADDR');
      $trade_type = 'JSAPI';//交易类型 默认JSAPI
  
      //这里是按照顺序的 因为下面的签名是按照(字典序)顺序 排序错误 肯定出错
      $post['appid'] = $appid;
      $post['body'] = $body;
      $post['mch_id'] = $mch_id;
      $post['nonce_str'] = $nonce_str;//随机字符串
      $post['notify_url'] = $notify_url;
      $post['openid'] = $openid;
      $post['out_trade_no'] = $out_trade_no;
      $post['spbill_create_ip'] = $spbill_create_ip;//服务器终端的ip
      $post['total_fee'] = intval($total_fee);        //总金额 最低为一分钱 必须是整数
      $post['trade_type'] = $trade_type;
      $sign = $this->MakeSign($post,$KEY);              //签名
      $this->sign = $sign;
  
      $post_xml = '<xml>
             <appid>'.$appid.'</appid>
             <body>'.$body.'</body>
             <mch_id>'.$mch_id.'</mch_id>
             <nonce_str>'.$nonce_str.'</nonce_str>
             <notify_url>'.$notify_url.'</notify_url>
             <openid>'.$openid.'</openid>
             <out_trade_no>'.$out_trade_no.'</out_trade_no>
             <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
             <total_fee>'.$total_fee.'</total_fee>
             <trade_type>'.$trade_type.'</trade_type>
             <sign>'.$sign.'</sign>
          </xml> ';
  
      //统一下单接口prepay_id
      $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
      $xml = $this->http_request($url,$post_xml);     //POST方式请求http
      // $array = $this->xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写
      // if($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS'){
      //     $time = time();
      //     $tmp='';                            //临时数组用于签名
      //     $tmp['appId'] = $appid;
      //     $tmp['nonceStr'] = $nonce_str;
      //     $tmp['package'] = 'prepay_id='.$array['PREPAY_ID'];
      //     $tmp['signType'] = 'MD5';
      //     $tmp['timeStamp'] = "$time";
  
      //     $data['state'] = 1;
      //     $data['timeStamp'] = "$time";           //时间戳
      //     $data['nonceStr'] = $nonce_str;         //随机字符串
      //     $data['signType'] = 'MD5';              //签名算法，暂支持 MD5
      //     $data['package'] = 'prepay_id='.$array['PREPAY_ID'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
      //     $data['paySign'] = $this->MakeSign($tmp,$KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;
      //     $data['out_trade_no'] = $out_trade_no;
  
      //     $message = [
      //       'status' => '200',
      //       'data' => $data
      //     ];

      //     $this->set_response($message, $message['status']);
      //     return;

      // }else{
      //     $data['state'] = 0;
      //     $data['text'] = "错误";
      //     $data['return_code'] = $array['RETURN_CODE'];
      //     $data['return_msg'] = $array['RETURN_MSG'];
      // }
      // echo json_encode($data);

      $message = [
        'status' => '207',
        'data' => (string)$xml
      ];

      $this->set_response($message, $message['status']);
      return;
  }
  
  /**
   * 生成签名, $KEY就是支付key
   * @return 签名
   */
  public function MakeSign( $params,$KEY){
      //签名步骤一：按字典序排序数组参数
      ksort($params);
      $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v
      //签名步骤二：在string后加入KEY
      $string = $string . "&key=".$KEY;
      //签名步骤三：MD5加密
      $string = md5($string);
      //签名步骤四：所有字符转为大写
      $result = strtoupper($string);
      return $result;
  }
  /**
   * 将参数拼接为url: key=value&key=value
   * @param $params
   * @return string
   */
  public function ToUrlParams( $params ){
      $string = '';
      if( !empty($params) ){
          $array = array();
          foreach( $params as $key => $value ){
              $array[] = $key.'='.$value;
          }
          $string = implode("&",$array);
      }
      return $string;
  }
  /**
   * 调用接口， $data是数组参数
   * @return 签名
   */
  public function http_request($url,$data = null,$headers=array())
  {
      $curl = curl_init();
      if( count($headers) >= 1 ){
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      }
      curl_setopt($curl, CURLOPT_URL, $url);
  
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
  
      if (!empty($data)){
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      }
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
  }
  //获取xml里面数据，转换成array
  private function xml2array($xml){
      $p = xml_parser_create();
      xml_parse_into_struct($p, $xml, $vals, $index);
      xml_parser_free($p);
      $data = "";
      foreach ($index as $key=>$value) {
          if($key == 'xml' || $key == 'XML') continue;
          if(is_array($vals))
          {
            $tag = $vals[$value[0]]['tag'];
            $value = $vals[$value[0]]['value'];
            $data[$tag] = $value;    
          }
      }
      return $data;
  }

  /**
   * 将xml转为array
   * @param string $xml
   * return array
   */
  public function xml_to_array($xml){
      if(!$xml){
          return false;
      }
      //将XML转为array
      //禁止引用外部xml实体
      libxml_disable_entity_loader(true);
      $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
      return $data;
  }

  /* 微信支付完成，回调地址url方法 */
  public function payment_wx_notify_post(){
    // $post = post_data();    //接受POST数据XML个数
    $post = $this->post();

    $post_data = $this->xml_to_array($post);   //微信支付成功，返回回调地址url的数据：XML转数组Array
    $postSign = $post_data['sign'];
    unset($post_data['sign']);
    
    /* 微信官方提醒：
     *  商户系统对于支付结果通知的内容一定要做【签名验证】,
     *  并校验返回的【订单金额是否与商户侧的订单金额】一致，
     *  防止数据泄漏导致出现“假通知”，造成资金损失。
     */
    ksort($post_data);// 对数据进行排序
    $str = $this->ToUrlParams($post_data);//对数组数据拼接成key=value字符串
    $user_sign = strtoupper(md5($post_data));   //再次生成签名，与$postSign比较
    
    $where['crsNo'] = $post_data['out_trade_no'];
    // $order_status = M('home_order','xxf_witkey_')->where($where)->find();
    
    if($post_data['return_code']=='SUCCESS'&&$postSign){
        /*
        * 首先判断，订单是否已经更新为ok，因为微信会总共发送8次回调确认
        * 其次，订单已经为ok的，直接返回SUCCESS
        * 最后，订单没有为ok的，更新状态为ok，返回SUCCESS
        */
        if($order_status['order_status']=='ok'){
            $this->return_success();
        }else{
            $updata['order_status'] = 'ok';
            // if(M('home_order','xxf_witkey_')->where($where)->save($updata)){
            //     $this->return_success();
            // }

            $this->return_success();
        }
    }else{

      $message = [
        'status' => '201',
        'message' => 'wechat pay failed'
      ];

      $this->set_response($message, $message['status']);
    }
  }
  
  /*
   * 给微信发送确认订单金额和签名正确，SUCCESS信息 -xzz0521
   */
  private function return_success(){
      $return['return_code'] = 'SUCCESS';
      $return['return_msg'] = 'OK';
      $xml_post = '<xml>
                  <return_code>'.$return['return_code'].'</return_code>
                  <return_msg>'.$return['return_msg'].'</return_msg>
                  </xml>';
      
      $message = [
        'status' => '200',
        'message' => $xml_post
      ];

      $this->set_response($message, $message['status']);

  }


  function randomkeys($length)
  {
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ'; //字符池
    $key = '';

    for($i=0;$i<$length;$i++)
    {
      $key .= $pattern{mt_rand(0,35)}; //生成php随机数
    }

    return $key;
  }

  function randomkeys2($length)
  {
    $output='';
    for ($a = 0; $a < $length; $a++) {
      $output .= chr(mt_rand(33, 126)); //生成php随机数
    }
    return $output;
  }  
}
