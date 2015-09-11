<?php

/**
 *
 * 生成项目的源代码WORD文档
 *
 * @author soft456@gmail.com
 * @date 2013-08-02
 * @varsion 1.0
 *
 * @copyright  Copyright (c) 2014 Wuhan Bo Sheng Education Information Co., Ltd.
 */
function getDirFiles($pathName, $exts, $outFp) {
    foreach (glob($pathName) as $fileName) {
        if (is_dir($fileName)) {
            getDirFiles($fileName . DIRECTORY_SEPARATOR . '*', $exts, $outFp);
        } else {
            if (in_array(pathinfo($fileName, PATHINFO_EXTENSION), $exts)) {
                $data = file($fileName);
                array_unshift($data, chr(10), $fileName, chr(10), '---------------------', chr(10)); //文件名插入数据数组开头
                echo $fileName . ':' . file_put_contents($outFp, $data, FILE_APPEND) . '<br>';
            }
        }
    }
    return 'Completed!';
}

if (isset($_POST['btn']) && $_POST['btn']) {

    $olePath = trim($_POST['path']);
    $path = $olePath . DIRECTORY_SEPARATOR . '*';
    $exts = $_POST['ext_name'];
    $outFileName = $olePath . substr($olePath, strrpos($olePath, DIRECTORY_SEPARATOR)) . '.txt';
    header("Content-type: text/html; charset=utf-8");
    echo getDirFiles($path, explode('|', $exts), $outFileName);
    echo '<br><br><a href="">返回</a>';
    exit;
}
?>

<FORM METHOD=POST ACTION="">
    目录：<INPUT TYPE="text" name="path" value="E:\codeForWord\yjxj2013">
    扩展名：<INPUT TYPE="text" name="ext_name" value="php|js"> 如：php|java
    <INPUT TYPE="submit" name="btn" value="生成文档">
</FORM>