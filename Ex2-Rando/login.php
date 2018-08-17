<?php
$teou = 'Login';
$formMessage = '';

// On définit un login et un mot de passe de base pour tester notre exemple. Cependant, vous pouvez très bien interroger votre base de données afin de savoir si le visiteur qui se connecte est bien membre de votre site
$login_valide = "moi";
$pwd_valide = "lemien";

// on teste si nos variables sont définies
if (isset($_POST['login']) && isset($_POST['pwd'])) {

	// on vérifie les informations du formulaire, à savoir si le pseudo saisi est bien un pseudo autorisé, de même pour le mot de passe
	if ($login_valide == $_POST['login'] && $pwd_valide == $_POST['pwd']) {

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
    <p><?php include('_navig.php'); ?></p>

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
