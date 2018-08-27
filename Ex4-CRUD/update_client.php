<?php
$teou = 'Modifier Client';
$formMessage = '';
$cardMessage = '';

$modID = $_GET['id'];
$delOK = false;

$id = '';
$firstName = '';
$lastName = '';
$birthDate = '';
$formBD = '';
$card = '';
$cardNumber = '';
$cardTypesId = '';
$cardNumberRem = '';

$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "colyseum";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["button"])) {
        // UPDATE
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
        // l'ancien numéro de carte (pour faire l'update)
        if ($_POST['cardNumberRem'] == '') {
            $cardNumberRem = 0;
        } else {
            $cardNumberRem = $_POST['cardNumberRem'];
        }
        // modifie client
        $tab = array(
            ':id' => $id,
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':birthDate' => $birthDate,
            ':card' => $card,
            ':cardNumber' => $cardNumber
        );
        $sql = "UPDATE clients SET firstName=:firstName, lastName=:lastName, birthDate=:birthDate, card=:card, cardNumber=:cardNumber WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute($tab);
        // gère la carte
        $tab = array(
            ':cardTypesId' => $cardTypesId,
            ':cardNumber' => $cardNumber
        );
        if ($card == 1) {
            // modifie la carte
            $sql = "UPDATE cards SET cardTypesId=:cardTypesId, cardNumber=:cardNumber WHERE cardNumber=$cardNumberRem";
            $stmt = $conn->prepare($sql);
            $stmt->execute($tab);
            // si rien n'a été modifié, rajoute la carte
            $count = $stmt->rowCount();
            if ($count == 0) {
                $sql = "INSERT INTO cards (cardTypesId, cardNumber) VALUES (:cardTypesId, :cardNumber)";
                $stmt = $conn->prepare($sql);
                $stmt->execute($tab);
                $cardMessage = 'La carte a bien été ajoutée';
            } else {
                $cardMessage = 'La carte a bien été modifiée';
            }
        } else {
            // supprime la carte
            $sql = "DELETE FROM cards WHERE cardNumber=$cardNumberRem";
            $stmt = $conn->prepare($sql);
            $stmt->execute($tab);
            $cardMessage = 'La carte a bien été supprimée';
        }
        $formMessage = 'Le client a bien été modifié';
    } elseif (isset($_POST["del"])) {
        $card = $_POST['card'];
        // l'ancien numéro de carte
        if ($_POST['cardNumberRem'] == '') {
            $cardNumberRem = 0;
        } else {
            $cardNumberRem = $_POST['cardNumberRem'];
        }
        // DELETE
        $stmt = $conn->prepare("DELETE FROM clients WHERE id = $modID");
        $stmt->execute();
        $formMessage = 'Le client a bien été supprimé';
        $delOK = true;
        // supprime la carte
        if ($card == 1) {
            $sql = "DELETE FROM cards WHERE cardNumber=$cardNumberRem";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $cardMessage = 'La carte a bien été supprimée';
        }
    } else {
        // READ
        // read client
        $stmt = $conn->prepare("SELECT * FROM clients WHERE id = $modID");
        $stmt->execute();
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
        // read cards
        if ($card == 1) {
            $stmt = $conn->prepare("SELECT * FROM cards WHERE cardNumber = $cardNumber");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach($stmt->fetchAll() as $k=>$v) {
                $cardTypesId = $v['cardTypesId'];
                $cardNumber = $v['cardNumber'];
            }
        }
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

    <h1>Modifier un CLIENT</h1>
    <?php if (!$delOK) : ?>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $modID ?>">
        <?php include('_form.php'); ?>
        <button type="submit" name="button" id="modify">Modifier</button>
    </form>
    <form action="" method="post">
        <input type="hidden" name="card" value="<?= $card ?>">
        <input type="hidden" name="cardNumberRem" value="<?= $cardNumber ?>">
        <input type="hidden" name="id" value="<?= $modID ?>">
        <label for="del">&nbsp;</label>
        <button type="submit" name="del" id="delete">Supprimer</button>
    </form>
    <?php endif; ?>
    <p class="rouge"><?= $formMessage ?></p>
    <p class="rouge"><?= $cardMessage ?></p>

    <!-- show the card form -->
    <?php if ($card == 1) { ?><script type="text/javascript">startWithDiv();</script><?php } ?>
</body>
</html>
