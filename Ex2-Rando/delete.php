<?php
$teou = 'Supprimer';

$formMessage = '';
$delOK = FALSE;

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
        $tab = array(
            ':id' => $id
        );
        $sql = "DELETE FROM hiking WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tab);
        $formMessage = 'La randonnée a bien été supprimée';
        $delOK = TRUE;
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
    <title>Supprimer une randonnée</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <p><?php include('_navig.php'); ?></p>

    <h1>Supprimer une randonnée</h1>

    <?php if (!$delOK) : ?>
    <form action="" method="post">
        <?php require('_form.php') ?>
        <input type="hidden" name="id" value="<?= $modID ?>">
        <button type="submit" name="button">Supprimer</button>
    </form>
    <?php endif; ?>
    <p><?= $formMessage ?></p>
</body>
</html>
