<?php

namespace cloudpay\utils;

/**
 * 公共帮助类
 * 
 * @author 余小波 <yuxiaobo64@gmail.com>
 */
class CommonUtil {

    /**
     * 内容是否为空
     * 
     * @param  $value
     * @return bool
     */
    public static function checkEmpty($value): bool
    {
        if (!isset($value)) return true;
        if ($value === null) return true;
        if (trim($value) === "") return true;
        return false;
    }


    /**
     * 获取全球唯一标识
     * @return string
     */
    public static function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}