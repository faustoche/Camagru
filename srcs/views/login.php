<div class="form-container">

	<h2 class="section-title">Login</h2>

	<form action="/login" method="GET">

		<div class="form-group">
			<label for="email-input">Email</label>

			<?php
			if (isset($tab['invalid-email']))
				echo "<p " . "style='color:red;'>" . $tab['invalid-email'] . "</p>";
			?>
			<input type="email" placeholder="faufaudu49@gmail.com" id="email-input" name="email" required />
		</div>

		<div class="form-group">
			<label for="password-input">Password</label>

			<?php
			if (isset($tab['invalid-password']))
				echo "<p " . "style='color:red;'>" . $tab['invalid-password'] . "</p>";	
			?>
			<input type="password" placeholder="*******" id="password-input" name="password" required />
		</div>

		<button type="submit" id="register-button" class="button full-width">Login</button>

	</form>

	<p>Forgot password?</p>


	<form action="/forgot" method="POST">
		<div class="form-group" style="display:none;">
			<label for="email-input">Email</label>

			<?php
			if (isset($tab['invalid-email']))
				echo "<p " . "style='color:red;'>" . $tab['invalid-email'] . "</p>";
			?>
			<input type="email" placeholder="faufaudu49@gmail.com" id="email-input" name="email" required />
		</div>


	</form>
</div>