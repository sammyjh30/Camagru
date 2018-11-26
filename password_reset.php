<?php
    include('server.php');
    $_SESSION['token'] = trim($_GET['token']);
?>
<div>
    <div class="header">
        <h2>Password reset</h2>
    </div>
    <?php if (isset($_SESSION['error'])) : ?>
			<div class="error success" >
				<h3><?php
					echo $_SESSION['error'];
					unset($_SESSION['error']);
				?></h3>
			</div>
    <?php endif ?>
    <form method="post" action="index.php?password_reset='1'">
    </div>
        <div class="input-group">
            <label>Password</label>
		    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" name="password_reset" class="btn" style="font-size:90%; padding:1%;">Set new password</button>
        </div>
    </form>
</div>