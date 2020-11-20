<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>正在查询</title>
</head>
<body>
<?php
include('connect_db.php');//链接数据库
$name = $_GET["name"];
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
        window.location.href="QueryAttribute.html";
    </script>
    <?php
}
echo "<script>alert('$dbinfo');</script>";
?>
</body>
</html>