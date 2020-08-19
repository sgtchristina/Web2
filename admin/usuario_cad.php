<?php
	$titulo = "Cadastro de Usuários";
	include_once('../include/cabecalho.php');
	
	if(isset($_POST['enviou']))
	{
		require_once('../include/conexao.php');
		
		$erros = array();
		//verifica se há um primeiro nome
	if (empty ($_POST['p_nome']))
	{
		$erros[] = 'Você esqueceu de digitir o seu primeiro nome.';
	}else
	{
		$pn = mysqli_real_escape_string($dbc, trim ($_POST['p_nome']));
	}
	
	//Verifica se há um ultimo  nome
	if (empty ($_POST['u_nome']))
	{
		$erros[] = 'Você esqueceu de digitir o seu último nome.';
	}else
	{
		$un = mysqli_real_escape_string($dbc, trim ($_POST['u_nome']));
	}

		//Verifica se há um endereço de e-mail
		if (empty ($_POST['email']))
	{
		$erros[] = 'Você esqueceu de digitir o seu endereço de e-mail.';
	}else
	{
		$e = mysqli_real_escape_string($dbc, trim ($_POST['email']));
	}
	
		//Verifica se há um senha e testa a confirmação
		if (!empty ($_POST['pass1'])) 
		{
		if ($_POST['pass1'] != $_POST['pass2']) 
			{
				$erros [] = 'Sua senha não corresponde a confirmação.';
			} else
			{
				$p = mysqli_real_escape_string($dbc, trim ($_POST['pass1']));
			}
		}
		else
		{
			$erros[] = 'Você esqueceu de digitar sua senha.';
		}
		
		if (empty ($erros))
		{
			//SQL de inserção
		$q = "INSERT INTO usuario (p_nome, u_nome, email, pass, data_reg)
		VALUES ('$pn', '$un', '$e' SHA1('DWEBII.$p'), NOW() )";
		
		$r = @mysqli_query($dbc, $q);
		if ($r)
		{
			$sucesso =
			"<h1><strong>Sucesso!</strong></h1>
			<p>Seu registro foi incluido com sucesso!</p>
			<p>Aguarde...Redirecionando!</p>";
			echo "<meta HTTP-EQUIV='refresh' CONTENT='3;URL=usuario_menu.php>";
		}else
		{
			$erro = 
			"<h1><strong>Erro no Sistema</strong></h1>
			<p>Você não pode ser registrado devido a um erro do sistema
			Pedimos desculpas por qualquer inconveniente.</p>";
			$erro .= '<p>' . mysqli_error ($dbc) .
			'<br /> Query: ' . $q . '</p>'; 
		}
		} else
		{
			$erro = 
				"<h1><strong>Erro!</strong></h1>
				<p>Ocorreram o(s) seguinte(s) erro(s): <br />";
				foreach ($erros as $msg)
				{
					$erro .= " - $msg <br /> \n";
				}
				 $erro .= "</p><p> Por favor, tente novamente.</p>";
		}
		
	}
	if (isset($erro))
	{
		echo "<div class='alert alert-danger'>$erro </div>";
		
			if (isset($sucesso))
		echo "<div class='alert alert-success'>$sucesso </div>";
	}
	
?>
		<h1 class="page-header">Usuário - Cadastro</h1>
			<form method="post"
				action="usuario_cad.php">
			<div id="actions" align="right">
				<a href="#">
				<input type="button"
					class="btn btn-default"
					value="Fechar sem salvar"/>
					</a>
				<input type="submit" class="btn btn-primary"
					value="Salvar"/>
			</div>
			
			<div class="row">
				<div class="form-group col-md-4">
				<label>Primeiro Nome</label>
				<input type="text"
					name="p_nome"
					maxlength="20"
					class="form-control"
					placeholder="Digite o primeiro Nome" 
					value="<?php if (isset($_POST ['p_nome']))
						echo $_POST['p_nome'];?>" />
				</div>
				
					<div class="form-group col-md-8">
				<label>Último Nome</label>
				<input type="text"
					name="u_nome"
					maxlength=50"
					class="form-control"
					placeholder="Digite o último Nome"
					value="<?php if (isset($_POST ['u_nome']))
						echo $_POST['u_nome'];?>" />
				</div>
			</div>		
			
			<div class="row">
				<div class="form-group col-md-12">
				<label>Endereço de e-mail</label>
				<input type="email"
					name="email"
					maxlength="80"
					class="form-control"
					placeholder="Digite o seu enredeço de E-mail" 
					value="<?php if (isset($_POST ['email']))
						echo $_POST['email'];?>" />
				</div>
			</div>
				
			<div class="row">
				<div class="form-group col-md-4">
				<label>Senha: </label>
				<input type="password"
					name="pass1"
					maxlength="10"
					class="form-control"
					placeholder="Digite sua senha senha" />
				</div>			
			
				<div class="form-group col-md-4">
				<label>Confirmação de Senha:</label>
				<input type="password"
					name="pass2"
					maxlength="10"
					class="form-control"
					placeholder="Confirma a sua senha" />
				</div>
			</div>	
			<input type="hidden" name="enviou"
				value="True"/> 
			</form>

<?php
	include_once('../include/rodape.php');
?>