<?php /* Smarty version 2.6.28, created on 2015-04-12 08:39:49
         compiled from install.tpl */ ?>
<!DOCTYPE HTML>

<HTML>
    <HEAD>
        <TITLE>Install database</TITLE>
    </HEAD>
    <BODY>
        <form  method="post" accept-charset="utf-8" action="index.php">
            <DIV>
                <label><b><?php echo $this->_tpl_vars['message']; ?>
</b></label>
                <br>
                
                <input type="submit" name="Want_to_install_dump" value="Да" formaction="install.php">
                <input type="submit" name="Want_to_install_dump" value="Нет" formaction="index.php">
            </DIV>
        </form>
    </BODY>
</HTML>