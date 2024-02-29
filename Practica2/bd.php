<?php

function connectToDatabase() {
    $conn = mysqli_connect("localhost", "root", "", "drivecrafters");;

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    echo "Connected successfully";

   
    

    mysqli_close($conn);
}

?>