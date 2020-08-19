<?php
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
		{
		//SQL de  alteração
		$q = "DELETE FROM usuario WHERE id = $id";
		$r = @mysqli_query($dbc,$q);
	if ($r)
	{
		echo
		"<div class='alert alert-sucess'>
		<h1><strong>Sucesso!</strong></h1>
		<p>Seu registro foi excluido com sucesso!</p>
		<p>Aguarde...Redirecionando!</p>
		</div>";
		echo "<meta HTTP_EQUIV='refresh' CONTENT='3;URL=usuario_menu.php'>";
	}else
	{
		echo
		"<div class='alert alert-danger'>
		<h1><strong>Erro no Sistema!</strong></h1>
		<p>Você não pode exlcuir o registro devido a um erro no sistema.
		Pedimos desculpas por qualquer inconveniente.</p>";
		$erro .= '/,p>' . mysqli_error($dbc) .
		'<br /> Query: ' . $q . '</p></div>';
	}
	}
	
	//Pesquisa para exibur o registro para alteração
	$q = "SELECT * FROM usuario WHERE id=$is";
	$r = @mysqli_query($dbc, $q);
	
	if(mysqli_num_rows ($r) ==1)
	{
		$row = mysqli_fetch_array($r, MYSQLI_NUM);

?>
	<form method="post" action="usuario_exc.php">
		
	  <div id="actions" align="right">
		<a href="usuario_menu.php">
		 <input type="button" class="btn btn-default" value="Fechar sem salvar"/>
		</a>
		 <input type="submit" class="btn btn-danger" value="Confirma Exclusão"/>
	  </div>
	  
	  <div class="row">
		<div class="form group col-md-4">
		  <label>Primeiro Nome</label>
		  <input type="text" name="p_nome" maxlength="20" class="form-control"
			placeholder="Digite o primeiro nome" value="<?php echo $row[1]; ?>" disabled />
		</div>
		
		<div class="form group col-md-8">
		  <label>Último Nome</Label>
		  <input type="text" name="u_nome" maxlength="50" class="form-control"
		    placeholder="Digite o último nome" value="<?php echo $row[2]; ?>" disabled />
		</div>
	  </div>
		
	  <div class="row">
		<div class="form group col-md-12">
		  <label>Endereço de e-mail</label>
		  <input type="text" name="email" maxlength="80" class="form-control"
			placeholder="Digite o seu endereço de e-mail" value="<?php echo $row[3]; ?>" disabled />
		</div>
	  </div>

		<input type="hidden" name="enviou" value="True" />
		<input type="hidden" name="id" value="<?php echo $row[0]; ?>"/>
	</form>
<?php	
}
  mysqli_close($dbc);
  include_once('../include/rodape.php');
  
?>