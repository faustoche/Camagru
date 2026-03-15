<div class="form-wrapper">
	<div class="form-card">

		<h1>Login</h1>
		<p class="subtitle">Welcome back.</p>

		<form action="/login" method="POST">
			<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::generateCsrfToken()) ?>">

			<div class="form-group">
				<label for="email-input">Email</label>
				<?php if (isset($tab['invalid-email'])): ?>
					<span class="form-error"><?= $tab['invalid-email'] ?></span>
				<?php endif; ?>
				<?php if (isset($tab['not-confirmed'])): ?>
					<span class="form-error"><?= $tab['not-confirmed'] ?></span>
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
				<?php endif; ?>
				<input
					type="password"
					id="password-input"
					name="password"
					placeholder="••••••••"
					required
				/>
			</div>

			<button type="submit" class="btn btn-primary btn-full">Log in</button>

		</form>

		<div class="form-divider">or</div>

		<details style="text-align: center; margin-bottom: 1.5rem;">
			<summary style="font-size:0.82rem; color:var(--muted); cursor: pointer; list-style: none; outline: none;">
				Forgot your password?
			</summary>
			
			<form action="/forgot-password" method="POST" style="text-align: left; margin-top: 1rem;">
				<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::generateCsrfToken()) ?>">
				<div class="form-group">
					<label for="forgot-email">Email address</label>
					<input type="email" id="forgot-email" name="email" placeholder="you@example.com" required />
				</div>
				<button type="submit" class="btn btn-ghost btn-full">Send reset link</button>
			</form>
		</details>

		<div class="form-footer">
			No account yet? <a href="/register">Register</a>
		</div>

	</div>
</div>