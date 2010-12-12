<?if (!$isLogined):?>
<?if ($error):?>
<?=$error;?><br>
<?endif;?>
<form name="loginForm" method="post">
<input type="hidden" name="form_posted" value="true">
login: <input type="text" name="email"><br />
password: <input type="password" name="password"><br />
<input type="submit" name="post" value="login">
</form>
<?else:?>
Hello User!
<?endif;?>