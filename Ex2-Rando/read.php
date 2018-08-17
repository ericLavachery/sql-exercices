<?php
$teou = 'Liste';

session_start ();
if (isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
    $log = TRUE;
} else {
    $log = FALSE;
}

$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "reunion_island";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    $stmt = $conn->prepare("SELECT * FROM hiking");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $myTable = '';
    foreach($stmt->fetchAll() as $k=>$v) {
        $myTable = $myTable . '<tr>';
        $myTable = $myTable . '<td class="bibi">' . $v['name'] . '</td>';
        $myTable = $myTable . '<td class="bibi">' . $v['difficulty'] . '</td>';
        $myTable = $myTable . '<td class="bibi">' . $v['distance'] . ' km</td>';
        $myTable = $myTable . '<td class="bibi">' . $v['duration'] . '</td>';
        $myTable = $myTable . '<td class="bibi">' . $v['height_difference'] . ' m</td>';
        if ($log) {
            $myTable = $myTable . '<td class="bibi"><a href="update.php?id=' . $v['id'] . '">Modifier</a></td>';
            $myTable = $myTable . '<td class="bibi"><a href="delete.php?id=' . $v['id'] . '">Supprimer</a></td>';
        }
        $myTable = $myTable . '</tr>';
    }
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Randonnées</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <p><?php include('_navig.php'); ?></p>

    <h1>Liste des randonnées</h1>
    <table>
        <?= $myTable; ?>
    </table>
</body>
</html>
