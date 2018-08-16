<?php
try
{
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=reunion_island;charset=utf8', 'root', 'zen8070$mysql');
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}
$resultat = $bdd->query('SELECT * FROM hiking');
$donnees = $resultat->fetch();
$myTable = '';
while ($donnees = $resultat->fetch())
{
    $myTable = $myTable . '<tr>';
    $myTable = $myTable . '<td class="bibi">' . $donnees['name'] . '</td>';
    $myTable = $myTable . '<td class="bibi">' . $donnees['difficulty'] . '</td>';
    $myTable = $myTable . '<td class="bibi">' . $donnees['distance'] . ' km</td>';
    $myTable = $myTable . '<td class="bibi">' . $donnees['duration'] . '</td>';
    $myTable = $myTable . '<td class="bibi">' . $donnees['height_difference'] . ' m</td>';
    $myTable = $myTable . '</tr>';
}

// fermeture de la connection à la bdd
if ($bdd) {
    $bdd = NULL;
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
    <h1>Liste des randonnées</h1>
    <table>
        <?= $myTable; ?>
    </table>
</body>
</html>
