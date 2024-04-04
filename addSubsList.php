<?php

session_start();
require_once "config/db.php";

if (isset($_POST['submit'])) {
    $units = $_POST['category'];
    $subscategory = $_POST['subscategory'];

    $sql = $conn->prepare("INSERT INTO subscategory_list(IngredientC_ID, SubsCategoryID) VALUES(:category, :subscategory)");
    $sql->bindParam(":category", $units);
    $sql->bindParam(":subscategory", $subscategory);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been inserted Succesfully";
        header("location: SubsCategoryList.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted Succesfully";
        header("location: SubsCategoryList.php");
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
        <h1>Pair SubsCategory</h1>
        <hr>
        <form action="addSubsList.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="category" class="col-form-label">Ingredient Category</label>
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                    name="category" required>
                    <?php
                    $stmt = $conn->query("SELECT * FROM ingredient_Category");
                    $stmt->execute();
                    $categories = $stmt->fetchAll();
                    foreach ($categories as $c) {
                        ?>
                        <option value="<?php echo $c['IngredientC_ID'] ?>">
                            <?php echo $c['IngredientType'] ?>
                        </option>
                    <?php }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="category" class="col-form-label">Ingredient SubCategory</label>
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                    name="subscategory" required>
                    <?php
                    $stmt = $conn->query("SELECT * FROM ingredient_subcategory");
                    $stmt->execute();
                    $unit = $stmt->fetchAll();
                    foreach ($unit as $s) {
                        ?>
                        <option value="<?php echo $s['SubsCategoryID']?>">
                            <?php echo $s['SubsCategory'] ?>
                        </option>
                    <?php }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <a href="SubsCategoryList.php" class="btn btn-secondary">Go Back</a>
                <button type="submit" name="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</body>

</html>