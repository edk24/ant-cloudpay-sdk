<?php

namespace aop\utils;

/**
 * 公共帮助类
 * 
 * @author 余小波 <1421926943@qq.com>
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

}