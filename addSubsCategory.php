<?php

session_start();
require_once "config/db.php";

if (isset($_POST['submit'])) {
    $SubsCName = $_POST['subscategoryName'];


    $sql = $conn->prepare("INSERT INTO ingredient_subcategory(SubsCategory) VALUES(:SubsCategory)");
    $sql->bindParam(":SubsCategory", $SubsCName);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been inserted Succesfully";
        header("location: SubsCategory.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted Succesfully";
        header("location: SubsCategory.php");
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
        <h1>Add SubsCategory</h1>
        <hr>
        <form action="addSubsCategory.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 row g-2">
                <label for="subscategoryName" class="col-form-label">SubsCategory Name</label>
                <input type="text" class="form-control" name="subscategoryName" placeholder="SubsCategory Name" required>
            </div>
            <div class="mb-3">
                <a href="SubsCategory.php" class="btn btn-secondary">Go Back</a>
                <button type="submit" name="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</body>

</html>