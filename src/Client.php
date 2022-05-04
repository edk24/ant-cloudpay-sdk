<?php

namespace aop;

use aop\utils\SignUtil;
use RuntimeException;

/**
 * 云支付 请求客户端
 * 
 * @author 余小波 <1421926943@qq.com>
 */
class Client
{
    protected $req;

    /**
     * 云支付配置
     *
     * @var \aop\Config
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
     * @return \aop\Response
     */
    public function execute(string $method, array $biz_content): Response {

        $biz_content['cp_mid']      = $this->config->getCpMid();

        $postData = array(
            'b_app_id'          => $this->config->getBAppId(),
            'version'           => $this->config->getVersion(),
            'method'            => $method,
            'req_id'            => time(), // TODO 请求ID
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

    

    

    // private function setupCharsets($request){
    //     if ($this->checkEmpty($this->config->getCharset())) {
    //         $this->charset = 'UTF-8';
    //     }
    //     $str = preg_match('/[\x80-\xff]/', $this->b_app_id) ? $this->b_app_id : print_r($request, true);
    //     $this->fileCharset = mb_detect_encoding($str, "UTF-8, GBK") == 'UTF-8' ? 'UTF-8' : 'GBK';
    // }


    

    
}
