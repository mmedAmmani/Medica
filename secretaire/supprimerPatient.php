<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["role"] != 'secretaire'){
        header("location: ../login.php");
    }
    $connect = new PDO('mysql:host=localhost;dbname=medica', 'root', '');
    $id = (int) $_GET['id'];
    $query = "DELETE FROM fichepatient where id = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id);
    if($stmt->execute()){
        header('location: listepatients.php');
    }