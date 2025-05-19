
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

try{
    
    $conn  = mysqli_connect($servername,$username,$password,$dbname);

}catch(Exception $e){
    echo $e->error_log();   
}



?>