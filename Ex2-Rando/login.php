<?php
$teou = 'Login';
$formMessage = '';
$log = FALSE;

// on teste si nos variables sont définies
if (isset($_POST['login']) && isset($_POST['pwd'])) {

    $servername = "localhost";
    $username = "root";
    $password = "zen8070\$mysql";
    $myDB = "reunion_island";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$myDB;charset=utf8", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
        $stmt = $conn->prepare("SELECT * FROM customers");
        $stmt->execute();
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $myTable = '';
        foreach($stmt->fetchAll() as $k=>$v) {
            if ($v['login'] == $_POST['login'] && $v['pwd'] == sha1($_POST['pwd'])) {
                $log = TRUE;
            }
        }
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

	// on vérifie les informations du formulaire, à savoir si le pseudo saisi est bien un pseudo autorisé, de même pour le mot de passe
	if ($log) {

		session_start ();
		$_SESSION['login'] = $_POST['login'];
		$_SESSION['pwd'] = $_POST['pwd'];

		// on redirige notre visiteur vers une page de notre section membre
		header ('location: read.php');
	}
	else {
		// Le visiteur n'a pas été reconnu comme étant membre de notre site. On utilise alors un petit javascript lui signalant ce fait
        $formMessage = "Nom d'utilisateur ou mot de passe non valide";
        session_start ();
        session_unset ();
        session_destroy ();
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Randonnées : Login</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <?php include('_navig.php'); ?>

    <h1>Login</h1>
    <form action="" method="post">
        <div>
            <label for="login">Nom d'utilisateur</label>
            <input type="text" name="login" value="">
        </div>
        <div>
            <label for="pwd">Mot de passe</label>
            <input type="password" name="pwd" value="">
        </div>
        <label for="button">&nbsp;</label>
        <button type="submit" name="button">Login</button>
    </form>
    <p><?= $formMessage ?></p>
</body>
</html>
