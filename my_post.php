<?php
if ($HTTP_POST_VARS['action'] == 'submitted') {
    print '<pre>';

    print_r($HTTP_POST_VARS);
    print_r($HTTP_GET_VARS);
    print '<a href="'. $HTTP_SERVER_VARS['PHP_SELF'] .'">Please try again</a>';

    print '</pre>';
} else {
?>
<form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post">
    Name:  <input type="text" name="personal[name]"><br>
    Email: <input type="text" name="personal[email]"><br>
    Beer: <br>
    <select multiple name="beer[]">
        <option value="warthog">Warthog</option>
        <option value="guinness">Guinness</option>
        <option value="stuttgarter">Stuttgarter Schwabenbräu</option>
        <option value="qianzhongjie">qianzhongjie</option>
	<option value="wenshuna">wenshuna</option>
    </select><br>
    <input type="hidden" name="action" value="submitted">
    <input type="submit" name="submit" value="submit me!">
</form>
<?php
}
?>
