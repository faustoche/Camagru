<div class="form-wrapper">
	<div class="form-card">

		<h1 style="text-align: center; padding-bottom: 20px;">My profile</h1>

		<form action="/profile" method="POST">
			<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::generateCsrfToken()) ?>">

			<div class="form-group">
				<label for="username-input">Username</label>
				<input
					type="text"
					id="alias-input"
					name="username"
					placeholder="faufaudu49"
					value="<?= htmlspecialchars($fetchData['username'] ?? '') ?>"
					disabled
				/>
			</div>

			<div class="form-group">
				<label for="email-input">Email</label>
				<input
					type="email"
					id="email-input"
					name="email"
					placeholder="you@example.com"
					value="<?= htmlspecialchars($fetchData['email'] ?? '') ?>"
					disabled
				/>
			</div>

			<div class="form-group">
				<label for="notification-choice">Allow email notifications when receiving a new comment?</label>
				<input
				type="checkbox"
				id="email-notification"
				name="notification"
				value="1"
				<?= (isset($fetchData['email_notifications']) && $fetchData['email_notifications'] == 0) ? '' : 'checked' ?> disabled />
			</div>

			<button type="button" id="button-update">UPDATE MY INFORMATIONS</button>

		</form>

		<div class="form-divider"></div>
		<form action="/profile" method="POST">

			<div class="form-group">
				<label for="password-input">Password</label>
				<input
					type="password"
					id="password-input"
					name="password"
					placeholder="********"
					disabled
				/>
			</div>
			<div class="form-group" id="div-confirm-password" style="display:none;">
				<label for="password-input">Confirm password</label>
				<input
					type="password"
					id="password-confirm-input"
					name="password"
					placeholder="Min. 8 alphanumeric characters"
				/>
			</div>
			<button type="button" id="button-password">CHANGE MY PASSWORD</button>



		</form>
	</div>
</div>

<script>

	const username = document.getElementById('alias-input');
	const email = document.getElementById('email-input');
	const password = document.getElementById('password-input');
	const passwordConfirm = document.getElementById('div-confirm-password');
	const checkboxNotification = document.getElementById('email-notification');
	const updateButton = document.getElementById('button-update');
	const passwordButton = document.getElementById('button-password');

	updateButton.addEventListener('click', function(event) {

		if (username.disabled === true) {
			event.preventDefault();
			username.disabled = false;
			email.disabled = false;
			checkboxNotification.disabled = false;
			updateButton.innerHTML = "SAVE CHANGES";
			updateButton.setAttribute('type', 'submit');
		}
	});

	passwordButton.addEventListener('click', function(event) {
		if (password.disabled === true) {
			event.preventDefault();
			password.disabled = false;
			passwordConfirm.style.display = 'block';
	
			passwordButton.innerHTML = "SAVE PASSWORD";
			passwordButton.setAttribute('type', 'submit');

		}
	})





</script>