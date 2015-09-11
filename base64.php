<?php
if ($_POST["btn1"]) {
    $str = trim($_POST["str"]);
    $sBase64 = base64_encode($str);
}
if ($_POST["btn2"]) {
    $sBase64 = trim($_POST["base64Str"]);
    $str = base64_decode($sBase64);
}
?>

<FORM METHOD=POST ACTION="">
    &nbsp;&nbsp;&nbsp;&nbsp;原串：
    <TEXTAREA NAME="str" ROWS="14" COLS="80"><?php echo $str; ?></TEXTAREA><br>
base64串：
<TEXTAREA NAME="base64Str" ROWS="14" COLS="80"><?php echo $sBase64; ?></TEXTAREA><br>

<INPUT TYPE="submit" name="btn1" value="加密">
<INPUT TYPE="submit" name="btn2" value="解密">
</FORM>