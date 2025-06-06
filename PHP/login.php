<?php
session_start();
include("../config/connection.php");
class Login extends Database{
    public function login(){
        $conn =  $this->connection();
        $email = $_POST['email'];
        $password = $_POST['password'];


        $check = $conn->query("SELECT * FROM user WHERE email='$email' AND pasword='$password'");
        $name ="";
        while($new = $check->fetch()){
            $name = $new['name'];
            
        }

        if ($check->rowCount() > 0) {
            $_SESSION['user_name']=$name;
            
            echo'
            <script>
            alter("Successfully login");
            </script>
            ';
            header("Location: ../index1.php");
            exit;
            
        }
        else {
            echo'
            <script>
            alert("Invalid Credentials or User not found");
            </script>
            ';
            header("Location: ../index.html");
        }
    }
}
$login = new Login();
$login->login();

// $email = $_POST['email'];
// $password = $_POST['password'];


// $check = $_oconnect->query("SELECT * FROM user WHERE email='$email' AND pasword='$password'");
// $name ="";
// while($new = $check->fetch()){
//     $name = $new['name'];
    
// }

// if ($check->rowCount() > 0) {
//     $_SESSION['user_name']=$name;
    
//     echo'
//     <script>
//     alter("Successfully login");
//     </script>
//     ';
//     header("Location: ../index1.php");
//     exit;
    
// }
// else {
//     echo'
//     <script>
//     alert("Invalid Credentials or User not found");
//     </script>
//     ';
//     header("Location: ../index.html");
// }

?>