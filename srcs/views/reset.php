<div class="form-wrapper">
	<div class="form-card">

		<h1>New password</h1>
		<p class="subtitle">Choose a new password for your account.</p>

		<form action="/reset" method="POST">
			<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::generateCsrfToken()) ?>">

			<input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

			<div class="form-group">
				<label for="password-input">New password</label>
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

			<div class="form-group">
				<label for="confirm-input">Confirm password</label>
				<?php if (isset($tab['password-mismatch'])): ?>
					<span class="form-error"><?= $tab['password-mismatch'] ?></span>
				<?php endif; ?>
				<input
					type="password"
					id="confirm-input"
					name="password_confirm"
					placeholder="Repeat your password"
					required
				/>
			</div>

			<button type="submit" class="btn btn-primary btn-full">Reset password</button>

		</form>

		<div class="form-footer">
			Remembered it? <a href="/login">Back to login</a>
		</div>

	</div>
</div>