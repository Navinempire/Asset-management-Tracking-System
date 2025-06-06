<?php
class Database{
    public function connection(){
        define('DBDRIVE','mysql');
        define('DBHOST','localhost');
        define('DBNAME','asset_tracker');
        define('DBUSER','root');
        define('DBPASS','');


        // $connect = mysqli_connect("localhost","root","","asset_tracker");
        $_Sdriver = DBDRIVE.":host=".DBHOST.";dbname=".DBNAME;
        $_oconnect = new PDO($_Sdriver,DBUSER,DBPASS);

        return $_oconnect;
    }
}



?>