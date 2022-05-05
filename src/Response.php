<?php

namespace cloudpay;

/**
 * 响应结果
 * 
 * @author 余小波 <yuxiaobo64@gmail.com>
 */
class Response {
    protected $httpBody;

    /**
     * 网关返回码 (成功=10000)
     *
     * @var string
     */
    public $code;

    /**
     * 网关返回码描述
     *
     * @var string
     */
    public $msg;

    /**
     * 原样返回请求的method
     *
     * @var string
     */
    public $method;

    /**
     * 业务返回数据
     *
     * @var mixed
     */
    public $data;

    /**
     * 签名
     *
     * @var string
     */
    public $sign;


    public function __construct(string $httpBody)
    {
        $this->httpBody = $httpBody;

        $resp = json_decode($this->httpBody, true);
        $this->code = $resp['code'];
        $this->msg = $resp['msg'];
        $this->method = $resp['method'];
        $this->sign = $resp['sign'];
        $this->data = $resp['data'];
    }

}