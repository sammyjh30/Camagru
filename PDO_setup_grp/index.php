<?php 
  session_start(); 

	if (!isset($_SESSION['username'])) {
		$_SESSION['message'] = "You must log in first";
		// header('location: login.php');
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		// header("location: login.php");
	}
	if (isset($_GET['login'])) {
		$_SESSION['window'] = "login";
	}
	if (isset($_GET['signup'])) {
		$_SESSION['window'] = "signup";
	}
	if (isset($_GET['profile'])) {
		$_SESSION['window'] = "profile";
	}
?>
<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="style_v01.css">
</head>
<body>
	<?php include("header.php");?>
	<!-- <div class="header">
		<h2>Home Page</h2>
	</div> -->
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
		<div class="error success" >
			<h3>
			<?php 
				echo $_SESSION['success']; 
				unset($_SESSION['success']);
			?>
			</h3>
		</div>
		<?php endif ?>

		<!-- notification message -->
		<?php if (isset($_SESSION['message'])) : ?>
		<div class="error success" >
			<h3>
			<?php 
				echo $_SESSION['message']; 
				unset($_SESSION['message']);
			?>
			</h3>
		</div>
		<?php endif ?>
		<!-- notification message -->
		<?php if (isset($_SESSION['error'])) : ?>
		<div class="error success" >
			<h3>
			<?php 
				echo $_SESSION['error']; 
				unset($_SESSION['error']);
			?>
			</h3>
		</div>
			<?php endif ?>
			<!-- logged in user information -->
			<?php if (isset($_SESSION['window']) && $_SESSION['window'] == "login") : ?>
				<?php include("login.php");?>
				<?php unset($_SESSION['window']); ?>
			<?php elseif (isset($_SESSION['window']) && $_SESSION['window'] == "signup") : ?>
				<?php include("signup.php");?>
				<?php unset($_SESSION['window']); ?>
			<?php elseif (isset($_SESSION['window']) && $_SESSION['window'] == "profile") : ?>
				<?php include("profile.php");?>
				<?php unset($_SESSION['window']); ?>
			<?php else : ?>

				<?php  if (isset($_SESSION['username'])) : ?>
					<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
					<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
				<?php endif ?>

			<?php endif ?>
	</div>
	<!--  -->
	<!-- Modal content -->
	<!-- <div class="modal-content">
		<div class="modal-header">
			<span class="close">&times;</span>
			<h2>Modal Header</h2>
		</div>
		<div class="modal-body">
			<p>Some text in the Modal Body</p>
			<p>Some other text...</p>
		</div>
		<div class="modal-footer">
			<h3>Modal Footer</h3>
		</div>
	</div> -->
	<!--  -->
	<?php include("footer.php");?>

</body>
</html>