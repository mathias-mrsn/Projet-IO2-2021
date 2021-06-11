<?
if (isset($_POST['darkmode-off']) || isset($_POST['darkmode-on'])) {
	if (isset($_POST['darkmode-off'])) {
		unset($_SESSION['darkmode']);
	} else if (isset($_POST['darkmode-on'])) {
		$_SESSION['darkmode'] = "activated";
	}
} ?>

<html>

<body>
	<form method="post">
		<? if (isset($_SESSION['darkmode'])) { ?>
			<button class="darkmode" name="darkmode-off">DarkMode : On</button>
		<? } else { ?>
			<button class="darkmode" name="darkmode-on">DarkMode : Off</button>
		<? } ?>
</body>

</html>

<?
if (isset($_POST['darkmode-off']) || isset($_POST['darkmode-on'])) {
	if (isset($_POST['darkmode-off'])) {
		unset($_SESSION['darkmode']);
	} else if (isset($_POST['darkmode-on'])) {
		$_SESSION['darkmode'] = "activated";
	}
} ?>

<head>
	<? if (isset($_SESSION['darkmode'])) { ?>
		<link rel="stylesheet" href="CSS/style-dark-mode.css">
	<? } else { ?>
		<link rel="stylesheet" href="CSS/style.css">
	<? } ?>
</head>