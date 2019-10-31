<style>
.item_menu
{
	width:100%;
	font-weight:bold;
	padding:14px;
	border-radius:5px;
}

.titulo
{
	font-weight:bold;
	font-size:20px;
	text-align:center;
	text-decoration: underline;
	padding: 20px 0px 20px 0px;
}

.link_editar { cursor:pointer; }
.link_excluir { cursor:pointer; }
</style>
<?php
	$itens = array();
	$item = array("1","areaPrivada.php","Usuários"); array_push($itens,$item);
	$item = array("2","areaPrivada.php","Estados (UF)"); array_push($itens,$item);
	$item = array("3","areaPrivada.php","Link 3"); array_push($itens,$item);
	$item = array("4","areaPrivada.php","Link 4"); array_push($itens,$item);
	$item = array("5","areaPrivada.php","Link 5"); array_push($itens,$item);
	$item = array("6","areaPrivada.php","Link 6"); array_push($itens,$item);
	$item = array("7","areaPrivada.php","Link 7"); array_push($itens,$item);
	$item = array("8","areaPrivada.php","Link 8"); array_push($itens,$item);
	$item = array("9","areaPrivada.php","Link 9"); array_push($itens,$item);
	$item = array("10","areaPrivada.php","Link 10"); array_push($itens,$item);
	
	$itens_menu = "";
	for ($i = 0; $i < count($itens); $i++) 
	{
		$item = $itens[$i];
		$itens_menu .= "<div class='col-md-1' style='padding-top:3px;text-align:center;'>";
		$itens_menu .= "<a href='javascript:RedirecionamentoTela(".$item[0].", 1);' class='item_menu' style='color:white;' id='lnk".$item[0]."'>".$item[2]."</a>";
		$itens_menu .= "</div>";
	}
	
	$titulo = "CRUD de Usuários";
?>
<div class="menu" style="height:50px;background-color:black;padding:10px;margin-bottom:20px;border-radius:10px;">
	<div class="row">
		<?=$itens_menu?>
		<div class="col-md-1" style="padding-top:3px;text-align:center;"></div>
		<div class="col-md-1" style="padding-top:3px;text-align:right;"><a href="sair.php" class="item_menu" style="color:white;background-color:black;">Sair</a></div>
	</div>
</div>