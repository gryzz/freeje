<table border="1">
<tr>
    <td>
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
        <br>
        <a href="<?=WWW_ROOT;?>/?section=registration">Registration</a>
        <?else:?>
        Hello User!
        <?endif;?>
    </td>
    <td>
        <?if ($activationMessage):?>
            <?=$activationMessage;?>
        <?endif;?>
        <?=$content;?>
    </td>
</tr>