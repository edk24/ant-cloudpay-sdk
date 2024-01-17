
# ant-cloudpay-sdk

开发开源原因：

> 因对接支付宝 IoT 需要，但是蚂蚁云支付官方暂时没有 php 的 sdk，于是决定开发了这个包。开源出来是为了帮助更多的 phper 小伙伴省略去包装 api 的过程，快速出活。

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

```php
$config = new Config();
$config->setBAppId('云支付应用ID');
$config->setGateway('云支付网关'); 
$config->setRsaPrivateKey('私钥');
$config->setAliPublicKey('支付宝公钥');
$config->setCpMid('云支付商户id');

$req = new Client($config);
$resp = $req->execute('ant.antfin.eco.cloudpay.trade.refund', array(
    'out_order_no'      => '1651715489', // 商户订单号,和第三方支付号不能同时为空
    // 'trans_no'          => '12131', // 第三方支付号，和商户订单号不能同时为空
    'refund_amount'      => '0.01', // 退款金额
    'out_request_no'    => '131324', // 外部退款单号，标识一次退款请求
    'notify_url'        => '2145',
    // 'pay_channel'       => 'alipay', // 第三方支付类型，如果选择trans_no，则不能为空 [alipay, wechat]
    // 云支付商户门店编号
));
```

### Notify 通知回调处理

**注意内容**

1. 支付回调是 `POST` 请求, 携带如下 `JSON` 数据的 body
2. 商户收到回调通知，进行对应业务处理后，须要返回处理结果。处理成功返回“success”字符串，处理失败可返回失败原因。
3. 若商户返回失败（即不是“success”），云支付会按照一定的时间间隔，进行重试通知，重试结束后不再通知。重试时间规则，单位秒：15,30,60,300,600,1800,15,30,3600,15,30,7200,14400,28800,57600

*示例数据 (退款)*

```json
{
    "store_id": "20200901145300003099286200000650",
    "wechat_refund_order_content_ext": "{}",
    "notify_time": "1651719765776",
    "refund_status": "REFUND_SUCCESS",
    "trade_channel": "wechat",
    "gmt_refund": "1651719761000",
    "out_order_no": "1651719435",
    "notify_combination_channel_refund_infos": "[]",
    "notify_id": "20220505110200004600083200072234",
    "notify_type": "REFUND_SYNC",
    "total_amount": "0.01",
    "refund_amount": "0.01",
    "trade_no": "4200001421202205052017454108",
    "out_request_no": "131324",
    "refund_order_no": "20220505110200004600036200072231"
}
```

*示例数据 (条码支付)*

```json
{
    "order_no": "20220505105700004600036200072197",
    "store_id": "20200901145300003099286200000650",
    "gmt_payment": "1651719445000",
    "notify_time": "1651719445743",
    "trade_channel": "wechat",
    "subject": "Iphone6 16G",
    "wechat_order_content_ext": "{}",
    "out_order_no": "1651719435",
    "notify_combination_channel_pay_infos": "[]",
    "merchant_id": "20191129183400001459645700000072",
    "body": "Iphone6 16G",
    "buyer_id": "o8uJ6uGXLlPFCpQA-F9UnLPnF3tw",
    "notify_id": "20220505105700004600083200072203",
    "notify_type": "TRADE_SYNC",
    "total_amount": "0.01",
    "isv_id": "20191129153900001401755600000066",
    "trade_status": "ORDER_SUCCESS",
    "trade_no": "4200001421202205052017454108",
    "receipt_amount": "0.01",
    "buyer_pay_amount": "0.01"
}
```


**如何验签**

```php
$success = $aop->checkSign($_POST);
if ($success == false) {
    die('error');
}

die('success');
```

## 感谢

❤️ 感谢所有对项目进行捐助支持的朋友们～

下面是捐助名单，按时间排序

| 捐助时间 | 捐助内容 | 捐助者 |
| --- | --- | --- |
| 2024/01/17 | 100.00 | 大师兄🌵 |


## 问题反馈

如果您在使用过程中遇到了问题，请先反馈 issue

着急使用的话请联系 绿泡泡：Base1024

或是 `fork` 一份自己改，项目遵循 `MIT` 开源协议

请务必反馈 issue