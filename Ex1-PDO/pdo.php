<?php
try
{
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=weatherapp;charset=utf8', 'root', 'zen8070$mysql');
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}

// recherche villes
$qVilles = $bdd->query('SELECT ville FROM Météo');
$listeVilles = $qVilles->fetch();

$formMessage = '';
$ville = '';
$haut = '';
$bas = '';

// si formulaire envoyé
if (isset($_POST["submit"])) {

    $ville = ucwords(strtolower($_POST['ville']));
    $ville = filter_var($ville, FILTER_SANITIZE_STRING);
    $haut = filter_var($_POST['haut'], FILTER_SANITIZE_NUMBER_INT);
    $bas = filter_var($_POST['bas'], FILTER_SANITIZE_NUMBER_INT);

    if ($ville != "" && $haut != "" && $bas != "") {

        if (strlen($ville) < 10) {

            // test si ville unique
            $villeExiste = FALSE;
            while ($listeVilles = $qVilles->fetch())
            {
                if ($ville == $listeVilles['ville']) {
                    $villeExiste = TRUE;
                }
            }

            $tab = array(
                ':ville' => $ville,
                ':haut' => $haut,
                ':bas' => $bas
            );

            if (!$villeExiste) {
                $sql = "INSERT INTO `Météo` (`ville`, `haut`, `bas`) VALUES (:ville, :haut, :bas)";
                $req = $bdd->prepare($sql);
                $result = $req->execute($tab);
                $formMessage = '<span class="congrats">La ville de  <span class="neutral">' . $ville . '</span> a été rajoutée.</span>';
            } else {
                $sql = "UPDATE `Météo` SET `haut`=:haut, `bas`=:bas WHERE ville=:ville";
                $req = $bdd->prepare($sql);
                $result = $req->execute($tab);
                $formMessage = '<span class="congrats">Les données de <span class="neutral">' . $ville . '</span> ont été modifiées.</span>';
            }

        } else {
            $formMessage = '<span class="warning">Veillez abréger le nom de la ville (max 9 caractères).</span>';
        }

    } else {
        $formMessage = '<span class="warning">Veillez remplir toutes les données.</span>';
    }
}

// si destroy confirmé
if (isset($_POST["destroy"])) {

    while ($listeVilles = $qVilles->fetch())
    {
        if (isset($listeVilles['ville'])) {
            $thisTown = $listeVilles['ville'];
            $thisTownID = str_replace(' ','_',$thisTown);
        } else {
            $thisTown = '';
            $thisTownID = '';
        }
        if (isset($_POST[$thisTownID]) && $thisTown == $_POST[$thisTownID]) {
            // echo $thisTown;
            $tab = array(
                ':ville' => $thisTown
            );
            $sql = "DELETE FROM `Météo` WHERE ville=:ville";
            $req = $bdd->prepare($sql);
            $result = $req->execute($tab);
            $formMessage = $formMessage . '<span class="congrats">La ville de <span class="neutral">' . $thisTown . '</span> a été supprimée.</span><br>';
        }
    }
}

$resultat = $bdd->query('SELECT * FROM Météo');
$donnees = $resultat->fetch();
$myTable = '';
while ($donnees = $resultat->fetch())
{
    $town = $donnees['ville'];
    $townID = str_replace(' ','_',$town);
    $myTable = $myTable . '<tr>';
    $myTable = $myTable . '<td class="check"><input onclick="toggleCheck()" type="checkbox" id="' . $townID .'" name="' . $town .'" value="' . $town . '"></td>';
    $myTable = $myTable . '<td class="bibi">' . $town . '</td>';
    $myTable = $myTable . '<td class="bibi">' . $donnees['haut'] . '</td>';
    $myTable = $myTable . '<td class="bibi">' . $donnees['bas'] . '</td>';
    $myTable = $myTable . '</tr>';
}
// fermeture de la connection à la bdd
if ($bdd) {
    $bdd = NULL;
}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="pdo.css">
    <title>PDO Test</title>
</head>
<body>
    <form class="" action="pdo.php" method="post" id="townAddForm">
        <input type="text" name="ville" value="<?= $ville ?>" placeholder="Ville">
        <input type="text" name="haut" value="<?= $haut ?>" placeholder="Haut">
        <input type="text" name="bas" value="<?= $bas ?>" placeholder="Bas">
        <input type="submit" name="submit" value="Ajouter">
    </form>
    <p><?= $formMessage ?></p>

    <form class="" action="pdo.php" method="post" id="townListForm">
        <table>
            <tr>
                <td></td>
                <td class="bibi titre">Ville</td>
                <td class="bibi titre">Haut</td>
                <td class="bibi titre">Bas</td>
            </tr>
            <?= $myTable; ?>
            <tr>
                <td></td>
                <td id="recCheck"></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </form>

    <script type="text/javascript">
    function toggleCheck() {
        var recCheck = document.getElementById("recCheck");
        recCheck.innerHTML = '<input type="submit" name="destroy" value="Enlever">';
    }
    </script>

</body>
</html>
