<?php

$str = '';
var_dump(isStringHavValue($str));

$str = null;
var_dump(isStringHavValue($str));

$str = "";
var_dump(isStringHavValue($str));

$str = '中国';
var_dump(isStringHavValue($str, 7));
exit;

function isStringHavValue($str, $len = 1) {
    $strongTypeStr = toUtf8((string) $str);

    return (strlen($strongTypeStr) >= $len);
}

function toUtf8($data) {
    //字符串
    if (!is_array($data)) {
        if ($data === iconv('UTF-8', 'UTF-8//IGNORE', $data)) {
            return $data;
        }

        return getUTFString($data);
    }

    foreach ($data as &$value) {
        $value = toUtf8($value);
    }

    return $data;
}

function getUTFString($string) {
    $encoding = mb_detect_encoding($string, array('ASCII', 'GB2312', 'GBK', 'BIG5'));
    return mb_convert_encoding($string, 'utf-8', $encoding);
}
