<script language=javascript>
function save_subnet(subnet)
{
	if (document.all["subnet"].value == "") {
		alert("�������������");
		return;
	}
	if (document.all["mask"].value == "") {
		alert("��������������");
		return;
	}
	if (document.all["routers"].value == "") {
		alert("������ͻ������ص�ַ");
		return;
	}
	if (document.all["next_server"].value == "") {
		alert("����������������");
		return;
	}
	PostBack('SAVE_SUBNET',subnet);
}
</script>

