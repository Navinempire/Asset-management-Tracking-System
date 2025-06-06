<?php
require('includes/header.php');
include("config/connection.php");


if (!isset($_oconnect)) {
    $db = new Database();
    $_oconnect = $db->connection();
}

if (isset($_POST['assetId'])) {
    $id = intval($_POST['assetId']);

    // fetch from asset folder
    $stmt = $_oconnect->prepare("
        SELECT * FROM asset
        INNER JOIN category ON asset.category_id = category.category_id
        INNER JOIN asset_type ON category.asset_type_id = asset_type.asset_type_id
        WHERE asset_id = :id
    ");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Asset not found!";
        exit;
    }
} else {
    echo "No Asset ID provided!";
    exit;
}

// Handle update form submission
if (isset($_POST['update'])) {
    // Collect updated data safely
    $assetName = $_POST['assetName'] ?? '';
    $serial = $_POST['serialNumber'] ?? '';
    $status = $_POST['status'] ?? '';
    $purchase = $_POST['purchaseDate'] ?? '';
    $warranty = $_POST['warrantyDate'] ?? '';
    $condition = $_POST['conditions'] ?? '';
    $value = $_POST['assetValue'] ?? 0;

    $updateStmt = $_oconnect->prepare("
        UPDATE asset SET
            asset_name = ?,
            serial_number = ?,
            status = ?,
            purchase_date = ?,
            warranty_date = ?,
            conditions = ?,
            asset_value = ?
        WHERE asset_id = ?
    ");

    $success = $updateStmt->execute([
        $assetName,
        $serial,
        $status,
        $purchase,
        $warranty,
        $condition,
        $value,
        $id
    ]);

    if ($success) {
        echo "<script>alert('Asset updated successfully.'); window.location.href='index1.php';</script>";
        exit;
    } else {
        echo "Error updating asset.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset</title>
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Edit Asset</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="assetId" value="<?php echo htmlspecialchars($row['asset_id']); ?>">

        <div class="form-group">
            <label>Asset Name</label>
            <input type="text" class="form-control" name="assetName" value="<?php echo htmlspecialchars($row['asset_name']); ?>" required>
        </div>
        <div class="form-group">
            <label>Serial Number</label>
            <input type="text" class="form-control" name="serialNumber" value="<?php echo htmlspecialchars($row['serial_number']); ?>" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <input type="text" class="form-control" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" required>
        </div>
        <div class="form-group">
            <label>Purchase Date</label>
            <input type="date" class="form-control" name="purchaseDate" value="<?php echo htmlspecialchars($row['purchase_date']); ?>" required>
        </div>
        <div class="form-group">
            <label>Warranty Date</label>
            <input type="date" class="form-control" name="warrantyDate" value="<?php echo htmlspecialchars($row['warranty_date']); ?>" required>
        </div>
        <div class="form-group">
            <label>Condition</label>
            <input type="text" class="form-control" name="conditions" value="<?php echo htmlspecialchars($row['conditions']); ?>" required>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" class="form-control" name="assetValue" value="<?php echo htmlspecialchars($row['asset_value']); ?>" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary btn1"><i class="fa fa-check-square-o" aria-hidden="true"></i> Update Asset</button>
        <a href="index1.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>

<?php require("includes/footer.php"); ?>
