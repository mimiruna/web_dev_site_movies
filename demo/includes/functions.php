<?php
function runtime_prettier($length){
    $hours=intval($length/60);
    $minutes=$length%60;
    $result=$hours;
    if($hours==1)
        $result=$result . ' hour ' . $minutes;
    else
        $result=$result . ' hours ' . $minutes;
    if($minutes==1)
       $result=$result . ' minute';
    else
        $result=$result . ' minutes';
    return $result;
}

function connectDatabase($hostname = "localhost", $username = "php_user", $password = "php_password", $database = "php_proiect")
{
    
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if (!$conn) {
        die("Connetion to database failed: " . mysqli_connect_error());
    }
    return $conn;
}

function eroare()
      {
        echo "ID-ul nu a fost gasit sau receptionat! \n";
        echo "<a href='movies.php' class='btn btn-primary'>Read more</a>";
      }

?>