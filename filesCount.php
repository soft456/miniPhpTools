<?php

/**
 *
 * 统计文件棵树
 *
 * @author soft456@gmail.com
 * @date 2014-01-21
 * @varsion 1.0
 *
 * @copyright  Copyright (c) 2014 Wuhan Bo Sheng Education Information Co., Ltd.
 */
function getDirFiles($pathName, $exts, &$count)
{
    foreach (glob($pathName) as $fileName) {
        if (is_dir($fileName)) {
            getDirFiles($fileName . DIRECTORY_SEPARATOR . '*', $exts, $count);
        } else {
            if (in_array(pathinfo($fileName, PATHINFO_EXTENSION), $exts)) {
                $count ++ ;
            }
        }
    }
    return 'Completed! Count:'.$count;
}

if ($_POST['btn']) {

    $olePath = trim($_POST['path']);
    $path = $olePath . DIRECTORY_SEPARATOR . '*';
    $exts = $_POST['ext_name'];
    $count = 0;
    header("Content-type: text/html; charset=utf-8");
    echo getDirFiles($path, explode('|', $exts), $count);
    echo '<br><br><a href="">返回</a>';
    exit;
}
?>

<FORM METHOD=POST ACTION="">
    目录：<INPUT TYPE="text" name="path" value="E:\codeForWord\yjxj2013">
    扩展名：<INPUT TYPE="text" name="ext_name" value="php|js"> 如：php|java
    <INPUT TYPE="submit" name="btn" value="统计文件个数">
</FORM>