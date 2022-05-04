<?php
namespace aop\test;

require_once dirname(__DIR__) . '/src/Config.php';
require_once dirname(__DIR__) . '/src/utils/CommonUtil.php';
require_once dirname(__DIR__) . '/src/utils/SignUtil.php';
require_once dirname(__DIR__) . '/src/Client.php';
require_once dirname(__DIR__) . '/src/Response.php';



use aop\Client;
use aop\Config;
use PHPUnit\Framework\TestCase;

class AopTest extends TestCase  {

    protected $aop;

    /**
     * 条码支付
     * 
     * @test
     */
    public function testBarCodePay() {

        $config = new Config();
        $config->setBAppId('B08430531194');
        $config->setGateway('http://ecogatewaysit.alipay-eco.com/gateway.do');
        $config->setRsaPrivateKey('MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCCToY6TukF4ouWU8VEL+gI+vJBl0+tAWdMbyO93QDsnHzxtfKiHnbKCXV16lO6Za/WerujOOE+hr+XSUu9Lt4thTVXrUb+4aSwsp0rL/6B6Tf2MHCTicyMPtY9HAQgOEeUKuyHbM2HAFyeH+dtICgeziuQGRaH7NLE8FGEQIKDcu8T4M3b5docSNZRb1h8zH7g8u9qlhpJ7yHG6hFdCrqjEYv6zWkXjlteLGpVnglV8x3JGn2IcyTzeE9xAuDeMHDQPVpU72nW+g49pWOOxI/S6xKnxgs14A2H5W9ZoBKe2F8CxczfGVMGB16X04dsti20rxKmNtRATs2G6/P8qC9NAgMBAAECggEAdpqIfBwE5xFbohlfbP/5v+rBg8f4gmzLm/tw2ciFpdeNtee5D6yQzLYtToVZbkhN8vdFQHxuMB4v1sClCm3VVjNv6PzTqPyyjQ4WFhAaJB6ljBRs8y0ym9g54edVLgprxEYJgf4bWCyRIG/DkkT5n4hiiEb9hfydnxlp6Olaoc81NUkm4Ufq55tL6DvI/xYU4TTxgKe7wXbTqA55Yh5War3inCotNwQVIktsvLMm7Cb6gaCH4BskUHAE1xRMTAYk0GJB6QHIASRNBk69VS3zquqFqyYxIt13f0+nq6FZZd1XWeWgpwbYXGOT3AvUAkLdxNj5QNsBKomK5j5RX8SSFQKBgQDOKqjGjfYwUQTIRkhHbCFlkvo7AbaE0plT2zDMJpc8dA2f7nKPfJbuMM6j06RM2n78IMR2AsnbyIQV3QSaR0wwtAHcFGIoQHXHYszDya4KDoMKQkWke7O9TC/S+29Rf98NJyPzBcM96Tb213rtXRdQakmj7thRNQiySOy2TgluowKBgQChzb8g2cRVjAydBogmoqkiKC84+KM95QSlFQezyc0YdXTy/wanu0J+uVx1L2IzT9aWU8PZm4bs20zIEGcY4L11hqOFYSGAfZ6hhptXVyO2G9N4owtMdCGQzCby02zAUUpDZOVTbqyb0BwsRV7sUpVZiNYUKMqjsCnvLThZ7vx5TwKBgG169dlKtbt+qp13xRY4c5uu6za+eCAcfdOsCEPBEnrF3h5Zz3gm3zdpr7ILx6oQNXLKK8nHPU57Mrkxfyo2Rl1umbY3FNDvOhxBeR9XUBaDEk82Vik8j3wsoxDU+I4860PezxZUrxOHbuqyDtNRpfnMF4L4aOLm2NFkLF+7HQMlAoGBAIOTGOIw05wxN6yVPDAWw+y3urbcUXqqel13vXyxFGvYT9KuGY5aE5eTSiEs9/D78mbqFPAmrdB8AHMMC5pKXyZr5xs2QhUHkfCN0lJy1OJovE10YGK6aPUjXmTGEsBNGlO1f1qaPBi0YcSKYMdR3IsjX9qi1S3IukD5h8JyObK3AoGARy4yBHuSCsA/Ras3GwULMz86rGcTkqw2xaB8AiLNF7PwJmvDN2fPiHUQq4WT2lRcMPbQ+pfwYsw1ZS6kWmue8qdhTfEcmAHCV55FIBBjJ9zV40hsQXnFNYzth3EO23ZZuiXiijm6VvR6S/cFvd/wTto2BSy3wUzbiYBVlPUf8No=');
        $config->setAliPublicKey('MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgk6GOk7pBeKLllPFRC/oCPryQZdPrQFnTG8jvd0A7Jx88bXyoh52ygl1depTumWv1nq7ozjhPoa/l0lLvS7eLYU1V61G/uGksLKdKy/+gek39jBwk4nMjD7WPRwEIDhHlCrsh2zNhwBcnh/nbSAoHs4rkBkWh+zSxPBRhECCg3LvE+DN2+XaHEjWUW9YfMx+4PLvapYaSe8hxuoRXQq6oxGL+s1pF45bXixqVZ4JVfMdyRp9iHMk83hPcQLg3jBw0D1aVO9p1voOPaVjjsSP0usSp8YLNeANh+VvWaASnthfAsXM3xlTBgdel9OHbLYttK8SpjbUQE7Nhuvz/KgvTQIDAQAB');
        $config->setCpMid('20191129183400001459645700000072');

        $req = new Client($config);
        $resp = $req->execute('ant.antfin.eco.cloudpay.trade.pay', array(
            'out_order_no'      => '545454345',
            'scene'             => 'bar_code',
            'total_amount'      => '0.01',
            'auth_code'         => '28763443825664394',
            'subject'           => 'Iphone6 16G',
            'body'              => 'Iphone6 16G',
            'notify_url'        => '2145',
            // 云支付商户门店编号
            'cp_store_id'       => '20200901145300003099286200000650'
        ));
        // var_dump($resp);
        
        $this->assertIsBool($resp->code === '10000');
    }


    /**
     * 退款
     * 
     * @test
     */
    public function testRefund() {

        $config = new Config();
        $config->setBAppId('B08430531194');
        $config->setGateway('http://ecogatewaysit.alipay-eco.com/gateway.do');
        $config->setRsaPrivateKey('MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCCToY6TukF4ouWU8VEL+gI+vJBl0+tAWdMbyO93QDsnHzxtfKiHnbKCXV16lO6Za/WerujOOE+hr+XSUu9Lt4thTVXrUb+4aSwsp0rL/6B6Tf2MHCTicyMPtY9HAQgOEeUKuyHbM2HAFyeH+dtICgeziuQGRaH7NLE8FGEQIKDcu8T4M3b5docSNZRb1h8zH7g8u9qlhpJ7yHG6hFdCrqjEYv6zWkXjlteLGpVnglV8x3JGn2IcyTzeE9xAuDeMHDQPVpU72nW+g49pWOOxI/S6xKnxgs14A2H5W9ZoBKe2F8CxczfGVMGB16X04dsti20rxKmNtRATs2G6/P8qC9NAgMBAAECggEAdpqIfBwE5xFbohlfbP/5v+rBg8f4gmzLm/tw2ciFpdeNtee5D6yQzLYtToVZbkhN8vdFQHxuMB4v1sClCm3VVjNv6PzTqPyyjQ4WFhAaJB6ljBRs8y0ym9g54edVLgprxEYJgf4bWCyRIG/DkkT5n4hiiEb9hfydnxlp6Olaoc81NUkm4Ufq55tL6DvI/xYU4TTxgKe7wXbTqA55Yh5War3inCotNwQVIktsvLMm7Cb6gaCH4BskUHAE1xRMTAYk0GJB6QHIASRNBk69VS3zquqFqyYxIt13f0+nq6FZZd1XWeWgpwbYXGOT3AvUAkLdxNj5QNsBKomK5j5RX8SSFQKBgQDOKqjGjfYwUQTIRkhHbCFlkvo7AbaE0plT2zDMJpc8dA2f7nKPfJbuMM6j06RM2n78IMR2AsnbyIQV3QSaR0wwtAHcFGIoQHXHYszDya4KDoMKQkWke7O9TC/S+29Rf98NJyPzBcM96Tb213rtXRdQakmj7thRNQiySOy2TgluowKBgQChzb8g2cRVjAydBogmoqkiKC84+KM95QSlFQezyc0YdXTy/wanu0J+uVx1L2IzT9aWU8PZm4bs20zIEGcY4L11hqOFYSGAfZ6hhptXVyO2G9N4owtMdCGQzCby02zAUUpDZOVTbqyb0BwsRV7sUpVZiNYUKMqjsCnvLThZ7vx5TwKBgG169dlKtbt+qp13xRY4c5uu6za+eCAcfdOsCEPBEnrF3h5Zz3gm3zdpr7ILx6oQNXLKK8nHPU57Mrkxfyo2Rl1umbY3FNDvOhxBeR9XUBaDEk82Vik8j3wsoxDU+I4860PezxZUrxOHbuqyDtNRpfnMF4L4aOLm2NFkLF+7HQMlAoGBAIOTGOIw05wxN6yVPDAWw+y3urbcUXqqel13vXyxFGvYT9KuGY5aE5eTSiEs9/D78mbqFPAmrdB8AHMMC5pKXyZr5xs2QhUHkfCN0lJy1OJovE10YGK6aPUjXmTGEsBNGlO1f1qaPBi0YcSKYMdR3IsjX9qi1S3IukD5h8JyObK3AoGARy4yBHuSCsA/Ras3GwULMz86rGcTkqw2xaB8AiLNF7PwJmvDN2fPiHUQq4WT2lRcMPbQ+pfwYsw1ZS6kWmue8qdhTfEcmAHCV55FIBBjJ9zV40hsQXnFNYzth3EO23ZZuiXiijm6VvR6S/cFvd/wTto2BSy3wUzbiYBVlPUf8No=');
        $config->setAliPublicKey('MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgk6GOk7pBeKLllPFRC/oCPryQZdPrQFnTG8jvd0A7Jx88bXyoh52ygl1depTumWv1nq7ozjhPoa/l0lLvS7eLYU1V61G/uGksLKdKy/+gek39jBwk4nMjD7WPRwEIDhHlCrsh2zNhwBcnh/nbSAoHs4rkBkWh+zSxPBRhECCg3LvE+DN2+XaHEjWUW9YfMx+4PLvapYaSe8hxuoRXQq6oxGL+s1pF45bXixqVZ4JVfMdyRp9iHMk83hPcQLg3jBw0D1aVO9p1voOPaVjjsSP0usSp8YLNeANh+VvWaASnthfAsXM3xlTBgdel9OHbLYttK8SpjbUQE7Nhuvz/KgvTQIDAQAB');
        $config->setCpMid('20191129183400001459645700000072');

        $req = new Client($config);
        $resp = $req->execute('ant.antfin.eco.cloudpay.trade.refund', array(
            'out_order_no'      => '545454345', // 商户订单号,和第三方支付号不能同时为空
            // 'trans_no'          => '12131', // 第三方支付号，和商户订单号不能同时为空
            'refund_amount'      => '0.01', // 退款金额
            'out_request_no'    => '131324', // 外部退款单号，标识一次退款请求
            'notify_url'        => '2145',
            // 'pay_channel'       => 'alipay', // 第三方支付类型，如果选择trans_no，则不能为空 [alipay, wechat]
            // 云支付商户门店编号
        ));
        var_dump($resp);
        
        $this->assertIsBool($resp->code === '10000');
    }
}