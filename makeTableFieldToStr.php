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
         * mysql 将表的字段名逗号分隔返回
         *
         * @author soft456@gmail.com
         * @date 2015-05-13
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
                $query = "SELECT COLUMN_NAME
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

            //直接打印出来

            foreach ($fieldRs as $key => $value) {
                //字段名以逗号分隔
                $fieldStr = '';

                //字段名数组key字符串封装
                $arrayStr = '$dbData = array(<br>';

                foreach ($value['data'] as $subKey => $subValue) {
                    $subKey && $fieldStr .= ',';
                    $fieldStr .= $subValue['COLUMN_NAME'];
                    $arrayStr .= "'" . $subValue['COLUMN_NAME'] . "' => '',<br>";
                }

                $arrayStr .= ');';

                //输出
                echo '<br>表名：' . $key . ':<br>';
                echo '<br>' . $fieldStr . '<br>';
                echo '<br>' . $arrayStr . '<br>';
            }

            echo '<br><a href="">返回</a><br>';
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
                    <tr><td colspan="2"><INPUT TYPE="submit" value="submit"></td></tr>
                </FORM>
            </table>

    </body>
</html>