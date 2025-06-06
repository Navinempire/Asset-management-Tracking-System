<?php
$string = "mysql:host=localhost;dbname=asset_tracker";
$connect = new PDO($string,'root','');
$query="SELECT category.category_name, COUNT(*) AS total_assets
FROM asset
INNER JOIN category ON asset.category_id = category.category_id
INNER JOIN asset_type ON category.asset_type_id = asset_type.asset_type_id
GROUP BY category.category_name;
";


$data = $connect->query($query);
$result = $data->fetchALL();
$dataPoints = array(
	array("x"=> 10, "y"=> $result[0]['total_assets'],"indexLabel"=> "AC"),
	array("x"=> 20, "y"=> $result[1]['total_assets'],"indexLabel"=> "airpots"),
	array("x"=> 30, "y"=> $result[2]['total_assets'],"indexLabel"=> "aws"),
	array("x"=> 40, "y"=> $result[3]['total_assets'],"indexLabel"=> "BOLD"),
	array("x"=> 50, "y"=> $result[4]['total_assets'],"indexLabel"=> "cabin"),
	array("x"=> 60, "y"=> $result[5]['total_assets'],"indexLabel"=> "chair"),
	array("x"=> 70, "y"=> $result[6]['total_assets'],"indexLabel"=> "keybord"),
	array("x"=> 80, "y"=> $result[7]['total_assets'],"indexLabel"=> "laptop"),
	array("x"=> 90, "y"=> $result[8]['total_assets'],"indexLabel"=> "mobile"),
	array("x"=> 100, "y"=> $result[9]['total_assets'],"indexLabel"=> "mouse"),
	array("x"=> 110, "y"=> $result[10]['total_assets'],"indexLabel"=> "ms-office"),
	array("x"=> 120, "y"=> $result[11]['total_assets'],"indexLabel"=> "neckband"),
	array("x"=> 130, "y"=> $result[12]['total_assets'],"indexLabel"=> "network"),
    array("x"=> 140, "y"=> $result[13]['total_assets'],"indexLabel"=> "NPSTOOL"),
	array("x"=> 150, "y"=> $result[14]['total_assets'],"indexLabel"=> "Speaker"),
	array("x"=> 160, "y"=>$result[15]['total_assets'],"indexLabel"=> "Tv")
);

	
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Asset Products"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
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