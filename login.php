<?php include('server.php') ?>
<div class="header">
	<h2>Login</h2>
</div>
<form method="post" action="index.php?login='1'">
	<?php include('errors.php'); ?>
	<?php if (isset($_SESSION['message'])) : ?>
        <div class="error success" >
            <h3><?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?></h3>
        </div>
        <?php endif ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" >
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="login_user" style="font-size:90%; padding:1%;">Login</button>
	</div>
	<p>
		<a href="index.php?forgot='1'">Forgot your password?</a>
	</p>
	<p>
		Not yet a member? <a href="index.php?signup='1'">Sign up</a>
	</p>
</form>