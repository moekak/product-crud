<?php
// connecting to databse
$pdo = new PDO('mysql:host=localhost;dbname=product_crud', "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare("SELECT * FROM `products` ");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
// print_r($products);

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

    <title>Hello, world!</title>
</head>

<body>
    <h1>Products Crud</h1>
    <p>
        <a href="create.php" class="btn btn-success">Create Product</a>
    </p>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Crate Date</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $i => $product) {?>
            <tr>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td><img src="<?php echo $product["image"] ?>" alt=""></td>
                <td><?php echo $product["title"] ?></td>
                <td><?php echo $product["price"] ?></td>
                <td><?php echo $product["create_date"] ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Delete</button>
                </td>
            </tr>
            <?php }?>


        </tbody>
    </table>


</body>

</html>