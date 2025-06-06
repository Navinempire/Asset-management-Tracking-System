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
<link rel="stylesheet" href="asset/css/category.css">
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
</head>
<body><center>
    <h1>category Deatils</h1>
    <div class="body">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="" style="padding-left: 150px; padding-right: 40px;">category name</label>
        <input type="text" name="categoryName" placeholder="Enter category_name"><br><br>
        <label for="" style="padding-left: 150px;">Asset Type Name</label>
        <input type="text"name="assetTypeId" placeholder="Enter asset_type_name"><br><br>

        <button type="submit" name="category" class="btn btn-success button" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Submit</button>
        
    </form>
</div></center>
<br>
<br>
<br>
</body>
</html>
<?php

include("config/connection.php");
class Category extends Database{
    public function category(){
        $categoryName = $_POST['categoryName'];
        $assetTypeId = $_POST['assetTypeId'];
        $categorybtn =$_POST['category'];

        $array = array('categoryName'=>$categoryName,'assetTypeId'=>$assetTypeId,'categorybtn'=>$categorybtn);
        $data = http_build_query($array);
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
$catclass = new Category();
$catclass->category();




// $asset_type_idd;

// $atype =$_oconnect->query("SELECT * FROM asset_type");
// $a = $atype->fetchALL(PDO::FETCH_ASSOC);
// foreach ($a as $key=>$val){
//     foreach ($val as $k=>$v){
//         if($assetTypeId==$v){
//             $asset_type_idd = $val['asset_type_id'] ;
//         }
//     }
// }

// if($asset_type_idd==NULL){
//     if(!empty($_POST)){
//         $aty ="INSERT INTO asset_type(asset_type_name)values(?)";
//         $assetType = $_oconnect->prepare($aty);
        
//         $assetType->bindParam(1,$assetTypeId);
//     }
    
// }
// $category = $_oconnect->query("SELECT * FROM category");
// $s = $category->fetchAll(PDO::FETCH_ASSOC);
// $category_id=0;
// foreach ($s as $key=>$val){
//     foreach ($val as $k=>$v){
//         if($categoryName==$v){
//             $categoryName = 0 ;
            
//         }
//     }
// }
// if($categoryName==0){
//     echo'
//     <script>
//         alert("category_name already EXIST");
//     </script>';
    
// }
// else{
//     if(!empty($_POST)){
//         $cat = "INSERT INTO category(category_name,asset_type_id)values(?,?)";
//         $category = $_oconnect->prepare($cat);
//         $category->bindParam(1,$categoryName);
//         $category->bindParam(2,$asset_type_idd);
//         $category->execute();
//         header("LOCATION: add.php");
//         if ($cat) {
//             echo "<script>
//                 alert('Category added successfully!');
//                 window.location.href = 'add.php';
//             </script>";
//         } else {
//             echo "<script>
//                 alert('Failed to add category');
//                 window.history.back();
//             </script>";
//         }
//     }
// }

?>
<?php
    require ("includes/footer.php");
?>