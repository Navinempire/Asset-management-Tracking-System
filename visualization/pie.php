<?php
error_reporting(0);
$string = "mysql:host=localhost;dbname=asset_tracker";
$connect = new PDO($string,'root','');
$query= "
            SELECT asset.asset_name, category.category_name, asset_type.asset_type_name,
                asset.serial_number, asset.status, asset.conditions
            FROM asset
            INNER JOIN category ON asset.category_id = category.category_id
            INNER JOIN asset_type ON category.asset_type_id = asset_type.asset_type_id
        ";


$data = $connect->query($query);
$result = $data->fetchALL();
$hardware =0;
$electronic=0;
$software =0;
$furniture=0;

for ($x=0;$x<=count($result);$x++){
    if($result[$x]['asset_type_name']=='furniture'){
        $furniture = $furniture+1;
    }
    else if($result[$x]['asset_type_name']=='hardware'){
        $hardware = $hardware+1;
    }
    else if($result[$x]['asset_type_name']=='electronic'){
        $electronic = $electronic+1;
    }
    else if($result[$x]['asset_type_name']=='software'){
        $software = $software+1;
    }

}



$dataPoints = array( 
	array("label"=>"Electronic", "symbol" => "Electronic","y"=>$electronic),
	array("label"=>"Furniture", "symbol" => "Furniture","y"=>$furniture),
	array("label"=>"Hardware", "symbol" => "Hardware","y"=>$hardware),
	array("label"=>"Software", "symbol" => "Software","y"=>$software),


)

?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: "Asset Types"
	},
	data: [{
		type: "doughnut",
		indexLabel: "{symbol} - {y}",
		yValueFormatString: "#,##0.0\"%\"",
		showInLegend: true,
		legendText: "{label} : {y}",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html> 