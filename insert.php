<?php

session_start();
require_once "config/db.php";

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $subcategory = $_POST['subscategory'];
    $unit = $_POST['unit'];
    $ingName = $_POST['Name'];
    $flavor = $_POST['flavor'];
    $allergic = $_POST['Allergic'];

    $sql = $conn->prepare("INSERT INTO ingredient(IngredientC_ID, SubsCategoryID, Unit_ID, ingredientName, flavor, isAllergic) VALUES(:category, :subcategory, :unit, :ingName, :flavor, :allergic)");
    $sql->bindParam(":category", $category);
    $sql->bindParam(":subcategory", $subcategory);
    $sql->bindParam(":unit", $unit);
    $sql->bindParam(":ingName", $ingName);
    $sql->bindParam(":flavor", $flavor);
    $sql->bindParam(":allergic", $allergic);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been inserted Succesfully";
        header("location: index.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted Succesfully";
        header("location: index.php");
    }
}
?>