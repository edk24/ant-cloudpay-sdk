<?php
namespace aop;

/**
 * 云支付配置
 * 
 * @author 余小波 <1421926943@qq.com>
 */
class Config {

    private $gateway = 'https://ecogateway.alipay-eco.com/gateway.do';
    private $bAppId;
    private $version = '1.0';
    private $charset = 'utf-8';
    private $signType = 'RSA2';
    private $cpMid;
    private $rsaPrivateKey = '';
    private $aliPublicKey = '';
    private $rsaPrivateKeyFilePath = '';

    /**
     * 获取签名方式
     */ 
    public function getSignType()
    {
        return $this->signType;
    }

    /**
     * 设置签名方式
     *
     * @return  self
     */ 
    public function setSignType($sign_type)
    {
        $this->sign_type = $sign_type;

        return $this;
    }

    /**
     * 获取编码
     */ 
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * 设置编码
     *
     * @return  self
     */ 
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * 获取接口版本号
     */ 
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * 设置接口版本号
     *
     * @return  self
     */ 
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * 获取 应用 ID
     */ 
    public function getBAppId()
    {
        return $this->bAppId;
    }

    /**
     * 设置应用 ID
     *
     * @return  self
     */ 
    public function setBAppId($b_app_id)
    {
        $this->bAppId = $b_app_id;

        return $this;
    }

    /**
     * Get the value of gateway
     */ 
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * Set the value of gateway
     *
     * @return  self
     */ 
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;

        return $this;
    }

    /**
     * 获取商户 ID
     */ 
    public function getCpMid()
    {
        return $this->cpMid;
    }

    /**
     * 设置商户 ID
     *
     * @return  self
     */ 
    public function setCpMid($cp_mid)
    {
        $this->cpMid = $cp_mid;

        return $this;
    }

    /**
     * 获取私钥
     */ 
    public function getRsaPrivateKey()
    {
        return $this->rsaPrivateKey;
    }

    /**
     * 设置私钥
     *
     * @return  self
     */ 
    public function setRsaPrivateKey($rsaPrivateKey)
    {
        $this->rsaPrivateKey = $rsaPrivateKey;

        return $this;
    }

    /**
     * 获取公钥
     */ 
    public function getAliPublicKey()
    {
        return $this->aliPublicKey;
    }

    /**
     * 设置公钥
     *
     * @return  self
     */ 
    public function setAliPublicKey($aliPublicKey)
    {
        $this->aliPublicKey = $aliPublicKey;

        return $this;
    }

    /**
     * 获取私钥路径
     */ 
    public function getRsaPrivateKeyFilePath()
    {
        return $this->rsaPrivateKeyFilePath;
    }

    /**
     * 设置私钥路径
     *
     * @return  self
     */ 
    public function setRsaPrivateKeyFilePath($rsaPrivateKeyFilePath)
    {
        $this->rsaPrivateKeyFilePath = $rsaPrivateKeyFilePath;

        return $this;
    }
}