<?php
$teou = 'Modifier';

$formMessage = '';

$modID = $_GET['id'];

$id = '';
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
        $id = $_POST['id'];
        $name = $_POST['name'];
        $difficulty = $_POST['difficulty'];
        $distance = $_POST['distance'];
        $duration = $_POST['duration'];
        $height = $_POST['height_difference'];
        $tab = array(
            ':id' => $id,
            ':name' => $name,
            ':difficulty' => $difficulty,
            ':distance' => $distance,
            ':duration' => $duration,
            ':height' => $height
        );
        $sql = "UPDATE hiking SET name=:name, difficulty=:difficulty, distance=:distance, duration=:duration, height_difference=:height WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tab);
        $formMessage = 'La randonnée a bien été modifiée';
        // echo "New record created successfully";
    } else {
        $stmt = $conn->prepare("SELECT * FROM hiking WHERE id = $modID");
        $stmt->execute();
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $k=>$v) {
            $name = $v['name'];
            $difficulty = $v['difficulty'];
            $distance = $v['distance'];
            $duration = $v['duration'];
            $height = $v['height_difference'];
        }
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
    <title>Modifier une randonnée</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <p><?php include('_navig.php'); ?></p>

    <h1>Modifier une randonnée</h1>
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
        <input type="hidden" name="id" value="<?= $modID ?>">
        <button type="submit" name="button">Modifier</button>
    </form>
    <p><?= $formMessage ?></p>
</body>
</html>
