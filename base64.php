<?php
/**
 * base64编码与反编码
 */
if (isset($_POST["btn1"]) && $_POST["btn1"]) {
    $str = trim($_POST["str"]);
    $sBase64 = base64_encode($str);
}
if (isset($_POST["btn2"]) && $_POST["btn2"]) {
    $sBase64 = trim($_POST["base64Str"]);
    $str = base64_decode($sBase64);
}
?>

<FORM METHOD=POST ACTION="">
    原串：<br>
    <TEXTAREA NAME="str" ROWS="14" COLS="80"><?php echo isset($str) ? $str : ''; ?></TEXTAREA><br>
base64串：<br>
<TEXTAREA NAME="base64Str" ROWS="14" COLS="80"><?php echo isset($sBase64) ? $sBase64 : ''; ?></TEXTAREA><br>

<INPUT TYPE="submit" name="btn1" value="加密">
<INPUT TYPE="submit" name="btn2" value="解密">
</FORM>