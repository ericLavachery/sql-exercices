<?php
$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "colyseum";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM clients");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $myTable = '';
    foreach($stmt->fetchAll() as $k=>$v) {
        $myTable = $myTable . '<tr>';
        $myTable = $myTable . '<td class="bibi">' . $v['firstName'] . ' ' . $v['lastName'] . '</td>';
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
    <title>Colyseum</title>
    <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <h1>Colyseum</h1>
    <table>
        <?= $myTable; ?>
    </table>
</body>
</html>
