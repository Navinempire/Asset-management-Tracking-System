<?php
require ('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="asset/css/add.css">
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Asset insert Details</h1>
    <center>
    <div class="body">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="" >Asset Name</label>
        <input type="text" name="assetName" placeholder="eg: DEL-890-RU">
        <label for="" style="padding-right: 40px;">Asset Type</label>
        <input type="text"name="assetType" placeholder="eg: Hardware"><br><br>
        <label for="" style="padding-right: 45px;">Product</label>
        <input type="text" name="product" placeholder="eg: Laptop">
        <label for="">Serial Number</label>
        <input type="text" name="serialNumber" placeholder="eg: INFI-097"><br><br>
        <label for="" style="padding-right: 35px;">Purchase</label>
        <input type="date" name="purchaseDate" placeholder="date">
        <label for="" style="padding-right: 55px;">warranty</label>
        <input type="date" name="warrantyDate" placeholder="date"><br><br>
        <label for="" style="padding-right: 35px;">condition</label>
        <input type="text"name="conditions" placeholder=" eg :GOOD">
        <label for="" style="padding-right: 65px;">Price</label>
        <input type="number" name="assetValue" placeholder="$ eg: Price"><br><br>
        <button type="submit" name="insert" class="btn btn-default"><i class="fa fa-check-square-o" aria-hidden="true"></i> Submit</button>
    </form></center>
</div> <br> <br> <br>
</body>
</html>
<?php
include("config/connection.php");

class Add extends Database{
    public function insert(){
        include("config/session/getpost.php");
        $conn = $this->connection();
        $Available = 'Available';

        $category =$conn->query("SELECT * FROM category");

        $s =$category->fetchAll(PDO::FETCH_ASSOC);

        $asset_type_id=0;
        $atype = $conn->query("SELECT * FROM asset_type");
        $a = $atype->fetchAll(PDO::FETCH_ASSOC);
        foreach ($a as $key=>$val){
            foreach ($val as $k=>$v){
                if($assetType==$v){
                    $asset_type_id = $val['asset_type_id'] ;
                }
            }
        }
        $category_id=0;

        foreach ($s as $key=>$val){
            foreach ($val as $k=>$v){
                if($product==$v){
                    $category_id = $val['category_id'] ;
                }
            }
        }

        $insert = $_POST['insert'];
        $string = array('insert'=>$insert,'assetName'=>$assetName,'serial'=>$serial,
        'available'=>$Available,'purchase'=>$purchase,'warranty'=>$warranty,'condition'=>$condition,
        'price'=>$price,'categoryId'=>$category_id);
        $data = http_build_query($string);
        $curl = curl_init();
        curl_setopt_array($curl,array(
            CURLOPT_URL=>'http://localhost/asset%20management/server.php',
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$data
        ));
        $respond= curl_exec($curl);
        curl_close($curl);
        echo $respond;
    }
}
$insert = new Add();
$insert->insert();
// $Available = 'Available';

// $category =$_oconnect->query("SELECT * FROM category");

// $s =$category->fetchAll(PDO::FETCH_ASSOC);

// $asset_type_id=0;
// $atype = $_oconnect->query("SELECT * FROM asset_type");
// $a = $atype->fetchAll(PDO::FETCH_ASSOC);
// foreach ($a as $key=>$val){
//     foreach ($val as $k=>$v){
//         if($assetType==$v){
//             $asset_type_id = $val['asset_type_id'] ;
//         }
//     }
// }
// $category_id=0;

// foreach ($s as $key=>$val){
//     foreach ($val as $k=>$v){
//         if($product==$v){
//             $category_id = $val['category_id'] ;
//         }
//     }
// }

// $insert = $_POST['insert'];
// $string = array('insert'=>$insert,'assetName'=>$assetName,'serial'=>$serial,
// 'available'=>$Available,'purchase'=>$purchase,'warranty'=>$warranty,'condition'=>$condition,
// 'price'=>$price,'categoryId'=>$category_id);
// $data = http_build_query($string);
// $curl = curl_init();
// curl_setopt_array($curl,array(
//     CURLOPT_URL=>'http://localhost/asset%20management/server.php',
//     CURLOPT_RETURNTRANSFER=>true,
//     CURLOPT_POST=>true,
//     CURLOPT_POSTFIELDS=>$data
// ));
// $respond= curl_exec($curl);
// curl_close($curl);
// echo $respond;
?>

<?php
    require ("includes/footer.php");
?>