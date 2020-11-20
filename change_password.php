<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>正在修改密码</title>
</head>
<body>
<?php
include('connect_db.php');//链接数据库
$username = $_GET["username"];
$oldpassword = $_GET["oldpassword"];
$newpassword = $_GET["newpassword"];
$dbusername = null;
$dbpassword = null;
$sql="select * from userinfo where username ='$username'";
$result = mysqli_query ($db,$sql);
if ( $row = mysqli_fetch_array ( $result ) ) {
    $dbusername = $row ["username"];
    $dbpassword = $row ["password"];
}
if (is_null ( $dbusername )) {
    ?>
    <script type="text/javascript">
        alert("用户名不存在");
        window.location.href="change_password.html";
    </script>
    <?php
}
if ($oldpassword != $dbpassword) {
    ?>
    <script type="text/javascript">
        alert("密码错误");
        window.location.href="change_password.html";
    </script>
    <?php
}
$sql="update userinfo set password='$newpassword' where username='$username'";
mysqli_query ( $db,$sql );//如果上述用户名密码判定不错，则update进数据库中
?>


<script type="text/javascript">
    alert("密码修改成功");
    window.close();
</script>
</body>
</html>