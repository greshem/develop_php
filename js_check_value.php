<script language=javascript>
function save_subnet(subnet)
{
	if (document.all["subnet"].value == "") {
		alert("请输入服务网段");
		return;
	}
	if (document.all["mask"].value == "") {
		alert("请输入子网掩码");
		return;
	}
	if (document.all["routers"].value == "") {
		alert("请输入客户端网关地址");
		return;
	}
	if (document.all["next_server"].value == "") {
		alert("请输入启动服务器");
		return;
	}
	PostBack('SAVE_SUBNET',subnet);
}
</script>

