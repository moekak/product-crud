<?php

// connecting to databse
$pdo = new PDO('mysql:host=localhost;dbname=product_crud', "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id = '';
if(isset($_POST["id"])){
    $id = $_POST["id"];
} else{
    header('Location: index.php');
}

$statement = $pdo->prepare("DELETE FROM `products` WHERE `products`.`id` = :id");
$statement->bindValue(':id', $id);
$statement->execute();
header("Location: index.php")



?>