<div class="form-container">

	<h2 class="section-title">Register</h2>

	<form action="/register" method="POST">

		<div class="form-group">
			<label for="alias-input">Username</label>
			<input type="text" placeholder="faufaudu49" id="alias-input" name="username" required />
		</div>

		<div class="form-group">
			<label for="email-input">Email</label>
			<input type="email" placeholder="faufaudu49@gmail.com" id="email-input" name="email" required />
		</div>

		<div class="form-group">
			<label for="password-input">Password</label>
			<input type="password" placeholder="*******" id="password-input" name="password" required />
		</div>

		<button type="submit" id="register-button" class="button full-width">Register</button>

	</form>
</div>