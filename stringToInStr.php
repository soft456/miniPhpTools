<?php
/**
 * 生成逗号分隔的字符串
 */
if (isset($_POST['btn1']) && $_POST["btn1"]) {
    $str = trim($_POST["str"]);
    $ret = transForm($str);
}

function transForm($str)
{
    //$ret = str_replace('^', "'", $str);
    $ret = str_replace(chr(10), "'", $str);
    $ret = str_replace(chr(13), "',", $ret);
    $retFinal = "'" . $ret . "'";
    return str_replace(",'',", ',', $retFinal);
}
?>

<FORM METHOD=POST ACTION="">
    结果：
    <TEXTAREA NAME="str" ROWS="14" COLS="80"><?php echo isset($str) ? $str : ''; ?></TEXTAREA><br>
转换：
<TEXTAREA NAME="base64Str" ROWS="14" COLS="80"><?php echo isset($ret) ? $ret : ''; ?></TEXTAREA><br>

<INPUT TYPE="submit" name="btn1" value="转换">
</FORM>