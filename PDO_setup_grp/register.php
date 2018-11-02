<?php include('server.php') ?>
<div class="header">
	<h2>Register</h2>
</div>
<form method="post" action="register.php">
	<?php include('errors.php'); ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php $username; ?>">
	</div>
	<div class="input-group">
		<label>Name</label>
		<input type="text" name="name" value="<?php $name; ?>">
	</div>
	<div class="input-group">
		<label>Surname</label>
		<input type="text" name="surname" value="<?php $surname; ?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="text" name="email" type=“email” value="<?php $email; ?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" onchange=”this.setCustomValidity(this.validity.patternMismatch ? ‘Must have at least 4 characters’ : ”); if(this.checkValidity()) form.password_two.pattern = this.value;” name="password_1">
	</div>
	<div class="input-group">
		<label>Confirm Password</label>
		<input type="password" name="password_2">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="reg_user">Register</button>
	</div>
	<p>
		Already a member? <a href="index.php?login='1'">Sign in</a>
	</p>
</form>
