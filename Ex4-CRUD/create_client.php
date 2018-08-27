<?php
$teou = 'Ajouter Client';
$formMessage = '';
$cardMessage = '';

$firstName = '';
$lastName = '';
$birthDate = '';
$formBD = '';
$card = '';
$cardNumber = '';
$cardTypesId = '';

$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "colyseum";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["button"])) {
        $cardTypesId = $_POST['cardTypesId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $formBD = $_POST['birthDate'];
        $bdate = date_create_from_format('d/m/Y', $formBD);
        $birthDate = date_format($bdate, 'Y-m-d');
        $card = $_POST['card'];
        if ($card == 1) {
            $cardNumber = $_POST['cardNumber'];
            $cardTypesId = $_POST['cardTypesId'];
        } else {
            $cardNumber = null;
            $cardTypesId = null;
        }
        // ajouter client
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
        // ajouter carte
        $tab = array(
            ':cardTypesId' => $cardTypesId,
            ':cardNumber' => $cardNumber
        );
        $sql = "INSERT INTO cards (cardTypesId, cardNumber) VALUES (:cardTypesId, :cardNumber)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tab);
        $cardMessage = 'La carte a bien été ajoutée';
    }
}
catch(PDOException $e)
{
    echo $sql . ' ' . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>COLYSEUM | Ajout client</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <?php include('_navig.php'); ?>

    <h1>Ajouter un CLIENT</h1>
        <form action="" method="post">
            <?php include('_form.php'); ?>
            <button type="submit" name="button" id="modify">Ajouter</button>
        </form>
        <p class="rouge"><?= $formMessage ?></p>
        <p class="rouge"><?= $cardMessage ?></p>

</body>
</html>
