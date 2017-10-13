<?php include('views/header.php');?>

<?php include('views/alerts.php');?>

<p>hello world this is the overpage</p>

<form id="login-form" method="POST" action="<?php echo $baseurl; ?>">
    <input type="hidden" name="action" value="logout">
    <button type="submit" name="submit" class="btn btn-primary pull-right">Logout</button>
</form> 

<?php include('views/commonjs.php');?>

<?php include('views/ender.php');?>