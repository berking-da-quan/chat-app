<?php
try {
	$db = new PDO('mysql:host=localhost;dbname=my_database', 'root', '');
}
catch(Exception $e) {
	die('erreur '.$e->getMessage());
}


if(!empty($_POST['message'])) {

	$check = $db->prepare('SELECT * FROM minichat WHERE pseudo= :pseudo AND message= :message');
	$check->execute(array(
		'pseudo'=> $_POST['pseudo'],
		'message'=> $_POST['message']
	));

	if ($check) {

		$query = $db->prepare('INSERT INTO minichat VALUES(:id, :pseudo, :message)');
		$query->execute(array(
			'id' => 0,
			'pseudo' => $_POST['pseudo'],
			'message' => $_POST['message']
		));
	}
}

$resp = $db->query('SELECT * FROM minichat ORDER BY id DESC LIMIT 0, 10');
?>

<!DOCTYPE html>
	<head>
		<title>Mini Chat in PHP | coded by berking</title>
		<link rel="stylesheet" href="main.css">
		<meta charset="utf-8">
	</head>
	<body>
		<div class="container">
			<h1>Welcome on bk chat</h1>
			<h3>typin your name and message...</h3>
			<div class="form">
				<form action="minichat.php" method="post">
					<p class="form-p">Pseudo<input type="text" name="pseudo"></p>
					<p class="form-p">message<input type="text" name="message"></p>
					<input type="submit" value="send" class="btn">
				</form>
				<h2>Last 10 message...</h1>
				<?php while($data = $resp->fetch()) {?>
				    <div class="msg">
						<div class="msg-box">
							<p class="auteur">pseudo: <?php echo $data['pseudo']?></p>
							<p class="message">msg: <?php echo $data['message']?></p>
						</div>
					</div>
					<?php
				}
				
				?>
				<div class="copy">
					<p>copyright berking, Inc 2020
				</div>
			</div>
	</body>
</html>
