<?php
// connecting to databse
$pdo = new PDO('mysql:host=localhost;dbname=product_crud', "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';

if (isset($_POST["submit"])) {

    $image = "";
    if (isset($_POST["image"])) {
        $image = $_POST["image"];
    }
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
    $imagePath= '';
    if($image && $image['temp_name']){
        $imagePath = 'images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname($imagePath));
        move_uploaded_file($image["tmp_name"], $imagePath);
    }

  
    

    // if (!is_dir("images")) {
    //     mkdir("images");
    // }


//     $imagePath = '';
//   echo print_r($image);


    // $image = "";
    // if(isset($_FILES["image"])){
    //     $image = $_FILES["image"];
    // }
    // if ($image && $image["temp_name"]) {
    //     echo "aaa";
    //     exit;
    //     $imagePath = 'images/' .randomString(8). '/' . $image['name'];
    //     // echo dirname($imagePath);
    //     mkdir(dirname($imagePath));
    //     // echo '<pre>';
    //     // var_dump($imagePath);
    //     // echo '</pre>';
    //     // exit;
    //     move_uploaded_file($image["tmp_name"], $imagePath);
    // }

    $date = date('Y-m-d H:i:s');

    $statement = $pdo->prepare("INSERT INTO `products`( `title`, `description`, `image`, `price`, `create_date`) VALUES (:title,:description,:image,:price,:date)");

    $statement->bindValue(':image', $imagePath);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':date', $date);

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
    <h1>Create new Product</h1>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
        <?php endforeach;?>
    </div>
    <?php endif;?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Image</label>
            <br>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label>Product Title</label>
            <input type="text" class="form-control" name="title">
        </div>

        <div class="form-group">
            <label>Product Description</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" step=".01" class="form-control" name="price">
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>



</body>

</html>