<?php
include("../config/connection.php");
class Register extends Database{
    public function register(){
        $conn = $this->connection();
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $cpassword = $_POST['Cpassword'];
        $email =$_POST['email'];

        if($password==$cpassword){
            if(!empty($_POST)){
                $insertQuery = "INSERT INTO user(name,mobile,pasword,c_password,email) VALUES (?,?,?,?,?)" ;
                $insert = $conn->prepare($insertQuery);
                $insert->bindParam(1,$name);
                $insert->bindParam(2,$mobile);
                $insert->bindParam(3,$password);
                $insert->bindParam(4,$cpassword);
                $insert->bindParam(5,$email);
                $insert->execute();
            }
            
            if($insert){
                echo '
                <script>
                alert("Registration Successfully");
                </script>';
                header("Location: ../log.html");
            }
            else{
                echo '
                <script>
                alert("Some Error Occured!");
                
                </script>
                ';
                header("Location: ../register.html");
            }
        }
        else{
            echo '
            <script>
                alert("Password and Confirm Password does not match");
            </script>
            ';
            header("Location: ../register.html");
        }
    }
}
$register = new Register();
$register->register();

// $name = $_POST['name'];
// $mobile = $_POST['mobile'];
// $password = $_POST['password'];
// $cpassword = $_POST['Cpassword'];
// $email =$_POST['email'];

// if($password==$cpassword){
//     if(!empty($_POST)){
//         $insertQuery = "INSERT INTO user(name,mobile,pasword,c_password,email) VALUES (?,?,?,?,?)" ;
//         $insert = $_oconnect->prepare($insertQuery);
//         $insert->bindParam(1,$name);
//         $insert->bindParam(2,$mobile);
//         $insert->bindParam(3,$password);
//         $insert->bindParam(4,$cpassword);
//         $insert->bindParam(5,$email);
//         $insert->execute();
//     }
    
//     if($insert){
//         echo '
//         <script>
//         alert("Registration Successfully");
//         </script>';
//         header("Location: ../log.html");
//     }
//     else{
//         echo '
//         <script>
//         alert("Some Error Occured!");
        
//         </script>
//         ';
//         header("Location: ../register.html");
//     }
// }
// else{
//     echo '
//     <script>
//         alert("Password and Confirm Password does not match");
//     </script>
//     ';
//     header("Location: ../register.html");
// }

?>