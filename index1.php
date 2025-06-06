<?php
require 'includes/header.php';
require 'config/connection.php';
require 'classes/AssetManager.php';
require 'classes/DeleteHandler.php';
require 'classes/Pagination.php';


$assetManager = new AssetManager();
$deleteHandler = new DeleteHandler();
$pagination = new Pagination();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteHandler->delete($_POST['delete']);
}


$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 8;

$data = $assetManager->getAssets($search, $page, $limit);
$totalAssets = $assetManager->countAssets($search);
$totalPages = ceil($totalAssets / $limit);
?>
<div class="container-fluid">
    <div class="banner-top">
    <div class="left">
        <h1>Tracking device</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, laborum corrupti incidunt voluptate blanditiis dignissimos tempore. 
            Officia incidunt molestias alias nesciunt ab provident, omnis ut totam esse illum, quam excepturi!</p>
        <center>
            <a href="add.php" class="btn btn-default">
                <i class="fa-solid fa-file-import"></i> Add
            </a>
        </center>
    </div>
    <div class="right">
        <img src="asset/image/download.jpg" class="img-fluid" alt="">
    </div>
    <div class="clear"></div>
</div>

    <div class="banner-mid">
        
        <center><h2 id="asset">Asset Details</h2></center>
        <form method="get" class="form-inline mb-4">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search assets" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
        </form>

        <div class="table-responsive">
        <table class="table table-condensed custom-table">

            <thead class="table-dark">
                <tr>
                    <th>Asset name</th>
                    <th>Type</th>
                    <th>Product</th>
                    <th>Serial</th>
                    <th>Status</th>
                    <th>Purchase</th>
                    <th>Warranty</th>
                    <th>Condition</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row['asset_name'] ?></td>
                    <td><?= $row['asset_type_name'] ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td><?= $row['serial_number'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['purchase_date'] ?></td>
                    <td><?= $row['warranty_date'] ?></td>
                    <td><?= $row['conditions'] ?></td>
                    <td><?= $row['asset_value'] ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="update.php" method="post">
                                        <input type="hidden" name="assetId" value="<?= $row['asset_id'] ?>">
                                        <button type="submit" class="btn btn-success" style="width:100%"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                        <input type="hidden" name="delete" value="<?= $row['asset_id'] ?>">
                                        <button type="submit" class="btn btn-danger" style="width:100%"><i class="fa-solid fa-trash"></i> Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

        <!-- Pagination -->
        <div class='pagination'>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class='btn btn-sm btn-secondary' style='margin:2px' href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>

    <div class="container-fluid bg-3 text-center custom-product" id="product">
        <div class="row">
            <div class="col-sm-3"><p>Laptops</p><img src="asset/image/laptop1.jpg" class="img-responsive" style="width:100%" alt="Image"></div>
            <div class="col-sm-3"><p>Ms-office</p><img src="asset/image/msoffice.png" class="img-responsive" style="width:100%" alt="Image"></div>
            <div class="col-sm-3"><p>AC</p><img src="asset/image/ac.png" class="img-responsive" style="width:100%" alt="Image"></div>
            <div class="col-sm-3"><p>cabin</p><img src="asset/image/cabin3.png" class="img-responsive" style="width:100%" alt="Image"></div>
        </div>
    </div><br>
    <div>
    <?php include "visualization/bar.php"; ?></div>
    


    <div class="text-center mt-4">
        <a href="PHP/logout.php" class="btn btn-danger"><i class="fa fa-sign-out"></i> LOGOUT</a>
    </div><br>
</div>

<!-- Fixed Chatbot Button -->
<form action="bot/main.php" method="get" id="chatbotBtn" title="Chat with Bot">
    <button type="submit">
        <img src="asset/image/AI.jpg" alt="Chatbot" />
    </button>
</form>

<?php require 'includes/footer.php'; ?>
