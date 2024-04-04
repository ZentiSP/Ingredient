<?php

session_start();
require_once "config/db.php";

$search = '';

$stmt = $conn->query("SELECT * FROM ingredient");
$stmt->execute();
$ings = $stmt->fetchAll();

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $searchStmt = $conn->query("SELECT * FROM ingredient 
    WHERE flavor like '%$search%' 
    or ingredientID like '%$search%' 
    or IngredientC_ID like '%$search%'
    or SubsCategoryID like '%$search%' 
    or ingredientName like '%$search%'");
    $searchStmt->execute();
    $ings = $searchStmt->fetchAll();
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM ingredient WHERE id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted succesfully";
        header("refresh:1; url=index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code test Website</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .container {
            max-width: 950px;
        }

        a {
            text-decoration: none;
        }

        td {
            font-size: 18px;
        }

        .nav {
            background-color: #e3f2fd;
        }

        .nav-link {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <ul class="nav justify-content-center mb-3"></ul>
    <script src="js\navbar.js" defer></script>

    <!-- Modal add user -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Ingredient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert.php" method="post" enctype="multipart/form-data">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <!-- Website header text -->
                <a href="index.php">
                    <h1>Ingredint in system</h1>
                </a>
            </div>
        </div>
        <!-- Search & add user tab bar -->
        <div class="container text-center">
            <div class="row">
                <!-- Search tab -->
                <div class="col-md-6">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search"
                            value="<?php echo $search ?>" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
                <!-- Add user button -->
                <div class="col-md-6 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"
                        data-bs-whatever="@mdo" style=" --bs-btn-padding-x: .5rem;">Add
                        ingredient
                    </button>
                </div>
            </div>
        </div>

        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th scope="col">ingredientID</th>
                    <th scope="col">IngredientC_ID</th>
                    <th scope="col">SubsCategoryID</th>
                    <th scope="col">unitM_ID</th>
                    <th scope="col">ingredientName</th>
                    <th scope="col">flavor</th>
                    <th scope="col">isAllergic?</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody class="table-light">
                <?php
                if (!$ings) {
                    echo "<p><td colspan='8' class='text-center'>No data available</td></p>";
                } else {
                    foreach ($ings as $ing) {
                        ?>
                        <tr>
                            <th scope="row">
                                <?= $ing['ingredientID']; ?>
                            </th>
                            <td>
                                <?= $ing['IngredientC_ID']; ?>
                            </td>
                            <td>
                                <?= $ing['SubsCategoryID']; ?>
                            </td>
                            <td>
                                <?= $ing['unitM_ID']; ?>
                            </td>
                            <td>
                                <?= $ing['NutrientID']; ?>
                            </td>
                            <td>
                                <?= $ing['ingredientName']; ?>
                            </td>
                            <td>
                                <?= $ing['flavor']; ?>
                            </td>
                            <td>
                                <?= $ing['isAllergic']; ?>
                            </td>
                            <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning">Edit</a>
                            <a onclick="return confirm('Are you sure you want to delete?');"
                                href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    <script>
        let imgInput = document.getElementById('imginput');
        let previewImg = document.getElementById('previewimg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file)
            }
        }

    </script>
</body>

</html>