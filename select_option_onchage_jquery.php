<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="form.js"></script>
<script type="text/javascript" src="sorter.js"></script>
<script type="text/javascript" src="editor.js"></script>
<script type="text/javascript" src="thickbox.js"></script>
<script type="text/javascript" src="validate.js"></script>
<script type="text/javascript" src="table.js"></script>
<script type="text/javascript">
$().ready(function() {
	$('#orderForm select').change(function() {
		$('#orderForm')[0].submit();
	});
});
</script>
