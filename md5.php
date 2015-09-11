<?php
header("Content-Type:text/html;charset=UTF-8");
if ($_POST["str"]) {

    $btn = trim($_POST['btn']);
    $s = $_POST["str"];
    echo $btn . "(" . $s . ")=" . hash($btn, $s);
}

$hashRs = array(
    'md5', 'sha1', 'sha256', 'sha512', 'ripemd128'
);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
        <title>md5</title>        
    </head>
    <body>
        <FORM METHOD=POST ACTION="">
            <INPUT TYPE="text" NAME="str" />
            <?php foreach ($hashRs as $value) : ?>
                <INPUT TYPE="submit" name='btn' value="<?php echo $value; ?>" />
            <?php endforeach; ?>
        </FORM>
    </body>
</html>