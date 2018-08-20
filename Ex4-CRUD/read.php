<?php
$servername = "localhost";
$username = "root";
$password = "zen8070\$mysql";
$myDB = "colyseum";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 5 premiers clients avec carte id
    $stmt = $conn->prepare("SELECT *
        FROM clients
        WHERE card=1
        LIMIT 5;
        ");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $clientTable = '';
    foreach($stmt->fetchAll() as $k=>$v) {
        $clientTable = $clientTable . '<tr>';
        $clientTable = $clientTable . '<td class="bibi">' . $v['firstName'] . ' ' . $v['lastName'] . '</td>';
        $clientTable = $clientTable . '</tr>';
    }
    // Tous les spectacles
    $stmt = $conn->prepare("SELECT *
        FROM showTypes;
        ");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $specTable = '';
    foreach($stmt->fetchAll() as $k=>$v) {
        $specTable = $specTable . '<tr>';
        $specTable = $specTable . '<td class="bibi">' . $v['type'] . '</td>';
        $specTable = $specTable . '</tr>';
    }
    // noms et prénoms des clients dont le nom commence par M (ordre alpha)
    $stmt = $conn->prepare("SELECT firstName, lastName
        FROM clients
        WHERE lastName LIKE 'M%'
        ORDER BY lastName ASC;");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $mTable = '';
    foreach($stmt->fetchAll() as $k=>$v) {
        $mTable = $mTable . '<tr>';
        $mTable = $mTable . '<td class="bibi">Nom: ' . $v['lastName'] . '</td>';
        $mTable = $mTable . '</tr>';
        $mTable = $mTable . '<tr>';
        $mTable = $mTable . '<td class="bibi-line">Prénom: ' . $v['firstName'] . '</td>';
        $mTable = $mTable . '</tr>';
    }
    // Afficher le titre de tous les spectacles ainsi que l'artiste, la date et l'heure. Trier les titres par ordre alphabétique. Afficher les résultat comme ceci : Spectacle par artiste, le date à heure.
    $stmt = $conn->prepare("SELECT `title`, `performer`, `date`, `startTime`
        FROM shows
        ORDER BY `date` ASC;
        ");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $showsTable = '';
    foreach($stmt->fetchAll() as $k=>$v) {
        $laDate = date_create_from_format('Y-m-d', $v['date']);
        $maDate = date_format($laDate, 'd/m/Y');
        $laHeure = date_create_from_format('H:i:s', $v['startTime']);
        $maHeure = date_format($laHeure, 'H:i');
        $maHeure = str_replace(':', 'h', $maHeure);
        $showsTable = $showsTable . '<tr>';
        $showsTable = $showsTable . '<td class="bibi"><span class="mauve">' . $v['title'] . '</span> par <span class="noir">' . $v['performer'] . '</span> le ' . $maDate . ' à ' . $maHeure . '</td>';
        $showsTable = $showsTable . '</tr>';
    }
    // Complet boulettes
    $stmt = $conn->prepare("SELECT
        shows.title,
        showTypes.type AS type,
        g1.genre AS genre1,
        g2.genre AS genre2
        FROM
        shows
        LEFT JOIN genres AS g1 ON shows.firstGenresId = g1.id
        LEFT JOIN genres AS g2 ON shows.secondGenreId = g2.id
        LEFT JOIN showTypes ON shows.showTypesId = showTypes.id
        ORDER BY `date` ASC;
        ");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $relShowTable = '';
        foreach($stmt->fetchAll() as $k=>$v) {
            $relShowTable = $relShowTable . '<tr>';
            $relShowTable = $relShowTable . '<td class="bibi"><span class="mauve">' . $v['title'] . '</span></td>';
            $relShowTable = $relShowTable . '<td class="bibi">' . $v['type'] . '</td>';
            $relShowTable = $relShowTable . '<td class="bibi">' . $v['genre1'] . ', ' . $v['genre2'] . '</td>';
            $relShowTable = $relShowTable . '</tr>';
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
        <h3>5 premiers clients ayant une carte d'identité</h3>
        <table>
            <?= $clientTable; ?>
        </table>
        <h3>Types de pestacles</h3>
        <table>
            <?= $specTable; ?>
        </table>
        <h3>Clients M% par ordre alpha</h3>
        <table>
            <?= $mTable; ?>
        </table>
        <h3>Spectacles</h3>
        <table>
            <?= $showsTable; ?>
        </table>
        <h3>Complet boulettes</h3>
        <table>
            <?= $relShowTable; ?>
        </table>
    </body>
    </html>
