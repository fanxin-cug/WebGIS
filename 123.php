<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>全国贫困县</title>
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
    $sql="select longitude,latitude from jingweidu";
    $result=mysqli_query($db,$sql);
    $data1=array();
    $data2=array();
    while($row=mysqli_fetch_row($result)) {
        $data1[]=$row[0];
        $data2[]=$row[1];
    }
    $data1json=json_encode($data1);
    $data2json=json_encode($data2);
    ?>
    var map;
    //Bing地图密钥
    var key = 'Q57tupj2UBsQNQdju4xL~xBceblfTd6icjljunbuaCw~AhwA-whmGMsfIpVhslZyknWhFYq-GvWJZqBnqV8Zq1uRlI5YM_qr7_hxvdgnU7nH';

    //加载Bing地图航空影像数据
    var imagery = new ol.layer.Tile({
        source: new ol.source.BingMaps({ key: key, imagerySet: 'Aerial' })
    });

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
        layers: [layer1, layer2,imagery],
        view: new ol.View({
            zoom: 4,
            center: [114, 30],
            projection: 'EPSG:4326'
        })
    });

    var X =<?php echo $data1json?>;
    var Y =<?php echo $data2json?>;
    var len = X.length;

    var point=new Array();
    var source=new Array();
    var vector=new Array();
    for (var i = 0; i < len; i++) {
        point[i] = new ol.Feature({
            geometry: new ol.geom.Point([X[i], Y[i]])
        });
        source[i] = new ol.source.Vector({
            features: [point[i]]
        });
        vector[i] = new ol.layer.Vector({
            source: source[i]
        });
        map.addLayer(vector[i]);
    }

    //探查半径
    var radius = 75;
    //添加键盘按下事件监听，用来控制探查范围的大小
    document.addEventListener('keydown', function (evt) {
        if (evt.which == 38) {
            radius = Math.min(radius + 5, 150);
            map.render();
            evt.preventDefault();
        } else if (evt.which ==  40) {
            radius = Math.max(radius - 5, 25);
            map.render();
            evt.preventDefault();
        }
    });

    // 实时得到鼠标的像素位置
    var mousePosition = null;

    container.addEventListener('mousemove', function (event) {
        mousePosition = map.getEventPixel(event);
        map.render();
    });

    container.addEventListener('mouseout', function () {
        mousePosition = null;
        map.render();
    });

    // 在渲染层之前,做剪裁
    imagery.on('precompose', function (event) {
        var ctx = event.context;
        var pixelRatio = event.frameState.pixelRatio;
        ctx.save();
        ctx.beginPath();
        if (mousePosition) {
            //只显示一个围绕着鼠标的圆圈
            ctx.arc(mousePosition[0] * pixelRatio, mousePosition[1] * pixelRatio, radius * pixelRatio, 0, 2 * Math.PI);
            ctx.lineWidth = 5 * pixelRatio;
            ctx.strokeStyle = 'rgba(0,0,0,0.5)';
            ctx.stroke();
        }
        ctx.clip();
    });

    // 呈现层后,恢复画布的背景
    imagery.on('postcompose', function (event) {
        var ctx = event.context;
        ctx.restore();
    });
</script>
</body>
</html>