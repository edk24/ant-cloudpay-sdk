<?php

namespace cloudpay\utils;

use cloudpay\Config;
use RuntimeException;

/**
 * 签名辅助类
 * 
 * @author 余小波 <yuxiaobo64@gmail.com>
 */
class SignUtil
{

    protected $params;
    protected $config;

    public function __construct(Config $config, array $params)
    {
        $this->config = $config;
        $this->params = $params;
    }

    /**
     * 获取签名内容
     *
     * @param array $params
     * @return string
     */
    protected function getSignContents(array $params): string
    {
        ksort($params);
        $query_params = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (CommonUtil::checkEmpty($v) === false && substr($v, 0, 1) != '@') {
                // 转换成目标字符集
                $v = $this->characet($v, $this->config->getCharset());
                if ($i == 0) {
                    $query_params .= sprintf('%s=%s', $k, $v);
                } else {
                    $query_params .= sprintf('&%s=%s', $k, $v);
                }
                $i++;
            }
        }
        unset($k, $v);
        return $query_params;
    }

    /**
     * 生成签名
     *
     * @return string
     */
    public function generate(): string
    {
        return $this->sign($this->getSignContents($this->params), $this->config->getSignType());
    }

    /**
     * 签名
     *
     * @param string $data
     * @param string $signType
     * @return string
     */
    protected function sign($data, $signType = "RSA")
    {
        if (CommonUtil::checkEmpty($this->config->getRsaPrivateKeyFilePath())) {
            $priKey = $this->config->getRsaPrivateKey();
            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
                wordwrap($priKey, 64, "\n", true) .
                "\n-----END RSA PRIVATE KEY-----";
        } else {
            $priKey = file_get_contents($this->config->getRsaPrivateKeyFilePath());
            $res = openssl_get_privatekey($priKey);
        }

        if ($res == null) {
            throw new RuntimeException('您使用的私钥格式错误，请检查RSA私钥配置');
        }

        if ($signType == 'RSA2') {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }
        if (!CommonUtil::checkEmpty($this->rsaPrivateKeyFilePath)) {
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 转换字符集编码
     * 
     * @param $data
     * @param $targetCharset
     * @return string
     */
    protected function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }


    /**
     * 验签
     *
     * @param string $sign 要校对的的签名结果
     * @return bool 验证结果
     */
    public function checkSign($sign)
    {
        $data = $this->getSignContents($this->params);
        $signType = $this->config->getSignType();
        $public_key = $this->config->getAliPublicKey();

        $search = [
            "-----BEGIN PUBLIC KEY-----",
            "-----END PUBLIC KEY-----",
            "\n",
            "\r",
            "\r\n"
        ];
        $public_key = str_replace($search, "", $public_key);
        $public_key = $search[0] . PHP_EOL . wordwrap($public_key, 64, "\n", true) . PHP_EOL . $search[1];
        $res = openssl_get_publickey($public_key);
        if ($res) {
            if ("RSA" == $signType) {
                $result = (bool)openssl_verify($data, base64_decode($sign), $res);
                openssl_free_key($res);
            } else if ("RSA2" == $signType) {
                //签名 RSA2
                $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
                openssl_free_key($res);
            }
        } else {
            throw new RuntimeException('签名异常');
        }
        return $result;
    }
}
