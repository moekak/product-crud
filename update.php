<?php
// connecting to databse
$pdo = new PDO('mysql:host=localhost;dbname=product_crud', "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = '';
if(isset($_GET["id"])){
    $id = $_GET["id"];
} 
$statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$title = $product["title"];
$price = $product["price"];
$description = $product["description"];
// echo '<pre>';
// var_dump($product);
// echo '</pre>';

$errors = [];
// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';

if (isset($_POST["submit"])) {
    $title = "";
    if (isset($_POST["title"])) {
        $title = $_POST["title"];
    }
    $description = "";
    if (isset($_POST["description"])) {
        $description = $_POST["description"];
    }
    $price = "";
    if (isset($_POST["price"])) {
        $price = $_POST["price"];
    }

    if (!$title) {
        $errors[] = "Product title is required";

    }
    if (!$price) {
        $errors[] = "Product price is required";
    }
}



// echo '<pre>';
//     var_dump($_FILES);
// echo '</pre>';

if(!is_dir('images')){
    mkdir('images');
}

if (empty($errors) && isset($_POST["submit"])) {
    $image = $_FILES["image"] ?? null;
    $imagePath= $product["image"];
    if($image && $image['tmp_name']){
        if($product["image"]){
            unlink($product["image"]);
        }
    
        $imagePath = 'images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname($imagePath));
        move_uploaded_file($image["tmp_name"], $imagePath);
    }

 

  
    

    $date = date('Y-m-d H:i:s');

    $statement = $pdo->prepare("UPDATE  `products` SET  `title`= :title,  `description` = :description, `image` = :image, `price` = :price WHERE id = :id" );


    $statement->bindValue(':image', $imagePath);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':id', $id);

    $statement->execute();

    header('Location: index.php');

}
;

function randomString($n)
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str = $str.$characters[$index];
    }

    return $str;
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Create new products</title>
</head>

<body>
    <p>
        <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
    </p>


    <h1>Update Product <b><?php echo $product["title"]?></b> </h1>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
        <?php endforeach;?>
    </div>
    <?php endif;?>

    <form method="post" enctype="multipart/form-data">

        <?php if($product["image"]):?>
        <img src="<?php echo $product["image"]?>" alt="" class="update-image">
        <?php endif;?>
        <div class="form-group">
            <label>Product Image</label>
            <br>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label>Product Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $title?>">
        </div>

        <div class="form-group">
            <label>Product Description</label>
            <textarea class="form-control" name="description"><?php echo $description?></textarea>
        </div>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" step=".01" class="form-control" name="price" value="<?php echo $price?>">
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>



</body>

</html>