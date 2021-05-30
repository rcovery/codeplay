<?php
	session_start();
	require_once(dirname(__FILE__) . "/../Controller/Post.php");
	require_once(dirname(__FILE__) . "/message.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Codeplay :: Post</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/navbar.css">
</head>
<body>
	<?php include("navbar.php"); ?>

	<?php
		if (!isset($_GET["id"])) {
			(new View("Ocorreu um erro!"))->warning();
		} else {
			(new Post())->view($_GET["id"]);
		}
	?>

	<script src="../assets/js/script.js"></script>
</body>
</html>