<?php
/**
 *
 * 生成项目文件头说明文档
 *
 * @author soft456@gmail.com
 * @date 2015-09-13
 *
 * @copyright  Copyright (c) 2015 .
 */
if (isset($_POST['btn']) && $_POST['btn']) {

    $olePath = trim($_POST['path']);
    $exts = trim($_POST['ext_name']);
    $ignoreDir = strtolower(trim($_POST['ignore_dir']));
    header("Content-type: text/html; charset=utf-8");
    echo getDirFiles($olePath . DIRECTORY_SEPARATOR . '*', explode('|', $exts), explode('|', $ignoreDir));
    echo '<br><br><a href="">返回</a>';
    exit;
}

function getDirFiles($pathName, $exts, $ignoreRs = array()) {
    foreach (glob($pathName) as $fileName) {
        //忽略的目录

        $fileNameInfo = pathinfo($fileName);

        if (in_array(strtolower($fileNameInfo['basename']), $ignoreRs)) {
            continue;
        }

        //目录
        if (is_dir($fileName)) {
            echo '<br>Dir ：' . $fileName . '<br>';
            getDirFiles($fileName . DIRECTORY_SEPARATOR . '*', $exts, $ignoreRs);
            continue;
        }

        //文件
        if (in_array(pathinfo($fileName, PATHINFO_EXTENSION), $exts)) {
            $commentTitle = getFileCommentTitle($fileName, 1, 10);
            echo 'File：<a href="makeClassDoc.php?btn=1&fn=' . $fileName . '" target="_blank">' . $fileName . '</a>  —— ' . $commentTitle;
            echo '<br>';
        }
    }
    return 'Completed!';
}

/**
 * 获取程序文件的文件头注释的标题
 */
function getFileCommentTitle($filename, $startLine = 1, $endLine = 50, $method = 'rb') {
    $ret = '';
    $count = $endLine - $startLine;

    $fp = new SplFileObject($filename, $method);
    $fp->seek($startLine - 1); // 转到第N行, seek方法参数从0开始计数
    for ($i = 0; $i <= $count; ++$i) {
        $currLineStr = $fp->current(); // current()获取当前行内容
        if ((preg_match('/s?\*s?([^\*]{3,})/', $currLineStr, $matches))) {
            return $matches[1];
        }
        $fp->next(); // 下一行
    }

    return $ret;
}
?>

<FORM METHOD=POST ACTION="">
    目录：<INPUT TYPE="text" name="path" value="/data/webapp/www/ms">
    扩展名：<INPUT TYPE="text" name="ext_name" value="php"> 如：php|java
    忽略：<INPUT TYPE="text" name="ignore_dir" value="conf|log|public|views|appdata"> 如：cola|config|views
    <INPUT TYPE="submit" name="btn" value="生成文档">
</FORM>