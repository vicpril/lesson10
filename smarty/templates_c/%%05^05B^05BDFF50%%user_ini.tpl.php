<?php /* Smarty version 2.6.28, created on 2015-04-14 18:06:19
         compiled from user_ini.tpl */ ?>
<!DOCTYPE HTML>

<HTML>
    <HEAD>
        <TITLE><?php echo $this->_tpl_vars['title']; ?>
</TITLE>
    </HEAD>
    <BODY>
        <?php echo $this->_tpl_vars['message']; ?>

        <br>
        <form  method="post" accept-charset="utf-8" action="<?php echo $this->_tpl_vars['action']; ?>
">
            <DIV>
                <label><b>Server name:</b></label>
                <BR>
                <input type="text" maxlength="40" value="localhost" name="server_name">
            </DIV>
            <DIV>
                <label><b>User name:</b></label>
                <BR>
                <input type="text" maxlength="40" value="" name="user_name">
            </DIV>
            <DIV>
                <label><b>Password:</b></label>
                <BR>
                <input type="text" maxlength="40" value="" name="password">
            </DIV>
            <DIV>
                <label><b>Database:</b></label>
                <BR>
                <input type="text" maxlength="40" value="" name="database_name">
            </DIV>
            <DIV>
                <input type="submit" name="button_install" value="<?php echo $this->_tpl_vars['title']; ?>
">
            </DIV>
        </form>
    </BODY>
</HTML>