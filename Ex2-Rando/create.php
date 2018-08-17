<?php
$teou = 'Ajouter';
$formMessage = '';

session_start ();
if (isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
    $log = TRUE;
} else {
    $log = FALSE;
}

$name = '';
$difficulty = '';
$distance = '';
$duration = '';
$height = '';

$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "reunion_island";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["button"])) {
        $name = $_POST['name'];
        $difficulty = $_POST['difficulty'];
        $distance = $_POST['distance'];
        $duration = $_POST['duration'];
        $height = $_POST['height_difference'];
        $tab = array(
            ':name' => $name,
            ':difficulty' => $difficulty,
            ':distance' => $distance,
            ':duration' => $duration,
            ':height' => $height
        );
        $sql = "INSERT INTO hiking (name, difficulty, distance, duration, height_difference) VALUES (:name, :difficulty, :distance, :duration, :height)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tab);
        $formMessage = 'La nouvelle randonnée a bien été ajoutée';
        // echo "New record created successfully";
    }
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter une randonnée</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <?php include('_navig.php'); ?>

    <h1>Ajouter une randonnée</h1>
    <?php if($log): ?>
        <form action="" method="post">
            <?php require('_form.php') ?>
            <label for="button">&nbsp;</label>
            <button type="submit" name="button">Ajouter</button>
        </form>
        <p><?= $formMessage ?></p>
    <?php else: ?>
        <p>Vous devez vous connecter pour pouvoir ajouter une randonnée</p>
    <?php endif; ?>
</body>
</html>
