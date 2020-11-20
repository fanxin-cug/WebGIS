<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>折线图显示</title>
</head>
<body>
<script src="js/Chart.min.js"></script>
<canvas id="popChart">
    <script>
        $(window).resize(resizeCanvas);
 function resizeCanvas() {
        canvas.attr("width", $(window).get(0).innerWidth);
        canvas.attr("height", $(window).get(0).innerHeight);
        context.fillRect(0, 0, canvas.width(), canvas.height());
 };
 resizeCanvas();
    </script>
</canvas>
<script>
    <?php
    $name = $_GET['name'];
    include('connect_db.php');//链接数据库
    $data=array();
    for($i=2009;$i<=2015;$i++){
        $sql="SELECT primary_industry,secondary_industry,deposits,area,middle_students,hospital_beds,welfare_num FROM `$i` WHERE name='$name'";
        mysqli_query($db,"set names 'utf8'");
        mysqli_query($db,"set character_set_client=utf8");
        mysqli_query($db,"set character_set_results=utf8");
        $result=mysqli_query($db,$sql);
        $row=mysqli_fetch_row($result);
        $data[]=0.155*$row[0]+0.095*$row[1]+0.25*$row[2]+0.0722*$row[3]+0.0961*$row[4]+0.155*$row[5]+0.0589*$row[6];
    }
    $datajson=json_encode($data);
    ?>
    var name="<?php echo $name; ?>";
    var data =<?php echo $datajson?>;
    var popCanvas = document.getElementById("popChart");
    var popCanvas = document.getElementById("popChart").getContext("2d");
    var barChart = new Chart(popCanvas, {
        type: 'line',
        data: {
            labels: ["2009", "2010", "2011", "2012", "2013", "2014", "2015"],
            datasets: [{
                label: name,
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                ]
            }]
        }
    });
</script>
</body>
</html>