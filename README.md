 
## 文档

- [云支付开发文档](https://www.yuque.com/docs/share/c9e415da-70be-4004-852a-3b510fb43b07?#dJJrQ)
- [测试账号](https://tech.antfin.com/docs/2/157009)
- [支付服务商申请](https://tech.antfin.com/docs/2/144800)


## 示例

### 条码支付

```php
$config = new Config();
$config->setBAppId('云支付应用ID');
$config->setGateway('云支付网关'); 
$config->setRsaPrivateKey('私钥');
$config->setAliPublicKey('支付宝公钥');
$config->setCpMid('云支付商户id');

$req = new Client($config);
$resp = $req->execute('ant.antfin.eco.cloudpay.trade.pay', array(
    'out_order_no'      => '545454345', // 订单编号
    'scene'             => 'bar_code', // 条形码
    'total_amount'      => '0.01', // 金额: 元
    'auth_code'         => '28763443825664394', // 支付授权码：如果是扫码就是支付宝或者微信付款码对应的那串数字
    'subject'           => 'Iphone6 16G', // 订单标题
    'body'              => 'Iphone6 16G', // 对交易或商品的描述 [非必填]
    'notify_url'        => '2145', // 回调地址
    'cp_store_id'       => '20200901145300003099286200000650' // 云支付商户门店编号
));
```

### 退款


### 回调通知处理

```php


```


### End

*签名部分代码参考官方 `for php` 示例中的封装*