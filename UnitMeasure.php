<?php

session_start();
require_once "config/db.php";

$search = '';

$stmt = $conn->query("SELECT * FROM unitmeasure");
$stmt->execute();
$units = $stmt->fetchAll();

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $searchStmt = $conn->query("SELECT * FROM unitmeasure 
    WHERE Unit_Name like '%$search%' 
    or Unit_ID  like '%$search%'");

    $searchStmt->execute();
    $units = $searchStmt->fetchAll();
}
?>

<?php

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->prepare("DELETE FROM unitmeasure WHERE Unit_ID = :delete_id");
    $deletestmt->bindParam(':delete_id', $delete_id);
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted succesfully";
        header("refresh:1; url=UnitMeasure.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>category</title>

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

    <div class="container">
        <div class="mb-3">
            <!-- Website header text -->
            <a href="UnitMeasure.php">
                <h1>Unit Measure for Ingredient</h1>
            </a>
        </div>
        <!-- Search & add user tab bar -->
        <div class="container text-center mb-3">
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
                    <a href="addUnit.php" class="btn btn-primary">Add Unit Measure</a>
                </div>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th scope="col">UnitID</th>
                    <th scope="col">Unit Name</th>
                    <th scope="col">Option</th>

                </tr>
            </thead>
            <tbody class="table-light">
                <?php
                if (!$units) {
                    echo "<p><td colspan='8' class='text-center'>No data available</td></p>";
                } else {
                    foreach ($units as $unit) {
                        ?>
                        <tr>
                            <th scope="row">
                                <?= $unit['Unit_ID']; ?>
                            </th>
                            <td>
                                <?= $unit['Unit_Name']; ?>
                            </td>
                            <td>
                                <a href="" class="btn btn-warning">Edit</a>
                                <a onclick="return confirm('Are you sure you want to delete?');"
                                    href="?delete=<?php echo $unit['Unit_ID']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>