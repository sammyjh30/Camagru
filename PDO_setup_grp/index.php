<?php
 session_start();

    if (!isset($_SESSION['username'])) {
        $_SESSION['message'] = "You must log in first";
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
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
	if (isset($_GET['camera'])) {
        $_SESSION['window'] = "camera";
    }
?>
<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" type="text/css" href="style_v07.css">
</head>
<body>
    <?php include("header.php");?>
    <div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success" >
			<h3><?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?></h3>
        </div>
        <?php endif ?>
        <?php if (isset($_SESSION['message'])) : ?>
        <div class="error success" >
            <h3><?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?></h3>
        </div>
        <?php endif ?>
        <?php if (isset($_SESSION['error'])) : ?>
			<div class="error success" >
				<h3><?php
					echo $_SESSION['error'];
					unset($_SESSION['error']);
				?></h3>
			</div>
        <?php endif ?>
        <!-- logged in user information -->
		<?php if (isset($_SESSION['window']) && $_SESSION['window'] == "login") : ?>
			<?php unset($_SESSION['window']); ?>
			<?php include("login.php");?>
		<?php elseif (isset($_SESSION['window']) && $_SESSION['window'] == "signup") : ?>
			<?php include("register.php");?>
			<?php unset($_SESSION['window']); ?>
		<?php elseif (isset($_SESSION['window']) && $_SESSION['window'] == "profile") : ?>
			<?php include("profile.php");?>
			<?php unset($_SESSION['window']); ?>
		<?php elseif (isset($_SESSION['window']) && $_SESSION['window'] == "camera") : ?>
			<?php unset($_SESSION['window']); ?>
			<?php include("camera.php");?>		
		<?php else : ?>
			<?php  if (isset($_SESSION['username'])) : ?>
				<p><strong>Welcome!</strong></p>
				<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
			<?php else : ?>
				<div class="coverPage">
					<p><strong>Join the fun!</strong></p>
					<a class="btn" href="index.php?signup='1'">Signup</a>
					<br/><br/><br/>
					<p><strong>Already a member?</strong></p>
					<a class="btn" href="index.php?login='1'">Login</a>
				</div>
			<?php endif ?>
		<?php endif ?>
	</div>
	<br/>
	<br/>
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