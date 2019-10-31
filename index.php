<?php
	require_once 'CLASSES/usuarios.php';
	$u = new Usuario;
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Projeto Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" href="CSS/estilo.css">
</head>
<body>
	<div id="corpo-form">
		<h1>Entrar</h1>
		<form method="POST">
			<input type="email" placeholder="Usuário" name="email">
			<input type="password" placeholder="Senha" name="senha">
			<input type="submit" value="ACESSAR">
			<a href="cadastrar.php">Ainda não é inscrito?<strong>Cadastre-se</strong></a>
		</form>
	</div>
	<?php
	if (isset($_POST['email']))
	{
		$email = addslashes($_POST['email']);
		$senha = addslashes($_POST['senha']);
		if (!empty($email) && !empty($senha))
		{
			$u->conectar("projeto_login", "localhost", "root", "");
			if ($u->msgErro == "")	//se está tudo OK
			{
				if ($u->logar($email, $senha))
				{
					header("location: areaPrivada.php");
				}
				else
				{
					?>
					<div id="msg-erro">
					E-mail e/ou senha estão incorretos!
					</div>
					<?php
				}
			}
			else
			{
				?>
				<div id="msg-erro">
				<?php echo "Erro: ".$u->msgErro; ?>
				</div>
				<?php
			}
		}
		else
		{
			?>
			<div id="msg-erro">
			Preencha todos os campos!
			</div>
			<?php
		}
	}
	?>
</body>
</html>