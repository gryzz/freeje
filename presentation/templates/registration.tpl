<table border="1">
<form method="post">
<?if($registrationError):?>
    <?=$registrationError;?>
<?endif;?>
<input type="hidden" name="registration_form_posted" value="true">
<tr><td>Email</td><td><input type="input" name="email" size="20"></td></tr>
<tr><td>Phone</td><td><input type="input" name="phone" size="20"></td></tr>
<tr><td>Firstname</td><td><input type="input" name="firstname" size="20"></td></tr>
<tr><td>Lastname</td><td><input type="input" name="lastname" size="20"></td></tr>
<tr><td>Address</td><td><input type="input" name="adress" size="40"></td></tr>
<tr><td>City</td><td><input type="input" name="city" size="20"></td></tr>
<tr><td>Country</td><td><input type="input" name="country" size="20"></td></tr>
<tr><td>Postcode</td><td><input type="input" name="postcode" size="20"></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Register"></td></tr>
</form>
</table>