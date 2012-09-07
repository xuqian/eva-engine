<?php
namespace Epic\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class PayController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction()
    {
        $res = array();
        $this->layout('layout/coming');
        
        $view = new ViewModel(array(
            'reg' => $this->params()->fromQuery('reg')
        ));
        $view->setTemplate('epic/pay/index');
        return $view;
    }
    
    public function getAction()
    {
        $res = array();
        $this->layout('layout/empty');

        $id = $this->params()->fromRoute('id');
        $price = $this->getRequest()->getQuery('p'); 
        
        if ($id == "paypal" && $price > 0) {
            $this->paypal($price);
        } else if ($id == "alipay" && $price > 0){
            $this->alipay($price);
        }
        
        $view = new ViewModel(array(
            'id' => $id
        ));
        
        $view->setTemplate('epic/pay/index');
        return $view;
    }

    public function paypal($price)
    {
        include (EVA_ROOT_PATH . '/website/Epic/src/Epic/Payment/paypal.class.php');
        $paypal = new \Epic\Payment\paypal_class();             // initiate an instance of the class
        $paypal->paypal_class();
		$paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url

        /*
        if(!$config['paypal']['sandbox']) {
			$paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
		}
        */
        
        $url = \Eva\Api::_()->getView()->ServerUrl() . '/pay/example';

        //buyer_1309337143_per@gmail.com 12345678
        $config['paypal']['account'] = 'ss_1270582781_biz@gmail.com';
        $config['paypal']['orderTitle'] = 'epic test ' . $price;
        $config['paypal']['currency'] = 'USD';
            
        $order_id = $price;
        $hash = md5($price . time());

        $paypal->add_field('charset', 'utf-8');
		$paypal->add_field('business', $config['paypal']['account']);
		$paypal->add_field('return', $url);
		$paypal->add_field('cancel_return', $url);
		$paypal->add_field('notify_url', $url);
		$paypal->add_field('item_name', $config['paypal']['orderTitle']);
		$paypal->add_field('item_number', $price);
		$paypal->add_field('currency_code', $config['paypal']['currency']);
		$paypal->add_field('no_shipping', 1);
		$paypal->add_field('amount', $price);

	    $paypal->add_field("on0", 2012-09-10 . ' ' . 'test' . ' - ' . 'test');
		$paypal->add_field("os0", $price);
 
 		$paypal->submit_paypal_post(); // submit the fields to paypal
    }

    public function alipay($price)
    {
        $url = \Eva\Api::_()->getView()->ServerUrl() . '/pay/example';
        
        $content = "Epic alipay test.";

        $config['alipay']['sandbox'] = 0;
        $config['alipay']['accountType'] = 'create_partner_trade_by_buyer';
        $config['alipay']['partnerId'] = '2088002015728687';
        $config['alipay']['orderTitle'] = 'Epic alipay test.';
        $config['alipay']['account'] = "allo.vince@gmail.com";
        $config['alipay']['securityCode'] = "uanlpqbswv5rpuwucfueynyhyz2hw1r7";
            
        $order_id = $price;
        $hash = md5($price . time());  
        
        $parameter = array(
			"service" => $config['alipay']['accountType'],
			"partner" => $config['alipay']['partnerId'],            
			"return_url" => $url, 
			"_input_charset" => 'utf-8',
			"subject" => $config['alipay']['orderTitle'],                                         
			"body" => $content,                                         
			"out_trade_no" => $order_id,                      
			"logistics_fee"=>'0.00',             
			"logistics_payment"=>'BUYER_PAY',             
			"logistics_type"=>'EXPRESS',    		
			"price" => $config['alipay']['sandbox'] ? 0.1 : $price,                         
			"payment_type"=>"1",               
			"quantity" => "1",                 
			"seller_email" => $config['alipay']['account']             
		);

        include (EVA_ROOT_PATH . '/website/Epic/src/Epic/Payment/alipay_service.php');
        
        $alipay = new \Epic\Payment\alipay_service();
        $alipay->alipay_service($parameter,$config['alipay']['securityCode'],"MD5");
        $link = $alipay->create_url();

        $this->redirect()->toUrl($link);
    }
}
