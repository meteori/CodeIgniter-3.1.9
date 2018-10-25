<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'aliyun-openapi-php-sdk-master/aliyun-php-sdk-core/Config.php';
use \Iot\Request\V20180120 as Iot;

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		//设置你的AccessKeyId/AccessSecret/ProductKey
		// $accessKeyId = "LTAIwOrIrQK8GLc2";
		// $accessSecret = "kQ07a09Bm72qgAfLivTlxXhGfv2JDC";
		// $iClientProfile = DefaultProfile::getProfile("cn-shanghai", $accessKeyId, $accessSecret);
		// $client = new DefaultAcsClient($iClientProfile);

		// $request = new Iot\PubRequest();
		// $request->setProductKey("a1dSHKlSbBX");
		// $request->setMessageContent("SGVsbG8lMkMlMjBMaW5jb2xuLg=="); //hello world Base64 String.
		// $request->setTopicFullName("/a1dSHKlSbBX/test/get"); //消息发送到的Topic全名.
		// $response = $client->getAcsResponse($request);
		// print_r($response);

		$this->load->view('welcome_message');
	}

	public function corporate()
	{
		$this->load->view('corporate_website');
	}

	public function landing()
	{
		$this->load->view('landing_page');
	}

	public function landing_two()
	{
		$this->load->view('landing_page_2');
	}
}
