<?php
$teou = 'Liste Clients';

$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "colyseum";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    $stmt = $conn->prepare("SELECT * FROM clients");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
    <title>COLYSEUM</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8">
</head>
<body>

    <h1>Liste des CLIENTS</h1>
    <table>
        <tr>
            <td class="titre">Prénom</td>
            <td class="titre">Nom</td>
            <td class="titre">Date de naissance</td>
            <td class="titre">Carte?</td>
            <td class="titre">N°Carte</td>
            <td class="titre"></td>
        </tr>
        <?php
        foreach($stmt->fetchAll() as $k=>$v) {
            if ($v['card'] == 1) {
                $isCard = 'Oui';
            } else {
                $isCard = '';
            }
            ?>
            <tr>
                <td class="bibi"><?= $v['firstName'] ?></td>
                <td class="bibi"><?= $v['lastName'] ?></td>
                <td class="bibi"><?= $v['birthDate'] ?></td>
                <td class="bibi"><?= $isCard ?></td>
                <td class="bibi"><?= $v['cardNumber'] ?></td>
                <td class="bibi"><a href="update_client.php?id=<?= $v['id'] ?>">Modifier</a></td>
            </tr>
            <?php
        }
        ?>
    </table>
</body>
</html>
