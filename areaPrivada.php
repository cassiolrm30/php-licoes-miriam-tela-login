<?php
	require_once 'CLASSES/usuarios.php';
	session_start();
	if (!isset($_SESSION['ID']))
	{
		header("location: index.php");
		exit;
	}
?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Projeto Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<div style="padding:10px;">
	<?php include 'menu.php'; ?>
	<div class="titulo"></div>
	<div class="container" style="height:83%;">
		<?php include 'principal.php'; ?>
		<input type="hidden" id="hidCodMenu1" name="hidCodMenu1">
	</div>
</div>
<script>
function RedirecionamentoTela(opcao, pagina)
{
	var ordenacao = "1";
	var nomesPaginas = [];
	var nomeTela = "";
	var titulo = "CRUD de ";
	var qtdLinhas = parseInt($("#hidQtdLinhas").val());
	
	var i = 1;
	$("a").filter(".item_menu").each(function()
	{
		if ($(this).prop("innerText") != "Sair")
		{
			nomeTela = $(this).prop("innerText");
			nomesPaginas.push(nomeTela);
			if (i == opcao)
				titulo += nomeTela;
		}
		i++;
	});
	$("div [class='titulo']").prop("innerText", titulo);
	Listagem(pagina, qtdLinhas);
	Paginacao(pagina, ($("#hidQtdPaginas").val() == "") ? "1" : $("#hidQtdPaginas").val());
}

function Listagem(pPagina, pQtdLinhas)
{
  	$("#tabela").find("thead tr").remove();
  	$("#tabela").find("tbody tr").remove();  
	
	var tabela    = document.getElementById("tabela");
	var cabecalho = tabela.createTHead();
	var row       = cabecalho.insertRow(0); row.style = "border: 1px solid black";
	var celula, outraCelula;
	var titulo, titulos = [];
	titulo = {nome:"Nome",     largura:"40", alinhamento:"left"};   titulos.push(titulo);
	titulo = {nome:"Telefone", largura:"20", alinhamento:"center"}; titulos.push(titulo);
	titulo = {nome:"E-mail",   largura:"30", alinhamento:"left"}; 	 titulos.push(titulo);
	titulo = {nome:"Ações",    largura:"10", alinhamento:"center"}; titulos.push(titulo);
	for (var i = 0; i < titulos.length; i++)
	{
		var item = titulos[i];
		celula       = row.insertCell(i); row.style = "border:1px solid black";
		celula.id    = "th" + (i+1);
		celula.class = "text-center";
		celula.style = "padding:2px;vertical-align:middle;height:30px;cursor:pointer;border:1px solid black;background-color:black;color:white;text-align:center;width:"+item["largura"]+"%;";
		if (i == titulos.length-1)	// Coluna "Ações"
		{
			celula.colSpan   = "2";
			celula.innerHTML = "<a href='#' style='background-color:black;color:white;font-weight:bolder;text-decoration:none;cursor:auto;'>" + item["nome"] + "</a>";
		}
		else
			celula.innerHTML = "<a href='#' style='background-color:black;color:white;font-weight:bolder;' onclick='OrdenarPorColuna("+i+");'>" + item["nome"] + "</a>";
	}
	var corpo = tabela.createTBody();
	var usuarios = [];
	var infsUsuarios = [];
	var qtdPaginas = 0;
	var URL = "processar.php";
	var parametros = { opcao: "L", pagina: pPagina, qtLinhas: pQtdLinhas };
	$.ajax({ url: URL, type: 'GET',	data: parametros, dataType: 'html', async: false })
	.done(function (retorno) 
	{
		infsUsuarios = retorno.split('||');
		usuarios = infsUsuarios[0].split('|');
		qtdPaginas = (Math.trunc(parseInt(infsUsuarios[1]) / pQtdLinhas)) + ((parseInt(infsUsuarios[1]) % pQtdLinhas) == 0 ? 0 : 1);
		console.log(qtdPaginas);
		$("#hidQtdPaginas").val(qtdPaginas);
		for (var i = 0; i < usuarios.length; i++)
		{
			row = corpo.insertRow(i);
			var item = usuarios[i].split(';');
			for (var j = 0; j < titulos.length; j++)
			{
				var estiloLinha = "text-align:" + titulos[j]["alinhamento"] + ";vertical-align:middle;padding:2px;width:";
				celula = row.insertCell(j);
				celula.innerHTML = item[j];
				if (j < titulos.length-1)
					celula.style = estiloLinha + titulos[j]["largura"] + "%;";
				else
				{
					var imgEditar = "<a href='javascript:Editar("+item[j]+");'><img class='link_editar' src='IMAGENS/editar.jpg'></a>";
					var imgExcluir = "<a href='javascript:Excluir("+item[j]+");'><img class='link_excluir' src='IMAGENS/excluir.jpg'></a>";
					celula.style = estiloLinha + (titulos[j]["largura"]/2) + "%;text-align:center;"; celula.innerHTML = imgEditar;
					outraCelula = row.insertCell(j+1); outraCelula.style = estiloLinha + (titulos[j]["largura"]/2)+"%;text-align:center;"; outraCelula.innerHTML = imgExcluir;
				}
			}
		}  
	})
	.fail(function (jqXHR, textStatus, errorThrown) { alert(jqXHR); alert(textStatus); alert(errorThrown); });
}

function OrdenarPorColuna(n)
{
	var tabela, linha, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  	tabela = document.getElementById("tabela");
  	switching = true;
    dir = "asc"; 
  	while (switching) 
    {
    	switching = false;
    	linha = tabela.rows;
    	/*Loop through all table rows (except the first, which contains table headers):*/
    	for (i = 1; i < (linha.length - 1); i++)
        {
      		shouldSwitch = false;
      		/*Get the two elements you want to compare, one from current row and one from the next:*/
      		x = linha[i].getElementsByTagName("TD")[n];
      		y = linha[i + 1].getElementsByTagName("TD")[n];
      		if (dir == "asc")
            {
        		if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) 
                {
          			shouldSwitch = true;
          			break;
        		}
      		}
            else if (dir == "desc") 
            {
        		if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) 
                {
          			shouldSwitch = true;
          			break;
        		}
      		}
    	}
    	if (shouldSwitch)
    	{
      		linha[i].parentNode.insertBefore(linha[i + 1], linha[i]);
      		switching = true;
      		switchcount++;
    	}
        else
        {
      		/*If no switching has been done AND the direction is "asc",
      		set the direction to "desc" and run the while loop again.*/
      		if (switchcount == 0 && dir == "asc") 
            {
        		dir = "desc";
        		switching = true;
      		}
    	}
  	}
}

function Paginacao(paginaCorrente, qtdPaginas)
{
	$("#listagem").show();
	$("#paginacao").show();
	$("#cadastro").hide();
	var qtdMaxPaginas = 5;
    var primeiraPagina = paginaCorrente;
	var paginas = [];
	var vPagina = "";
	if (paginaCorrente > 1)
    {
		var paginaDoMeio = (qtdPaginas - qtdMaxPaginas + 1);
		paginas.push("«");
        primeiraPagina = (qtdPaginas <= qtdMaxPaginas ? 1 : (paginaCorrente <= paginaDoMeio ? paginaCorrente : paginaDoMeio));
		console.log("primeiraPagina: " + primeiraPagina);
		console.log("paginaCorrente: " + paginaCorrente);
		console.log("paginaDoMeio: " + paginaDoMeio);
    }
    else
    {
        qtdMaxPaginas--;
    }
	for (var i = primeiraPagina; i <= qtdPaginas; i++)
		paginas.push(i);
	if (qtdPaginas <= qtdMaxPaginas)
	{
		for (var i = paginas.length; i > qtdPaginas; i--)
			paginas.pop();
	}
	else
	{
		for (var i = paginas.length; i > qtdMaxPaginas; i--)
			paginas.pop();
		if (qtdPaginas > qtdMaxPaginas && paginas[paginas.length-1] != qtdPaginas)
			paginas.push("»");
	}
	$("#paginacao > li").remove();
	console.log(paginas);
	for (var i = 0; i < paginas.length; i++)
	{
		var pagina = paginas[i];
		var item = "";
		var ativo = "";
		var cursor = "cursor:pointer;";
		if (pagina == paginaCorrente)
		{
			ativo = " active";
			cursor = "cursor:auto;";
		}
		item += "<li class='page-item"+ativo+"' style=''>";
		vPagina = (pagina == "»" ? (paginas[paginas.length-2] + 1) : (pagina == "«" ? (paginaCorrente-1): pagina));
		item += "<a class='page-link' style='padding:2px;text-align:center;width:30px;"+cursor+"' id='lnkPag"+vPagina+"' onclick='LinkPaginacao("+vPagina+");'>"+pagina+"</a>";
		item += "</li>";
		$("#paginacao").append(item);
	}
}

function LinkPaginacao(pagina)
{
	Listagem(pagina, parseInt($("#hidQtdLinhas").val()));
	Paginacao(pagina, ($("#hidQtdPaginas").val() == "") ? "1" : $("#hidQtdPaginas").val());
}

function ValidarCadastro()
{
	if ($("#txtNome").val().trim() == "") 
	{
		alert("Nome é obrigatório.");
		$("#txtNome").focus();
		return false;
	}
	if ($("#txtEmail").val().trim() == "") 
	{
		alert("E-mail é obrigatório.");
		$("#txtEmail").focus();
		return false;
	}
	if ($("#txtSenha").val().trim() == "") 
	{
		alert("Senha é obrigatório.");
		$("#txtSenha").focus();
		return false;
	}
	if ($("#txtConfSenha").val().trim() == "") 
	{
		alert("Confirmação de senha é obrigatório.");
		$("#txtConfSenha").focus();
		return false;
	}
	if ($("#txtSenha").val().trim() != $("#txtConfSenha").val().trim()) 
	{
		alert("Senha e Confirmação de senha não se conciliam.");
		$("#txtSenha").focus();
		return false;
	}
	if ($("#txtTelefone").val().trim() == "") 
	{
		alert("Telefone é obrigatório.");
		$("#txtTelefone").focus();
		return false;
	}
	return true;
}

function Cadastro()
{
	$("#cadastro").show();
	$("#listagem").hide();
	$("#paginacao").hide();
	$("#hidID").val("");
	$("#txtNome").val("");
	$("#txtEmail").val("");
	$("#txtSenha").val("");
	$("#txtConfSenha").val("");
	$("#txtTelefone").val("");
}

function MascaraTelefone(objeto)
{
	if (objeto.value.length == 0)
		objeto.value = '(' + objeto.value;

	if (objeto.value.length == 3)
		objeto.value = objeto.value + ')';

	if (objeto.value.length == 8)
		objeto.value = objeto.value + '-';
}

function Salvar()
{
	var URL = "processar.php";
	var parametros = 
	{
		txtNome: $("#txtNome").val(),
		txtEmail: $("#txtEmail").val(),
		txtSenha: $("#txtSenha").val(),
		txtTelefone: $("#txtTelefone").val(),
		hidID: $("#hidID").val(),
		opcao: ($("#hidID").val() == "" ? "I" : "A")
	};
	$.ajax({
		url: URL,
		type: 'POST',
		data: parametros,
		dataType: 'html'
	})
	.done(function (retorno) { alert("Dados salvos com sucesso."); })
	.fail(function (jqXHR, textStatus, errorThrown) { alert(jqXHR); alert(textStatus); alert(errorThrown); });

	RedirecionamentoTela(1, 1);
	$("#listagem").show();
	$("#paginacao").show();
	$("#cadastro").hide();
}

function Editar(ID)
{
	$("#cadastro").show();
	$("#listagem").hide();
	$("#paginacao").hide();

	var URL = "processar.php";
	var parametros = { id: ID, opcao: "C" };
	$.ajax({
		url: URL,
		type: 'GET',
		data: parametros,
		dataType: 'html'
	})
	.done(function (retorno)
	{ 
		var dados = retorno.split('|');
		$("#hidID").val(dados[0]);
		$("#txtNome").val(dados[1]);
		$("#txtEmail").val(dados[3]);
		$("#txtSenha").val(dados[4]);
		$("#txtConfSenha").val(dados[4]);
		$("#txtTelefone").val(dados[2]);
	})
	.fail(function (jqXHR, textStatus, errorThrown) { alert(jqXHR); alert(textStatus); alert(errorThrown); });
}

function Excluir(ID)
{
	if (confirm("Tem certeza que deseja excluir este registro?"))
	{
		alert("Dados excluídos com sucesso.");
	}
}

$("#btnCadastro").click(function() { Cadastro(); });

$("#txtTelefone").keypress(function() { MascaraTelefone(this); });

$("#btnSalvar").click(function()
{
	if (ValidarCadastro())
	{
		Salvar();
	}
});

$("#btnVoltar").click(function()
{
	$("#listagem").show();
	$("#paginacao").show();
	$("#cadastro").hide();
});

$(document).ready(function()
{
	$("#hidCodMenu1").val("1");
	$("#listagem").hide();
	$("#paginacao").hide();
	RedirecionamentoTela(parseInt($("#hidCodMenu1").val()), 1);
});
</script>