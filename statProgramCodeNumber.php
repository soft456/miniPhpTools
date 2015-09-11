<?php

/**
 *
 * 统计源代码行数
 *
 * @author soft456@gmail.com
 * @date 2014-08-14
 * @varsion 1.0
 *
 * @copyright  Copyright (c) 2014 Wuhan Bo Sheng Education Information Co., Ltd.
 */
function statRowNumbersByDir($pathName, $exts, &$retData)
{
    foreach (glob($pathName) as $fileName) {
        if (is_dir($fileName)) {
            statRowNumbersByDir($fileName . DIRECTORY_SEPARATOR . '*', $exts, $retData);
            continue;
        }

        if (in_array(pathinfo($fileName, PATHINFO_EXTENSION), $exts)) {
            $numbers = fileRowCount($fileName);
            $codeStr = file_get_contents($fileName);
            preg_match_all('/\*.*(@author|@modify)(.*?)(\\n|\*)/i', $codeStr, $authorRs);
//            echo '<br>' . $fileName . ' => ' . $numbers . '<br>';
            (is_array($authorRs) && isset($authorRs[2])) && $retData = statAdd($retData, $authorRs[2], $numbers);
        }
    }

    return $retData;
}

/**
 *  作者的代码行数增加
 * 
 * @param array $retData  总结果
 * @param array $authorRs 所有作者数组
 * @param int $numbers 当前文件的行数
 * @return array
 */
function statAdd($retData, $authorRs, $numbers)
{

    $authorNoRepeatRs = array_unique($authorRs);
    foreach ($authorNoRepeatRs as $value) {
        $author = trim($value);
        $retData[$author] = $retData[$author] + $numbers;
    }
    return $retData;
}

/**
 *  获取文件行数
 * 
 * @param string $fileName
 * @return int
 */
function fileRowCount($fileName)
{
    $line = 0; //初始化行数
    //
    //打开文件
    $fp = fopen($fileName, 'r');
    if ($fp) {
        //获取文件的一行内容，注意：需要php5才支持该函数；
        while (!feof($fp)) {
            stream_get_line($fp, 65535, "\n");
            $line++;
        }
        fclose($fp); //关闭文件
    }
    //输出行数；
    return $line;
}

if ($_POST['btn']) {

    $olePath = trim($_POST['path']);
    $path = $olePath . DIRECTORY_SEPARATOR . '*';
    $exts = $_POST['ext_name'];
    $outFileName = $olePath . substr($olePath, strrpos($olePath, DIRECTORY_SEPARATOR)) . '.txt';
    header("Content-type: text/html; charset=utf-8");
    $data = statRowNumbersByDir($path, explode('|', $exts));

    ksort($data);

    print_r($data);
    exit;

    echo file_put_contents($outFileName, $data, FILE_APPEND);
    echo '<br><br><a href="">返回</a>';
    exit;
}
?>

<FORM METHOD=POST ACTION="">
    目录：<INPUT TYPE="text" size="60" name="path" value="E:\codeStat\xsc2014">
    扩展名：<INPUT TYPE="text" name="ext_name" value="php|js"> 如：php|java
    <INPUT TYPE="submit" name="btn" value="生成文档">
</FORM>