<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
	require('config.php');

	if (isset($_REQUEST['id'],$_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'])){
		// récupérer l'eidet supprimer les antislashes ajoutés par le formulaire
		$id = stripslashes($_REQUEST['id']);
		$id = mysqli_real_escape_string($conn, $id);

		$query =  "SELECT * FROM `users` WHERE id='$id'";
		$result = mysqli_query($conn, $query);
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			echo "<div class='sucess'>
			<h3>L'ID saisie existe déjà.</h3>
			<p>Merci de retaper un autre ID <a href='register.php'>connecter</a></p>
			</div>";
			exit;
		}

		// récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire
		$username = stripslashes($_REQUEST['username']);
		$username = mysqli_real_escape_string($conn, $username); 
		// récupérer l'email et supprimer les antislashes ajoutés par le formulaire
		$email = stripslashes($_REQUEST['email']);
		$email = mysqli_real_escape_string($conn, $email);
					//"SELECT *     FROM $lettre 		WHERE sorted_letters = '$sorted';";
		//$sqlSelect = "SELECT * FROM user WHERE username = $username";
		$query =  "SELECT * FROM `users` WHERE email='$email'";
		$result = mysqli_query($conn, $query);
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			echo "<div class='sucess'>
			<h3>L'émail saisie existe déjà.</h3>
			<p>Merci de ratapper un autre Mail <a href='register.php'>connecter</a></p>
			</div>";
			exit;
		}
		// récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($conn, $password);
		//requéte SQL + mot de passe crypté
		$query = "INSERT into `users` (id, username, email, password)
				VALUES ('$id', '$username', '$email', '".hash('sha256', $password)."')";
		// Exécute la requête sur la base de données
		$res = mysqli_query($conn, $query);
		if($res){
		echo "<div class='sucess'>
				<h3>Vous êtes inscrit avec succès.</h3>
				<p>Cliquez ici pour vous <a href='login.php'>connecter</a></p>
				</div>";
		}
	}else{
?>
		<form class="box" action="" method="post">
			<h1 class="box-logo box-title"><a href="http://localhost/login.php">BienVenu au Site EPSI</a></h1>
			<h1 class="box-title">S'inscrire</h1>
			<input type="number" class="box-input" name="id" placeholder="Votre identifiant" required />
			<input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur" required />
			<input type="email" class="box-input" name="email" placeholder="Email" required />
			<input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
			<input type="submit" name="submit" value="S'inscrire" class="box-button" />
			<p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
		</form>
<?php 
	} 
?>
</body>
</html>