<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>正在添加</title>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/ol-debug.js"></script>
    <script src="js/zondyClient.js"></script>
    <link rel="stylesheet" href="js/ol.css">
</head>
<body>
<div id="mapCon" style="position: absolute;width: 100%;height:100%;"></div>
<script type="text/javascript">
<?php
include('connect_db.php');//链接数据库
$name = $_GET["name"];
$longitude = $_GET["longitude"];
$latitude = $_GET["latitude"];
$sql="insert into jingweidu values ('$name','$longitude','$latitude','该县是贫困县')";
mysqli_query ($db,$sql);
$sql1="select longitude,latitude from jingweidu where name='$name'";
$result=mysqli_query($db,$sql1);
$row=mysqli_fetch_row($result);
$data1=$row[0];
$data2=$row[1];
$data1json=json_encode($data1);
$data2json=json_encode($data2);
?>
var map;
var layer1 = new Zondy.Map.TianDiTu({
        ip: "127.0.0.1",
        port: "6163",
        layerType: Zondy.Enum.TiandituType.VEC
    });

var layer2 = new Zondy.Map.TianDiTu({
        ip: "127.0.0.1",
        port: "6163",
        layerType: Zondy.Enum.TiandituType.CVA
    });

//设置地图容器放置位置
var container = document.getElementById('mapCon');
    map = new ol.Map({
        target: container,
        layers: [layer1, layer2],
        view: new ol.View({
            zoom: 4,
            center: [114, 30],
            projection: 'EPSG:4326'
        })
    });

var X =<?php echo $data1json?>;
var Y =<?php echo $data2json?>;

var point=new ol.Feature({
            geometry: new ol.geom.Point([X, Y])
        });

source = new ol.source.Vector({
            features: [point]
        });
vector = new ol.layer.Vector({
            source: source
        });
map.addLayer(vector);
</script>
</body>
</html>