<?php
/**
 * 时间戳字符串转换
 */
if (isset($_POST['timestamp']) && $_POST['timestamp']) {
    echo $_POST['timestamp'] . ' ==>  ';
    echo date('Y-m-d H:i:s', trim($_POST['timestamp']));
    echo '<br>';
}

if (isset($_POST['date']) && $_POST['date']) {
    echo $_POST['date'] . ' ==> ';
    echo strtotime(trim($_POST['date']));
    echo '<br>';
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
    <HEAD>
        <TITLE> MiniTools </TITLE>
        <META NAME="Generator" CONTENT="EditPlus">
        <META NAME="Author" CONTENT="">
        <META NAME="Keywords" CONTENT="">
        <META NAME="Description" CONTENT="">
    </HEAD>

    <BODY>

        <TABLE>

            <FORM METHOD=POST ACTION="">
                <TR>
                    <TD>
                        时间戳：<INPUT TYPE="text" NAME="timestamp">（例如：1378344627）
                    </TD>
                </TR>
                <TR>
                    <TD>
                        日&nbsp;&nbsp;期：<INPUT TYPE="text" NAME="date">（例如：2013-09-05）
                    </TD>
                </TR>
                <TR>
                    <TD>
                        <INPUT TYPE="submit" value="转换">
                        <INPUT TYPE="hidden" NAME="form_over" value="ok">
                    </TD>
                </TR>
            </FORM>

        </TABLE>

    </BODY>
</HTML>