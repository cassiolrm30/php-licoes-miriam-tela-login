<?php
Class Usuario
{
	private $PDO;
	public $msgErro = "";

	public function conectar($nome, $host, $usuario, $senha)
	{
		global $PDO;
		try
		{
			$PDO = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
		}
		catch (PDOException $e)
		{
			$msgErro = $e->getMessage();
		}
	}

	public function cadastrar($nome, $telefone, $email, $senha)
	{
		global $PDO;
		// verificar se já existe o e-mail cadastrado
		$sql = $PDO->prepare("SELECT Id FROM Usuario WHERE email = :e");
		$sql->bindValue(":e", $email);
		$sql->execute();
		if ($sql->rowCount() > 0)
			return false;	// já está cadastrado
		else
		{
			//caso não, cadastrar
			$sql = $PDO->prepare("INSERT INTO Usuario (nome, telefone, email, senha) VALUES (:n,:t,:e,:s)");
			$sql->bindValue(":n", $nome);
			$sql->bindValue(":t", $telefone);
			$sql->bindValue(":e", $email);
			$sql->bindValue(":s", md5($senha));
			$sql->execute();
			return true;
		}
	}

	public function atualizar($nome, $telefone, $email, $senha, $id)
	{
		global $PDO;
		$sql = $PDO->prepare("UPDATE Usuario SET nome = :n, telefone = :t, email = :e, senha = :s WHERE Id = :id");
		$sql->bindValue(":n", $nome);
		$sql->bindValue(":t", $telefone);
		$sql->bindValue(":e", $email);
		$sql->bindValue(":s", md5($senha));
		$sql->bindValue(":id", $id);
		$sql->execute();
		return true;
	}

	public function excluir($id)
	{
		global $PDO;
		$sql = $PDO->prepare("DELETE FROM Usuario WHERE Id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
		return true;
	}

	public function logar($email, $senha)
	{
		global $PDO;
		//verificar se o e-mail e senha estão cadastrados, se sim
		$sql = $PDO->prepare("SELECT Id FROM Usuario WHERE email = :e AND senha = :s");
		$sql->bindValue(":e", $email);
		$sql->bindValue(":s", md5($senha));
		$sql->execute();
		if ($sql->rowCount() > 0)
		{
			//entrar no sistema (sessão)
			$dado = $sql->fetch();
			session_start();
			$_SESSION['ID'] = $dado['Id'];
			return true;	//logado com sucesso
		}
		else
		{
			return false;	//não foi possível logar
		}
	}

	public function getAll()
	{
		global $PDO;
		$cmd = $PDO->prepare("SELECT Id, nome, telefone, email FROM Usuario");
		$cmd->execute();
		$resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getCount()
	{
		global $PDO;
		$cmd = $PDO->prepare("SELECT COUNT(*) as COUNT FROM Usuario");
		$cmd->execute();
		$resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getAllByPagination($pagina, $qtLinhas)
	{
		global $PDO;
		$inicio = ($pagina - 1) * $qtLinhas;
		$cmd = $PDO->prepare("SELECT Id, nome, telefone, email FROM Usuario LIMIT ".$inicio.",".$qtLinhas);
		$cmd->execute();
		$resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function get($id)
	{
		global $PDO;
		$cmd = $PDO->prepare("SELECT * FROM Usuario WHERE Id = :id");
		$cmd->bindValue(":id", $id);
		$cmd->execute();
		$resultado = $cmd->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
?>