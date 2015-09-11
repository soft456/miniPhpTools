<?php
if ($_POST["btn1"]) {
    $str = trim($_POST["str"]);
    $ret = transForm($str);
}

function transForm($str)
{
    $ret = str_replace('[', "'", $str);
    $ret = str_replace(']', "'", $ret);
    $ret = str_replace('=> ', "=> '", $ret);
    $ret = str_replace("\r", "',\r", $ret);
    $ret = str_replace("Array',", "Array", $ret);
    $ret = str_replace("(',", "(", $ret);
    return $ret;
}
?>

<FORM METHOD=POST ACTION="">
    结果：
    <TEXTAREA NAME="str" ROWS="14" COLS="80"><?php echo $str; ?></TEXTAREA><br>
转换：
<TEXTAREA NAME="base64Str" ROWS="14" COLS="80"><?php echo $ret; ?></TEXTAREA><br>

<INPUT TYPE="submit" name="btn1" value="转换">
</FORM>