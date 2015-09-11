<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
        <title>doc</title>
        <style type="text/css">      
            th   
            {  
                font-size:1.1em;  
                text-align:left;  
                padding-top:5px;  
                padding-bottom:4px;  
                background-color:#A7C942;  
                color:#ffffff;  
            } 
            table td{
                font-size:14px; border:1px solid #000000; padding:3px 7px 2px 7px;border-collapse:collapse; 
            }            
            body {
                margin-left: 0px;
                margin-right: 0px;
                margin-top: 0px;
                margin-bottom: 0px;
            }
        </style>

    </head>

    <body>


        <?php
        /**
         *
         * 从数据库生成数据库说明文档
         *
         * @author soft456@gmail.com
         * @date 2013-08-21
         * @varsion 1.0
         *
         * @copyright  Copyright (c) 2014 Wuhan Bo Sheng Education Information Co., Ltd.
         */
        if ($_POST["host"]) {

            foreach ($_POST as $key => &$value) {
                $value = trim($value);
            }

            $isAllTable = true;
            if (isset($_POST['table']) && $_POST['table']) {
                $isAllTable = FALSE;
            }

            $tableRs = $fieldRs = array();

            $dbName = trim($_POST['dbName']);

            $conn = mysql_connect($_POST['host'], $_POST['user'], $_POST['pwd']) or die('Connection to db error!');
            mysql_select_db($dbName, $conn);

            //获取表列表
            $query = "SELECT TABLE_NAME,TABLE_COMMENT
                  FROM INFORMATION_SCHEMA.TABLES  
                  WHERE table_schema = '" . $dbName . "'";
            $isAllTable || $query .= " and table_name in('" . str_replace("|", " ','", $_POST['table']) . "')";
            $rows = mysql_query($query, $conn) or die($query);
            while ($data = @mysql_fetch_array($rows)) {
                $tableRs[] = $data;
            }

            //获取每个表的字段列表
            foreach ($tableRs as $key => $value) {
                //获取字段列表
                $query = "SELECT *
              FROM INFORMATION_SCHEMA.COLUMNS
              WHERE table_schema = '" . $dbName . "' and table_name='" . $value['TABLE_NAME'] . "'
              ORDER BY ordinal_position";

                $rows = mysql_query($query, $conn) or die($query);
                $fieldRs[$value['TABLE_NAME']]['comment'] = $value['TABLE_COMMENT'];

                while ($data = @mysql_fetch_array($rows)) {
                    $fieldRs[$value['TABLE_NAME']]['data'][] = $data;
                }
            }

            mysql_close($conn);

            //输出
            if (isset($_POST['toWord']) && $_POST['toWord']) {
                //生成word文档
                $fileName = $dbName . '.doc';
                _makeWord($fieldRs, $fileName);
                //exit;
            } else {
                //直接打印出来
                foreach ($fieldRs as $key => $value) {
                    echo $value['comment'] . ' ' . $key
                    . '<br><table width="620">
                <tr><th>字段名</th><th>说明</th><th>类型长度</th><th>默认</th><th>主键</th><th>自增</th></tr>';
                    foreach ($value['data'] as $subValue) {
                        echo '<tr><td>' . $subValue['COLUMN_NAME']
                        . '</td><td>'
                        . $subValue['COLUMN_COMMENT']
                        . '</td><td>'
                        . $subValue['COLUMN_TYPE']
                        . '</td><td>'
                        . $subValue['COLUMN_DEFAULT']
                        . '</td><td>'
                        . $subValue['COLUMN_KEY']
                        . '</td><td>'
                        . $subValue['EXTRA'] . '</td></tr>';
                    }
                    echo "</table><br><br>";
                }
            }

            echo '<a href="">返回</a>';
            exit;
        }

        /**
         * 生成WORD文档
         * 
         * @param array $stuRs 要打印通知书的学生数据
         * @param array $data 固定数据数组。
         * @return word头文件格式
         */
        function _makeWord($fieldRs, $fileName)
        {
            header("Pragma: public");
            header("Expires: 0"); // set expiration time
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/msword;charset=utf-8");
            header("Content-Disposition:attachment;filename=" . $fileName);
            header("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
            header("Pragma:no-cache");
            header("Expires:0");
            $output = null;

            foreach ($fieldRs as $key => $value) {
                $output .= $value['comment'] . ' ' . $key
                        . '<br><table width="620" border="1"><tr><td>字段名</td><td>说明</td><td>类型长度</td><td>默认</td><td>主键</td><td>自增</td></tr>';
                foreach ($value['data'] as $subValue) {
                    $output .= '<tr><td>' . $subValue['COLUMN_NAME']
                            . '</td><td>'
                            . $subValue['COLUMN_COMMENT']
                            . '</td><td>'
                            . $subValue['COLUMN_TYPE']
                            . '</td><td>'
                            . $subValue['COLUMN_DEFAULT']
                            . '</td><td>'
                            . $subValue['COLUMN_KEY']
                            . '</td><td>'
                            . $subValue['EXTRA'] . '</td></tr>';
                }
                $output .= "</table><br><br>";
            }
            echo $output;
            exit;
        }
        ?>
        <br>
            <table width="800" border="0">
                <FORM METHOD=POST ACTION="">
                    <tr><td>host</td><td><INPUT TYPE="text" NAME="host" value="172.16.0.3"></td></tr>
                    <tr><td>user</td><td><INPUT TYPE="text" NAME="user" value="cjtest"></td></tr>
                    <tr><td>pwd</td><td><INPUT TYPE="password" NAME="pwd" value="test"></td></tr>
                    <tr><td>db name</td><td><INPUT TYPE="text" NAME="dbName" value="dodopemp"></td></tr>
                    <tr><td>table</td><td><INPUT TYPE="text" size="80" NAME="table" value="pemp_bulletin">多表|号分隔</td></tr>
                    <tr><td>to word</td><td><INPUT TYPE="checkbox" NAME="toWord" value="1"></td></tr>
                    <tr><td colspan="2"><INPUT TYPE="submit" value="submit"></td></tr>
                </FORM>
            </table>

    </body>
</html>