<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>正在更新贫困县信息</title>
</head>
<body>
<?php
include('connect_db.php');//链接数据库
$name = $_GET["name"];
$info = $_GET["info"];
$sql="select * from jingweidu where name ='$name'";
$result = mysqli_query ($db,$sql);
if ( $row = mysqli_fetch_array ( $result ) ) {
    $dbname = $row ["name"];
    $dbinfo = $row ["info"];
}
if (is_null ( $dbname )) {
    ?>
    <script type="text/javascript">
        alert("该县不存在");
        window.location.href="update.html";
    </script>
    <?php
}
$sql="update jingweidu set info='$info' where name='$name'";
mysqli_query ( $db,$sql );
?>


<script type="text/javascript">
    alert("数据更新成功");
    window.close();
</script>
</body>
</html>