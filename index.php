<?php
require_once __DIR__ . '/includes/php/bootstrap.php';
$pageSlug = jr_page_slug();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>JR Marketing (Pvt) Ltd — Login</title>
	<link rel="icon" type="image/png" href="assets/images/logo.png">
	<link rel="stylesheet" href="assets/css/variables.css">
	<link rel="stylesheet" href="assets/css/base.css">
	<link rel="stylesheet" href="assets/css/components.css">
	<link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
	<main class="login-page">

		<?php include __DIR__ . '/components/login-logo.php'; ?>

		<div class="login-card">
			<?php include __DIR__ . '/components/login-form.php'; ?>
		</div>

		<?php include __DIR__ . '/components/login-footer.php'; ?>

	</main>

	<script src="assets/js/utils.js"></script>
	<script src="assets/js/toast.js"></script>
	<script src="assets/js/auth.js"></script>
	<script src="assets/js/login.js"></script>
</body>
</html>
