<?php
$teou = 'Ajouter Client';
$formMessage = '';

$name = '';
$difficulty = '';
$distance = '';
$duration = '';
$height = '';

$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "colyseum";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["button"])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $birthDate = $_POST['birthDate'];
        $card = $_POST['card'];
        $cardNumber = $_POST['cardNumber'];
        $tab = array(
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':birthDate' => $birthDate,
            ':card' => $card,
            ':cardNumber' => $cardNumber
        );
        $sql = "INSERT INTO clients (firstName, lastName, birthDate, card, cardNumber) VALUES (:firstName, :lastName, :birthDate, :card, :cardNumber)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tab);
        $formMessage = 'Le nouveau a bien été ajouté';
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

    <h1>Ajouter un CLIENT</h1>
        <form action="" method="post">
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" value="<?= $name ?>">
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
                <input type="text" name="distance" value="<?= $distance ?>">
            </div>
            <div>
                <label for="duration">Durée</label>
                <input type="duration" name="duration" value="<?= $duration ?>">
            </div>
            <div>
                <label for="height_difference">Dénivelé</label>
                <input type="text" name="height_difference" value="<?= $height ?>">
            </div>
            <label for="button">&nbsp;</label>
            <button type="submit" name="button">Ajouter</button>
        </form>
        <p><?= $formMessage ?></p>

</body>
</html>
