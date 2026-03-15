<div class="form-wrapper">
	<div class="form-card">

		<h1>Register</h1>
		<p class="subtitle">Create your account and start sharing.</p>

		<form action="/register" method="POST">
			<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::generateCsrfToken()) ?>">

			<div class="form-group">
				<label for="alias-input">Username</label>
				<?php if (isset($tab['username-taken'])): ?>
					<span class="form-error"><?= $tab['username-taken'] ?></span>
				<?php elseif (isset($tab['username-required'])): ?>
					<span class="form-error"><?= $tab['username-required'] ?></span>
				<?php endif; ?>
				<input
					type="text"
					id="alias-input"
					name="username"
					placeholder="faufaudu49"
					value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
					required
				/>
			</div>

			<div class="form-group">
				<label for="email-input">Email</label>
				<?php if (isset($tab['invalid-email'])): ?>
					<span class="form-error"><?= $tab['invalid-email'] ?></span>
				<?php elseif (isset($tab['email-taken'])): ?>
					<span class="form-error"><?= $tab['email-taken'] ?></span>
				<?php elseif (isset($tab['email-required'])): ?>
					<span class="form-error"><?= $tab['email-required'] ?></span>
				<?php endif; ?>
				<input
					type="email"
					id="email-input"
					name="email"
					placeholder="you@example.com"
					value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
					required
				/>
			</div>

			<div class="form-group">
				<label for="password-input">Password</label>
				<?php if (isset($tab['invalid-password'])): ?>
					<span class="form-error"><?= $tab['invalid-password'] ?></span>
				<?php elseif (isset($tab['password-required'])): ?>
					<span class="form-error"><?= $tab['password-required'] ?></span>
				<?php endif; ?>
				<input
					type="password"
					id="password-input"
					name="password"
					placeholder="Min. 8 alphanumeric characters"
					required
				/>
			</div>

			<button type="submit" class="btn btn-primary btn-full">Create account</button>

		</form>

		<div class="form-footer">
			Already have an account? <a href="/login">Log in</a>
		</div>

	</div>
</div>