<?php

session_start();
if(!isset($_SESSION['user_name'])){
    header("Location:index.html");
    exit();
}
error_reporting(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Asset Management & Traking</title>
<link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css"/>
<link rel="stylesheet" href="asset/css/all.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="asset/css/style.css">
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>

    



</head>
<body>
    <div class="containers">
        <nav class="navbar navbar-expand-lg navbar-light bg-light custom-nav">
            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="brand-container">
                    <img src="asset/image/logo.png" class="brand-logo" alt="Logo">
                    <div class="brand-text">
                        <a class="navbar-brand" href="#">Asset Traking</a>
                        <div class="user">
                            <center><?php echo "Welcome ";isset($_SESSION['user_name'])? (print_r($_SESSION['user_name'])):print_r("Guest"); ?></center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">home</a></li>
                    <li><a href="#asset">Asset</a></li>
                    <li><a href="#product">products</a></li>
                    <li><a href="index.html" class="btn btn-success"><i class="fa fa-user-circle" aria-hidden="true"></i> login</a></li>
                </ul>
            </div>
            
        </nav>
    </div>