<?php

session_start();
require_once "config/db.php";

if (isset($_POST['submit'])) {
    $categoryName = $_POST['categoryName'];


    $sql = $conn->prepare("INSERT INTO ingredient_category(IngredientType) VALUES(:categoryName)");
    $sql->bindParam(":categoryName", $categoryName);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been inserted Succesfully";
        header("location: Category.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted Succesfully";
        header("location: Category.php");
    }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <div class="container mt-5 bg-light">
        <h1>Add Category</h1>
        <hr>
        <form action="addCategory.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 row g-2">
                <label for="categoryName" class="col-form-label">Category Name</label>
                <input type="text" class="form-control" name="categoryName" placeholder="Category Name" required>
            </div>
            <div class="mb-3">
                <a href="Category.php" class="btn btn-secondary">Go Back</a>
                <button type="submit" name="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</body>

</html>