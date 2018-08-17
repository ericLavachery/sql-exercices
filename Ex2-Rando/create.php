<?php
$teou = 'Ajouter';

$formMessage = '';

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
    <p><?php include('_navig.php'); ?></p>

    <h1>Ajouter</h1>
    <form action="" method="post">
        <div>
            <label for="name">Name</label>
            <input type="text" size="25" name="name" value="<?= $name ?>">
        </div>
        <div>
            <label for="difficulty">Difficulté</label>
            <select name="difficulty">
                <option value="très facile"<?php if ($difficulty == 'très facile') {echo ' selected';} ?>>Très facile</option>
                <option value="facile"<?php if ($difficulty == 'facile') {echo ' selected';} ?>>Facile</option>
                <option value="moyen"<?php if ($difficulty == 'moyen') {echo ' selected';} ?>>Moyen</option>
                <option value="difficile"<?php if ($difficulty == 'difficile') {echo ' selected';} ?>>Difficile</option>
                <option value="très difficile"<?php if ($difficulty == 'très difficile') {echo ' selected';} ?>>Très difficile</option>
            </select>
        </div>
        <div>
            <label for="distance">Distance</label>
            <input type="text" size="8" name="distance" value="<?= $distance ?>">
        </div>
        <div>
            <label for="duration">Durée</label>
            <input type="duration" size="8" name="duration" value="<?= $duration ?>">
        </div>
        <div>
            <label for="height_difference">Dénivelé</label>
            <input type="text" size="8" name="height_difference" value="<?= $height ?>">
        </div>
        <button type="submit" name="button">Envoyer</button>
    </form>
    <p><?= $formMessage ?></p>
</body>
</html>
