<?php
    $conn = new mysqli ("localhost", "root", "", "cyberian");

    if($conn -> connect_error){
        die("Conncection Failed: " . $conn->connection_error);
    }
?>