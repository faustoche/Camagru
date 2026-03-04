<!DOCTYPE html>
<html lang=en>
	<head>

		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		<title>📸 Camagru</title>
		<link rel="stylesheet" href="/css/styles.css">
	</head>

	<body>
		
		<!-- Header on the page //  -->
		<!-- //TODO: changer les boutons de register/login -->
		<header class="main-header">
			<div class="logo">★ CAMAGRU ★</div>

			<nav>
				<button class="button">Login</button>
				<button class="button">Register</button>
			</nav>
		</header>

		<my-marquee scrollamount="10"> Create, post, like and comment</my-marquee>

		<main class="container">
			<?php echo $content ?? ''; ?>
		</main>

	</body>

	<footer>

	</footer>
</html>