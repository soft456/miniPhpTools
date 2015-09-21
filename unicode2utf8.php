<?php
/**
 * unicode2utf8
 */
if (isset($_POST['btn1']) && $_POST["btn1"]) {
    $str = trim($_POST["str"]);
    $ret = unicode2utf8($str);
}

function unicode2utf8($str) {
    if (!$str) {
        return $str;
    }
    $decode = json_decode($str);
    if ($decode) {
        return $decode;
    }
    $str = '["' . $str . '"]';
    $decode = json_decode($str);
    if (count($decode) == 1) {
        return $decode[0];
    }
    return $str;
}
?>

<FORM METHOD=POST ACTION="">
    结果：
    <TEXTAREA NAME="str" ROWS="14" COLS="80"><?php echo isset($str) ? $str : ''; ?></TEXTAREA><br>
转换：
<TEXTAREA NAME="utf8str" ROWS="14" COLS="80"><?php echo isset($ret) ? $ret : ''; ?></TEXTAREA><br>

<INPUT TYPE="submit" name="btn1" value="转换">
</FORM>