<?php
/**
 *
 * 生成php类的文档
 *
 * @author soft456@gmail.com
 * @date 2015-09-17
 *
 */
?>
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
        if (isset($_POST['btn']) && $_POST['btn']) {

            $olePath = trim($_POST['path']);

            $rs = funcList($olePath);

            if ($rs) {

                echo '<br><table width="620">
                <tr><th>方法名</th><th>标题</th></tr>';

                foreach ($rs as $key => $value) {
                    echo '<tr height="30px"><td>' . $key . '</td><td>' . $value . '</td></tr>';
                    echo '<tr><td colspan="2">&nbsp;</td></tr>';
                }
            }
            echo '</table><br><br><a href="">返回</a>';
            exit;
        }

        /**
         *  获取类的所有方法
         * 
         * @param string $className 要获取其方法的类名
         */
        function funcList($className) {

            $classFileName = (FALSE === strpos($className, ".php")) ? $className . '.php' : $className;

            //排除部分方法
            $ignoreFuncRs = array('__get', '_before_index', '_after_index', '_initialize', '__construct', 'getActionName', 'isAjax', 'display', 'show', 'fetch', 'buildHtml', 'assign', '__set', 'get', '__get', '__isset', '__call', 'error', 'success', 'ajaxReturn', 'redirect', '__destruct', '_empty');
            if (!file_exists($classFileName)) {
                return FALSE;
            }

            $fileStr = file_get_contents($classFileName);

            //获取注释标题和方法名的正则——限public方法
            $pattern = '/\/\*\*.*?\*(.*?)[\b\/@\*].*?public.*?function(.*?)\(.*?\)/is';
            if (!preg_match_all($pattern, $fileStr, $funcRs)) {
                echo "正则匹配失败！";
                return FALSE;
            }

            $ret = array();
            foreach ($funcRs[2] as $key => $value) {
                $trimValue = trim($value);
                if (in_array($trimValue, $ignoreFuncRs)) {
                    continue;
                }
                $ret[$trimValue] = trim($funcRs[1][$key]);
            }

            return $ret;
        }
        ?>

        <FORM METHOD=POST ACTION="">
            类文件：<INPUT TYPE="text" name="path" size="60" value="/data/webapp/www/ms/application/controllers/Speed.php" />    
            <!--    忽略：<INPUT TYPE="text" name="ignore_dir" value="cola|config|views"> 如：cola|config|views-->
            <INPUT TYPE="submit" name="btn" value="确定" />
        </FORM>


    </body>
</html>
