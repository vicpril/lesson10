<!DOCTYPE HTML>

<HTML>
    <HEAD>
        <TITLE>{$title}</TITLE>
    </HEAD>
    <BODY>
        <form  method="post" accept-charset="utf-8" action="{$action}">
            <DIV>
                <label><b>Server name:</b></label>
                <BR>
                <input type="text" maxlength="40" value="localhost" name="server_name">
            </DIV>
            <DIV>
                <label><b>User name:</b></label>
                <BR>
                <input type="text" maxlength="40" value="test" name="user_name">
            </DIV>
            <DIV>
                <label><b>Password:</b></label>
                <BR>
                <input type="text" maxlength="40" value="123" name="password">
            </DIV>
            <DIV>
                <label><b>Database:</b></label>
                <BR>
                <input type="text" maxlength="40" value="test" name="database_name">
            </DIV>
            <DIV>
                <input type="submit" name="button_install" value="{$title}">
            </DIV>
        </form>
    </BODY>
</HTML>