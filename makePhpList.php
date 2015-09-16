<?php
/**
 *  生成文件列表
 */
if (isset($_POST["form_over"]) && ($_POST["form_over"] == "ok")) {

    $sRootPath = $_POST["root_path"];
    if ($sRootPath == "") {
        die("error!");
    }
    if (substr($sRootPath, -1) == "\\") {
        $sRootPath = substr($sRootPath, 0, strlen($sRootPath) - 2);
    }


    //列表文件名
    $sListFileName = substr(strrchr($sRootPath, "\\"), 1) . "_php_list.txt";
    $oListFile = fopen($sRootPath . "\\" . $sListFileName, "w");

    writePhpList($oListFile, $sRootPath, $sRootPath);
}

/**
 * 
 * @param type $dirPath
 * @return array
 */
function getSubDir($dirPath) {

    $dirArray = array();

    if ($handle = opendir($dirPath)) {
        $i = 0;
        while (false !== ($resource = readdir($handle))) {
            if ($resource != "." && $resource != ".." && is_dir($dirPath . "\\" . $resource)) {
                $dirArray[$i] = $dirPath . "\\" . $resource;
                $i++;
            }
        }
    }

    return $dirArray;
}

/**
 *  取得文件列表
 */
function getFileList($path, $type = ".php") {

    $fileArray = array();

    if ($handle = opendir($path)) {
        $i = 0;
        while (false !== ($resource = readdir($handle))) {
            if (strtolower(substr($resource, -(strlen($type)))) == strtolower($type)) {
                $fileArray[$i] = $path . "/" . $resource;
                $i++;
            }
        }
    }

    return $fileArray;
}

/**
 * 
 * @param type $oFile
 * @param type $sDir
 * @param type $sRootPath
 */
function writePhpList($oFile, $sDir, $sRootPath) {

    $aFile = getFileList($sDir);
    for ($i = 0; $i < count($aFile); $i++) {
        $sTemp = str_replace($sRootPath, ".", $aFile[$i]);
        $sTemp = str_replace("\\", "/", $sTemp);
        fwrite($oFile, $sTemp . "\n");
    }

    $aSubDir = getSubDir($sDir);
    if ($aSubDir != false) {
        for ($i = 0; $i < count($aSubDir); $i++) {
            writePhpList($oFile, $aSubDir[$i], $sRootPath);
        }
    }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
    <HEAD>
        <TITLE> New Document </TITLE>
        <META NAME="Generator" CONTENT="EditPlus">
        <META NAME="Author" CONTENT="">
        <META NAME="Keywords" CONTENT="">
        <META NAME="Description" CONTENT="">
    </HEAD>

    <BODY>

        <TABLE>

            <FORM METHOD=POST ACTION="<?php echo $_SERVER["PHP_SELF"] ?>">
                <TR>
                    <TD>
                        目录路径：<INPUT TYPE="text" NAME="root_path">
                        （例如：E:\www\xsc2014）
                    </TD>
                </TR>
                <TR>
                    <TD>
                        <INPUT TYPE="submit" value="生成列表">
                        <INPUT TYPE="hidden" NAME="form_over" value="ok">
                    </TD>
                </TR>
            </FORM>

        </TABLE>

    </BODY>
</HTML>
