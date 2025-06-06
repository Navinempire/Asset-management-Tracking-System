<?php
include("config/connection.php");
if(isset($_POST['insert'])){
    if($_POST['categoryId']==0){
        echo "<script>
                alert('Category not found! Redirecting to category page...');
                window.location.href = 'category.php';
            </script>";
        exit();
    }
    $asset ="INSERT INTO asset(asset_name,serial_number,status,purchase_date,warranty_date,conditions,asset_value,category_id)
    values(?,?,?,?,?,?,?,?)";
    $ast = $_oconnect->prepare($asset);
    $ast->bindParam(1,$_POST['assetName']);
    $ast->bindParam(2,$_POST['serial']);
    $ast->bindParam(3,$_POST['available']);
    $ast->bindParam(4,$_POST['purchase']);
    $ast->bindParam(5,$_POST['warranty']);
    $ast->bindParam(6,$_POST['condition']);
    $ast->bindParam(7,$_POST['price']);
    $ast->bindParam(8,$_POST['categoryId']);
    $exit=$ast->execute();
    if ($exit) {
        echo "<script>
                alert('Asset added successfully!');
                window.location.href = 'index1.php';
            </script>";
    } else {
        echo "<script>
                alert('Something went wrong while inserting the asset.');
            </script>";
    }
}
if (isset($_POST['update'])) {

    $updat = "UPDATE asset SET asset_name = ?,serial_number = ?,status = ?,purchase_date = ?,warranty_date = ?,conditions = ?,asset_value = ? WHERE asset_id = ?";
        
    
    $update=$_oconnect->prepare($updat);
    $update->bindParam(1,$_POST['assetName']);
    $update->bindParam(2,$_POST['serial']);
    $update->bindParam(3,$_POST['status']);
    $update->bindParam(4,$_POST['purchase']);
    $update->bindParam(5,$_POST['warranty']);
    $update->bindParam(6,$_POST['condition']);
    $update->bindParam(7,$_POST['price']);
    $update->bindParam(8,$_POST['id']);
    $exit=$update->execute();
    
    if ($exit) {
        echo "<script>alert('Asset updated successfully.');</script>";
        echo "<script>window.location.href='index1.php';</script>";
        exit;
    } else {
        echo "Error updating asset: ";
    }
}

if (isset($_POST['delete'])) {
    $del = intval($_POST['delete']);
    $delet ="DELETE FROM asset WHERE asset_id = ?";
    $dele = $_oconnect->prepare($delet);
    $dele->bindParam(1,$del);
    $dele->execute();

    if ($dele) {
        echo "<script>
            alert('Asset deleted successfully.');
            window.location.href = 'index1.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Failed to delete asset.');
            window.history.back();
        </script>";
        exit();
    }
}

if(isset($_POST['categorybtn'])){
$categoryName = $_POST['categoryName'];
$assetTypeId = $_POST['assetTypeId'];
    
$asset_type_idd;

$atype =$_oconnect->query("SELECT * FROM asset_type");
$a = $atype->fetchALL(PDO::FETCH_ASSOC);
foreach ($a as $key=>$val){
    foreach ($val as $k=>$v){
        if($assetTypeId==$v){
            $asset_type_idd = $val['asset_type_id'] ;
        }
    }
}

if($asset_type_idd==NULL){
    if(!empty($_POST)){
        $aty ="INSERT INTO asset_type(asset_type_name)values(?)";
        $assetType = $_oconnect->prepare($aty);
        
        $assetType->bindParam(1,$assetTypeId);
    }
    
}
$category = $_oconnect->query("SELECT * FROM category");
$s = $category->fetchAll(PDO::FETCH_ASSOC);
$category_id=0;
foreach ($s as $key=>$val){
    foreach ($val as $k=>$v){
        if($categoryName==$v){
            $categoryName = 0 ;
            
        }
    }
}
if($categoryName==0){
    echo'
    <script>
        alert("category_name already EXIST");
    </script>';
    
}
else{
    if(!empty($_POST)){
        $cat = "INSERT INTO category(category_name,asset_type_id)values(?,?)";
        $category = $_oconnect->prepare($cat);
        $category->bindParam(1,$categoryName);
        $category->bindParam(2,$asset_type_idd);
        $category->execute();
        header("LOCATION: add.php");
        if ($cat) {
            echo "<script>
                alert('Category added successfully!');
                window.location.href = 'add.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to add category');
                window.history.back();
            </script>";
        }
    }
}
}

?>