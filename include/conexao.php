<?php 
	//Define as informações de acesso
	//ao banco de dados como constantes
	define('DB_SERVIDOR', 'localhost');
	define('DB_USUARIO', 'root');
	define('DB_SENHA', '');
	define('DB_BANCO', 'loja');
	
	$dbc = @mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_SENHA, DB_BANCO) or
	die ('Não foi possível conectar ao MySQL');
?>