<?php
namespace cloudpay\test;

require_once dirname(__DIR__) . '/src/Config.php';
require_once dirname(__DIR__) . '/src/utils/CommonUtil.php';
require_once dirname(__DIR__) . '/src/utils/SignUtil.php';
require_once dirname(__DIR__) . '/src/Client.php';
require_once dirname(__DIR__) . '/src/Response.php';



use cloudpay\Client;
use cloudpay\Config;
use cloudpay\utils\CommonUtil;
use PHPUnit\Framework\TestCase;

// 读取环境变量 (如果你需要测试， 请访问 https://tech.antfin.com/docs/2/157009 获取测试账号)
$env = parse_ini_file('./.env');

class CloudpayTest extends TestCase  {

    protected $aop;

    /**
     * 条码支付
     * 
     * @test
     */
    public function testBarCodePay() {
        global $env;

        $config = new Config();
        $config->setBAppId($env['BAppId']);
        $config->setGateway($env['Gateway']);
        $config->setRsaPrivateKey($env['RsaPrivateKey']);
        $config->setAliPublicKey($env['AliPublicKey']);
        $config->setCpMid($env['CpMid']);

        $req = new Client($config);
        $resp = $req->execute('ant.antfin.eco.cloudpay.trade.pay', array(
            'out_order_no'      => time(),
            'scene'             => 'bar_code',
            'total_amount'      => '0.01',
            'auth_code'         => '130245232381316480',
            'subject'           => 'Iphone6 16G',
            'body'              => 'Iphone6 16G',
            'notify_url'        => 'https://gzhs-iot.dev.ioi.plus/api/alipay/callback',
            // 云支付商户门店编号
            'cp_store_id'       => '20220523111100004612293400055337'
        ));
        var_dump($resp);
        
        $this->assertIsBool($resp->code === '10000');
    }


    /**
     * 退款
     * 
     * @test
     */
    public function testRefund() {
        global $env;

        $config = new Config();
        $config->setBAppId($env['BAppId']);
        $config->setGateway($env['Gateway']);
        $config->setRsaPrivateKey($env['RsaPrivateKey']);
        $config->setAliPublicKey($env['AliPublicKey']);
        $config->setCpMid($env['CpMid']);

        $req = new Client($config);
        $resp = $req->execute('ant.antfin.eco.cloudpay.trade.refund', array(
            'out_order_no'      => '1651719435', // 商户订单号,和第三方支付号不能同时为空
            // 'trans_no'          => '12131', // 第三方支付号，和商户订单号不能同时为空
            'refund_amount'      => '0.01', // 退款金额
            'out_request_no'    => '131324', // 外部退款单号，标识一次退款请求
            'notify_url'        => 'https://gzhs-iot.dev.ioi.plus/api/alipay/callback',
            // 'pay_channel'       => 'alipay', // 第三方支付类型，如果选择trans_no，则不能为空 [alipay, wechat]
            // 云支付商户门店编号
        ));
        // var_dump($resp);
        
        $this->assertIsBool($resp->code === '10000');
    }


    /**
     * 全球唯一ID
     */
    public function testUuid() {
        $d = CommonUtil::uuid();
        var_dump($d);
        $this->assertIsString($d, $d);
    }
}