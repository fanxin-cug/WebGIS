<?php
/**
 * Created by PhpStorm.
 * User: fanxin
 * Date: 18-5-13
 * Time: 下午3:22
 */

    include('connect_db.php');//链接数据库
    $name = $_GET['Username'];//get获得用户名表单值
    $passowrd = $_GET['Password'];//get获得用户密码单值
    session_start();
    $_SESSION['name']=$name;
    if ($name && $passowrd){//如果用户名和密码都不为空
        $sql = "select * from userinfo where username = '$name' and password='$passowrd'";//检测数据库是否有对应的username和password的sql
        mysqli_query($db,"set names 'utf8'");
        mysqli_query($db,"set character_set_client=utf8");
        mysqli_query($db,"set character_set_results=utf8");
        $result = mysqli_query($db,$sql);//执行sql
        $rows=mysqli_num_rows($result);//返回一个数值
        if($rows){//0 false 1 true
            header("refresh:0;url=index1.php");//如果成功跳转至index.php页面
            exit;
        }else{
            echo "用户名或密码错误";
            echo "<script>setTimeout(function(){window.location.href='index.html';},1000);</script>";//如果错误使用js 1秒后跳转到登录页面重试;
        }


    }else{//如果用户名或密码有空
        echo "表单填写不完整";
        echo "<script>setTimeout(function(){window.location.href='index.html';},1000);</script>";//如果错误使用js 1秒后跳转到登录页面重试;
    }

    mysql_close();//关闭数据库
?>