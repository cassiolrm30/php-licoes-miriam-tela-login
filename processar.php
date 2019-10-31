<?php
	require_once 'CLASSES/usuarios.php';
	$u = new Usuario;
	
	if (isset($_GET['opcao']))
	{
		if ($_GET['opcao'] == "C")
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
				$parametros = "opcao: ".$_GET['opcao']."\nid: ".$id;
				$u->conectar("projeto_login", "localhost", "root", "");
				if ($u->msgErro == "")
				{
					$item = new Usuario;
					$item = $u->get($id);
					$resultado = "";
					if (!empty($item))
					{
						$resultado .= $item["Id"]."|";
						$resultado .= $item["nome"]."|";
						$resultado .= $item["telefone"]."|";
						$resultado .= $item["email"]."|";
						$resultado .= "123456";
					}
					echo($resultado);
				}
			}
		}
		else
		{
			if ($_GET['opcao'] == "L")
			{
				$pagina = $_GET['pagina'];
				$qtLinhas = $_GET['qtLinhas'];
				$qtUsuarios = "";
				$u->conectar("projeto_login", "localhost", "root", "");
				if ($u->msgErro == "")
				{
					$usuarios = $u->getAllByPagination($pagina, $qtLinhas);
					$resultado = "";
					for ($i = 0; $i < count($usuarios); $i++)
					{
						$item  = $usuarios[$i];
						$resultado .= $item["nome"].";".$item["telefone"].";".$item["email"].";".$item["Id"]."|";
					}
					//if (strlen($resultado))
					//	$resultado = substr($resultado, 0, -1);
					//$resultado .= "|".count($usuarios);
					$qtUsuarios = $u->getCount();

					$resultado .= "|".$qtUsuarios[0]["COUNT"];
					echo($resultado);
				}
			}
		}
	}
	else
	{
		$nome 	  = addslashes($_POST['txtNome']);
		$telefone = addslashes($_POST['txtTelefone']);
		$email 	  = addslashes($_POST['txtEmail']);
		$senha 	  = addslashes($_POST['txtSenha']);
		$id 	  = addslashes($_POST['hidID']);
		$parametros = "nome: ".$nome."\ntelefone: ".$telefone."\ne-mail: ".$email."\nsenha: ".$senha."\nid: ".$id."\nopcao: ".$_POST['opcao'];
		?><div><?=$parametros?></div><?php
		
		switch ($_POST['opcao'])
		{
			case "I":
				if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha))
				{
					$u->conectar("projeto_login", "localhost", "root", "");
					if ($u->msgErro == "")	//se está tudo OK
					{
						$resultado = $u->cadastrar($nome, $telefone, $email, $senha);
						echo($resultado);
					}
				}
				break;
			case "A":
				if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha))
				{
					$u->conectar("projeto_login", "localhost", "root", "");
					if ($u->msgErro == "")	//se está tudo OK
					{
						$resultado = $u->atualizar($nome, $telefone, $email, $senha, $id);
						echo($resultado);
					}
				}
				break;
			case "E":
				$id 	  = addslashes($_GET['id']);
				if (!empty($id))
				{
					$u->conectar("projeto_login", "localhost", "root", "");
					if ($u->msgErro == "")	//se está tudo OK
					{
						$resultado = $u->excluir($id);
						echo($resultado);
					}
				}					
		}
	}
?>