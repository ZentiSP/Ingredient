<?php

session_start();
require_once "config/db.php";

if (isset($_POST['submit'])) {
    $unitM = $_POST['unit'];

    $prefix = 'UM';

    // Construct the SQL query
    $query = "SELECT MAX(CAST(SUBSTRING(Unit_ID, 3) AS UNSIGNED)) AS max_seq FROM unitmeasure WHERE Unit_ID LIKE :prefix";
    
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':prefix', "$prefix%");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxSeq = intval($row['max_seq']);
        $newSeq = $maxSeq + 1;
    } else {
        $newSeq = 1;
    }

    // Generate the new number
    $newSeqFormatted = str_pad($newSeq, 3, '0', STR_PAD_LEFT);
    $newID = $prefix . $newSeqFormatted;

    $sql = $conn->prepare("INSERT INTO unitmeasure(Unit_ID, Unit_Name) VALUES(:unitid, :unitname)");
    $sql->bindParam(":unitid", $newID);
    $sql->bindParam(":unitname", $unitM);
    $success = $sql->execute();

    // Check if the insertion was successful and redirect accordingly
    if ($success) {
        $_SESSION['success'] = "Data has been inserted successfully";
        header("location: UnitMeasure.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted successfully";
        header("location: UnitMeasure.php");
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
        <h1>Add Unit Measure</h1>
        <hr>
        <form action="addUnit.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 row g-2">
                <label for="unit" class="col-form-label">Unit</label>
                <input type="text" class="form-control" name="unit" placeholder="unitname Name" required>
            </div>
            <div class="mb-3">
                <a href="unitname.php" class="btn btn-secondary">Go Back</a>
                <button type="submit" name="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</body>

</html>