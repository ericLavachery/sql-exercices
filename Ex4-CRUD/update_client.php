<?php
$teou = 'Modifier Client';
$formMessage = '';

$modID = $_GET['id'];

$id = '';
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
        $id = $_POST['id'];
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
        $tab = array(
            ':id' => $id,
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':birthDate' => $birthDate,
            ':card' => $card,
            ':cardNumber' => $cardNumber,
            ':cardTypesId' => $cardTypesId
        );
        $sql = "UPDATE clients SET firstName=:firstName, lastName=:lastName, birthDate=:birthDate, card=:card, cardNumber=:cardNumber WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tab);
        $formMessage = 'Le client a bien été modifié';
        // echo "New record created successfully";
    } else {
        $stmt = $conn->prepare("SELECT * FROM clients WHERE id = $modID");
        $stmt->execute();
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $k=>$v) {
            $firstName = $v['firstName'];
            $lastName = $v['lastName'];
            $birthDate = $v['birthDate'];
            $card = $v['card'];
            $cardNumber = $v['cardNumber'];
        }
        $bdate = date_create_from_format('Y-m-d', $birthDate);
        $formBD = date_format($bdate, 'd/m/Y');
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
    <title>COLYSEUM | Ajout client</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <?php include('_navig.php'); ?>

    <h1>Ajouter un CLIENT</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $modID ?>">
            <?php include('_form.php'); ?>
            <button type="submit" name="button">Modifier</button>
        </form>
        <p class="rouge"><?= $formMessage ?></p>

</body>
</html>
