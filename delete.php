<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>正在删除贫困县</title>
</head>
<body>
<?php
include('connect_db.php');//链接数据库
$name = $_GET["name"];
$sql="DELETE FROM jingweidu WHERE name = '$name' ";
mysqli_query ($db,$sql);
?>
<script type="text/javascript">
    alert("删除成功!");
    window.close();
</script>
</body>
</html>