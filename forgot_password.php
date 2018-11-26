<?php include('server.php') ?>
<div>
    <div class="header">
        <h2>Password recovery</h2>
    </div>
    <form method="post" action="forgot_password.php">
        <div class="input-group">
            <label>Email address</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <button type="submit" name="forgot_password" class="btn" style="font-size:90%; padding:1%;">Send reset</button>
        </div>
    </form>
</div>