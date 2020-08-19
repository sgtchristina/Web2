<?php
	$titulo = "Loja de miniaturas - Menu de usuários";
	include_once('../include/cabecalho.php');
	
	require_once('../include/conexao.php');

    //Numero de registros para mostrar por pagina
    $exiba = 10;

    //Captura a busca
    $where = mysqli_real_escape_string ($dbc, trim(isset($_GET['q'])) ? $_GET['q'] : '');

    //Determina quantas paginnas existem
    if (isset ($_GET['p']) && is_numeric ($_GET['p']));
    {
        $pagina = $_GET['p'];
    } else //Não foi determinada
    {
        //Conta a quantidade de registros
        $q = "SELECT COUNT(id) * FROM usuario WHERE p_nome like '%$where%' OR 
            u_nome like '%$where%'";
        $r = @mysqli_query ($dbc, $q);
        $row = @mysqli_fetch_array ($r, MYSQLI_NUM);
        $qtde = $row[0];
        //Calcule o numero de paginas
        if ($qtde > $exiba);
        {
            //A função ceil arredonda o valor para cima ex. 5,05 é 6.
            $pagina = ceil ($qtde/$exiba);
        } else
        {
            $pagina = 1;
        }
    }

        //Determina uma posição no bd para comecar a
        //retornar os ressultados
        if (isset($_GET['s']) && is_numeric($_GET['s']))
        {
            $inicio = $_GET['s'];
        }
        else
        {
            $inicio = 0; 
        }
	
        //Determina a ordenação por padrão e por Codigo
        $ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'id';

        //Determina a ordem de classificação
    switch ($ordem)
    {
        case 'id':
        $order_by = 'id';
        break;
        case 'n':
        $order_by = 'p_nome';
        break;
        case 'e':
        $order_by = 'email';
        break;
        case 'd':
        $order_by = 'data_reg';
        break;
        default:
        $order_by = 'id';
        $ordem = 'id';
        break;
    }
	
	$q = "SELECT id, p_nome, u_nome, email, data_reg
				FROM usuario
				WHERE p_nome like '%$where%' OR
					  u_nome like '%$where%'
				ORDER BY $order_by
				LIMIT $inicio, $exiba";
	$r = @mysqli_query($dbc,$q);
	if (mysqli_num_rows($r) > 0)
	{
		$saida = '<div class ="table-responsive col-md-12">
		<table class="table table-striped">
		<thead>
			<tr>
			  <th width="10%"><strong>
				<a href="usuario_menu.php?ordem=id">Código</a></strong></th>
			  <th width="25%"><strong>
				<a href="usuario_menu.php?ordem=n">Nome</a></strong></th>
			  <th width="25%"><strong>
				<a href="usuario_menu.php?ordem=e">E-mail</a></strong></th>
			  <th width="20%"><strong>
				<a href="usuario_menu.php?ordem=d">Dt. Reg.</a></strong></th>
			  <th width="20%"><strong>
				Ações</strong></th>
			</tr>
		</thead> <tbody>';
		while ($row = mysqli_fetch_array($r,
		 MYSQLI_ASSOC))
		 {
			$saida .= '<tr>
			<td>' . $row['id'] . '</td>
			<td>' . $row['p_nome'] . ' '.
					$row['u_nome'] . '</td>
			<td>' . $row['email'] . '</td>
			<td>' .$row['data_reg'] . '</td>
			<td class="actions">
				<a href="usuario_alt.php?id=' . $row['id'] . '" class="btn btn-xs btn-warning">
					Editar</a>
				<a href="usuario_exc.php?id=' . $row['id'] . '" class="btn btn-xs btn-danger">
					Excluir</a>
			</td>
			</tr>';
		 }
		 $saida .= '</tbody></table></div>';
	} else
	{
		$saida = "<div class='alert alert-warning'>
		Sua pesquisa por <strong>$where</strong>
		não encontrou nenhum resultado.<br />";
		$saida .= "<strong>Dicas</strong><br />";
		$saida .= "- Tente palavras menos específicas<br />";
		$saida .= "- Tente palavras chaves diferentes<br />";
		$saida .= "- Confira a ortografia das palavras 
		e se elas foram acentuadas corretamente.<br />";
	}
	if ($pagina > 1)
	{
		$pag = '';
		$pagina_correta = ($inicio/$exiba) +1;
		
		//botao anterior
		if ($pagina_correta != 1)
		{
			$pag .= '<li class="prior"><a href="usuario_menu.php?s=' . ($inicio - $exiba) .
			'&p=' . $pagina . '&ordem=' . $ordem .  '">Anterior</a></li>';
		} else
		{
			$pag .= '<li class="disabled"><a>Anterior</a></li>';
		}
		
		//Todas as páginas
		for ($i = 1; $i <= $pagina; $i++)
		{
			if ($i != $pagina_correta)
			{
				$pag .= '<li><a href="usuario_menu.php?s=' . ($exiba * ($i - 1)).
				'&p=' . $pagina . '&ordem=' . $ordem . '">' . $i . '</a></li>';
			}
			else
			{
				$pag .= '<li class="disabled"><a>' .
				 $i .'</a></li>';
			}
		}
	}
	
	//botão proximo
	if ($pagina_correta != $pagina)
	{
		$pag .= '<li class="next"><a href="usuario_menu.php?s=' . ($inicio + $exiba) .
		 '&p=' . $pagina . '&ordem=' . $ordem . '">Próximo</a></li>';
	} else
	{
		$pag .= '<li class="disabled"><a>Próximo</a></li>';
	}
?>

<div id="main" class="container-fluid">
	<div id="top" class="row">
		
		<div class="col-md-3"><h2>Usuários</h2>
		</div>
		
		<div class="col-md-6">
			<div class="input-group h2">
				<input class="form-control" id="busca" type="text"
					placeholder="Pesquisa de usuário por Nome" />
				<span class="input-group-btn">
				 <a href="#" onclick="this.href='usuario_menu.php?q='+
				 document.getElementById('busca').value" class="btn btn-primary">
				<span class="glyphicon glyphicon-search">
				</span>
				</a>
				</span>
			</div>
		</div>
		
		<div class="col-md-3"><a href="usuario_cad.php" class="btn btn-primary pull-right h2">
			Inserir Usuario</a>
		</div>
	</div>
</div>

<hr/>

<div id="list" class="row">
		<?php echo $saida; ?>
</div>

<div id="botton" class="row">
	<ul class="pagination">
		<?php if (isset ($pag)) {echo $pag;} ?>
	</ul>
</div>
<?php
	include_once('../include/rodape.php');
?>