<?php

namespace cloudpay;

use cloudpay\utils\CommonUtil;
use cloudpay\utils\SignUtil;
use RuntimeException;

/**
 * 云支付 请求客户端
 * 
 * @author 余小波 <yuxiaobo64@gmail.com>
 */
class Client
{
    protected $req;

    /**
     * 云支付配置
     *
     * @var \cloudpay\Config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->req = new \GuzzleHttp\Client([
            'base_uri'        => '',
            'timeout'         => 0,
            'debug'           => false
        ]);
    }


    /**
     * 执行 API
     *
     * @param string $method 方法
     * @param array $biz_content 参数
     * @return \cloudpay\Response
     */
    public function execute(string $method, array $biz_content): Response {

        $biz_content['cp_mid']      = $this->config->getCpMid();

        $postData = array(
            'b_app_id'          => $this->config->getBAppId(),
            'version'           => $this->config->getVersion(),
            'method'            => $method,
            'req_id'            => CommonUtil::uuid(), // TODO 请求ID
            'charset'           => $this->config->getCharset(),
            'timestamp'         => time(),
            'sign_type'         => $this->config->getSignType(),
            'biz_content'       => json_encode($biz_content),
        );
        $postData['sign']       = (new SignUtil($this->config, $postData))->generate();
        

        $response = $this->req->post($this->config->getGateway(), [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $postData
        ]);

        return new Response($response->getBody()->getContents());
    }


    /**
     * 验证签名 (验签成功需要返回"success"字符串,  否则视为失败, 云支付会分批重复回调, 详见: https://www.yuque.com/docs/share/c9e415da-70be-4004-852a-3b510fb43b07#pLCPN)
     *
     * @param array $params
     * @return boolean
     * @throws RuntimeException
     */
    public function checkSign(array $params):bool
    {
        $headers = getallheaders();
        if (isset($headers['X-Ca-Signature']) == false || empty($headers['X-Ca-Signature'])) {
            throw new RuntimeException('签名值异常');
        }
        $sign = $headers['X-Ca-Signature'];
        return (new SignUtil($this->config, $params))->checkSign($sign);
    }

    
}
