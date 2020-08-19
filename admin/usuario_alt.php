<?php
	$titulo = "Loja de Miniaturas - Alteração de usuário";
	include_once('../include/cabecalho.php');
	
	if((isset($_GET['id'])) && (is_numeric($_GET['id'])))
	{
		$id = $_GET['id'];
	} else if ((isset($_POST['id'])) && (is_numeric($_POST['id'])))
	{
		$id = $_POST['id'];
	} else
	{
		header("Location: usuario_menu.php");
		exit();
	}
require_once('../include/conexao.php');
	if(isset($_POST['enviou']))
	{
		$erros = array();
	
	//Verifica se há um primeiro nome:
	if (empty($_POST['p_nome']))
	{
		$erros[] = 'Você esqueceu de digitar o seu primeiro nome.';
	} else
	{
		$pn = mysqli_real_escape_string($dbc, trim($_POST['p_nome']));
	}
	
	//Verifica se há um último nome:
	if (empty($_POST['u_nome']))
	{
		$erros[] = 'Você esqueceu de digitar o seu último nome.';
	} else
	{
		$un = mysqli_real_escape_string($dbc, trim($_POST['u_nome']));
	}
	
	//Verifica se há um endereço de e-mail:
	if (empty($_POST['email']))
	{
		$erros[] = 'Você esqueceu de digitar o seu endereço de E-mail.';
	} else
	{
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	
	//Verifica se há uma senha e testa a confirmação:
	if (!empty($_POST['pass1']))
	{
		if ($_POST['pass1'] != $_POST['pass2'])
		{
		$erros[] = 'Sua senha não correponde a confirmação.';
		}
	} else
	{
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
	}
	}
	else
	{
		$erros[] = 'Você esqueceu de digitar a sua senha.';
	}
	
	if (empty($erros))
	{
		//SQL de alteração
		$q = "UPDATE usuario SET p_nome = '$pn', u_nome = '$un',
				email = '$e', pass = SHA1('DWEBII.$p')
			WHERE id = $id";
		$r = @mysqli_query($dbc, $q);
		
	if ($r)
	{
		$sucesso = 
		"<h1><strong>Sucesso!</strong></h1>
		<p>Seu registro foi alterado com sucesso!</p>
		<p>Aguarde...Redirecionando!</p>";
		echo"<meta HTTP-EQUIV='refresh' CONTENT='3;URL=usuario_menu.php'>";
	}else
	{
		$erro = 
		"<h1><strong>Erro no Sistema!</strong></h1>
		<p>Você não pode alterar o registro devido a um erro do sistema.
		Pedimos desculpas por qualquer inconveniente!</p>";
		$erro .='<p>' . mysqli_error($dbc).
		'<br /> Query: ' . $q . '</p>';
	}
	}
	else
	{
		"<h1><strong>Erro!</strong></h1>
		<p>Ocorreram o(s) seguinte(s) erro(s):<br />";
		foreach ($erros as $msg)
		{
			$erro .=" - $msg <br /> \n";
		}
		$erro .= "</p><p>Por favor, tente novamente.</p>";
	}
	
	
	//Pesquisa para exibir o registro para alteração
	$q = "SELECT * FROM usuario WHERE id=$id";
	$r = @mysqli_query($dbc,$q);
	
	if (mysqli_num_rows($r) ==1)
	{
		$row = mysqli_fetch_array($r, MYSQLI_NUM);
	
	if (isset ($erro))
		echo "<div class='aler alert-danger'>$erro </div>";
	
		if(isset ($sucesso))
		echo "<div class='alert alert-sucess'>$sucesso </div>";
?>
	<h1 class="page-header">Usuário - Alteração</h1>
	
	<form method="post" action="usuario_alt.php">
	
	  <div id="actions" align="right">
		<a href="usuario_menu.php">
		 <input type="button" class="btn btn-default" value="Fechar sem Salvar"/>
		</a>
		 <input type="submit" class"btn btn-warning" value="Salvar Alteração"/>
	  </div>
	  
	  <div class="row">
		<div class="form group col-md-4">
			<label>Primeiro Nome</label>
			<input type="text" name="p_nome" maxlength="20" class="form-control"
			 placeholder="Digite o primeiro nome" value="<?php echo $row[1]; ?>" />
		</div>
		
		<div class="form group col-md-8">
			<label>Último Nome</label>
			<input type="text" name="u_nome" maxlength="50" class="form-control"
			 placeholder="Digite o último nome" value="<?php echo $row[2]; ?>" />
		</div>
	  </div>

	  <div class="row">
		<div class="form group col-md-12">
			<label>Endereço de e-mail</label>
			<input type="text" name="email" maxlength="80" class="form-control"
			 placeholder="Digite o seu endereço de e-mail" value="<?php echo $row[3]; ?>" />
		</div>
	  </div>	
	  
	  <div class="row">
		<div class="form group col-md-4">
			<label>Senha:</label>
			<input type="password" name="pass1" maxlength="10" class="form-control"
			 placeholder="Digite a senha" />
		</div>
		
		<div class="form group col-md-4">
			<label>Confirmação de senha:</label>
			<input type="password" name="pass2" maxlength="10" class="form-control"
			 placeholder="Digite a sua senha" />
		</div>
	  </div>
	  <input type="hidden" name="enviou" value="True" />
	  <input type="hidden" name="id" value="<?php echo $row[0]; ?>"/>
	  </form>
<?php
	}	
	mysqli_close($dbc);
	include_once('../includ/rodape.php');
?>