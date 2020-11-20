<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>查询贫困县</title>
    <link rel="stylesheet" href="https://cache.amap.com/lbs/static/main1119.css"/>
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.9&key=4139470d2ba21462462b2197a69dfeb7"></script>
    <script type="text/javascript" src="https://cache.amap.com/lbs/static/addToolbar.js"></script>
</head>
<body>
<div id="container"></div>
<script type="text/javascript">
    //初始化地图对象，加载地图
    var district, map = new AMap.Map("container", {
        resizeEnable: true,
        center: [114, 30],//地图中心点
        zoom: 10 //地图显示的缩放级别
    });
    addBeiJing();
    <?php $name = $_GET['name'];?>
    var name="<?php echo $name; ?>";
    function addBeiJing() {
        //加载行政区划插件
        AMap.service('AMap.DistrictSearch', function() {
            var opts = {
                subdistrict: 1,   //返回下一级行政区
                extensions: 'all',  //返回行政区边界坐标组等具体信息
                level: 'city'  //查询行政级别为市
            };
            //实例化DistrictSearch
            district = new AMap.DistrictSearch(opts);
            district.setLevel('district');
            //行政区查询
            district.search(name, function(status, result) {
                var bounds = result.districtList[0].boundaries;
                var polygons = [];
                if (bounds) {
                    for (var i = 0, l = bounds.length; i < l; i++) {
                        //生成行政区划polygon
                        var polygon = new AMap.Polygon({
                            map: map,
                            strokeWeight: 1,
                            path: bounds[i],
                            fillOpacity: 0.7,
                            fillColor: '#CCF3FF',
                            strokeColor: '#CC66CC'
                        });
                        polygons.push(polygon);
                    }
                    map.setFitView();//地图自适应
                }
            });
        });
    }
</script>
</body>
</html>