<?php include('server.php') ?>
<div>
    <form method="post" action="settings.php">
    <!-- <form method="post" action="index.php?settings='1'"> -->
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Change Username</label>
            <input type="text" name="username" value="<?php $username; ?>">
        </div>
        <div class="input-group">
            <label>Change Name</label>
            <input type="text" name="name" value="<?php $name; ?>">
        </div>
        <div class="input-group">
            <label>Change Surname</label>
            <input type="text" name="surname" value="<?php $surname; ?>">
        </div>
        <div class="input-group">
            <label>Change Email</label>
            <input type="text" name="email" type=“email” value="<?php $email; ?>">
        </div>
        <div class="input-group">
            <label>Change Password</label>
            <input type="password" onchange=”this.setCustomValidity(this.validity.patternMismatch ? ‘Must have at least 4 characters’ : ”); if(this.checkValidity()) form.password_two.pattern = this.value;” name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_2">
        </div>
        <div>
            <label>Receive Email Notifications for Comments</label>
            <?php
                $sql = "SELECT notify FROM camagru_db.users WHERE username='".$_SESSION['username']."'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetch();
            ?>
             <?php if ($results['notify'] == "Y") : ?>
                <label class="switch">
                    <input type="checkbox" checked="true" name="notify" class="checkbox">
                    <span class="slider round"></span>
                </label>
            <?php else : ?>
                <label class="switch">
                    <input type="checkbox" checked="" name="notify" class="checkbox">
                    <span class="slider round"></span>
                </label>
            <?php endif ?>
            <!-- <label class="switch">
                <input type="checkbox" checked="true" name="notify" class="checkbox">
                <span class="slider round"></span>
            </label> -->
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="change_settings" style="font-size:90%; padding:1%;">Save Changes</button>
        </div>
    </form>
</div>
