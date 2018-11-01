<div class="pageHeader">
	<a href="#default" class="logo">
		<img src="../img/logo_white.png" alt="logo" style="width:auto; height:40px; padding-bottom:10px;">
	</a>
	<div class="header-right">
	<?php if (isset($_SESSION['username'])) : ?>
		<a href="index.php?profile='1'"><strong><?php echo $_SESSION['username']; ?></strong></a>
		<a href="index.php?logout='1'">Logout</a>
	<?php else : ?>
		<a href="index.php?login='1'">Login</a>
		<a href="index.php?signup='1'">Signup</a>
	<?php endif ?>
	</div>
</div>