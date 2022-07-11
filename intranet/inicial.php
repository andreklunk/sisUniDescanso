<?php	
if (session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
if($_SESSION['us_sessao']!=session_id())
{
	header("Location: index.php?mensagem=erro_sessao");
}
$_SESSION['us_sessao'];
$_SESSION['us_id'];
$_SESSION['us_nome'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>SISUNI - Controle de Repasses Financeiros</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
    <script src="js/jquery.maskedinput.js" type="text/javascript"></script>
    <script type='text/javascript' src='datagrid/modules/jsafv/lang/jsafv-en.js'></script>     
    <script type='text/javascript' src='datagrid/modules/jsafv/chars/diactric_chars_utf8.js'></script>
    <script type='text/javascript' src='datagrid/modules/jsafv/form.scripts.js'></script>
</head>

<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> 
					 <a class="navbar-brand" href="inicial.php">Início</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="dropdown1"><!--  Incluido "1" em virtude do editor de texto longo.  -->
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rotinas<strong class="caret"></strong></a>
							 <ul class="dropdown-menu">
								<li>
									<a href="?url=assoc">Associações Acadêmicas</a>
								</li>
								<li>
									<a href="?url=inst">Instituições de Ensino</a>
								</li>
								<li>
									<a href="?url=curso">Cursos</a>
								</li>
                                <li>
									<a href="?url=nivel">Nível Escolar</a>
								</li>
								<li class="divider"></li>
                                <li>
									<a href="?url=inf">Informações Tela Inicial</a>
								</li>
                                <li>
									<a href="?url=arquivo">Arquivos para Download</a>
								</li>								
								<li class="divider">
								</li>
                                <li>
									<a href="?url=parcela">Parcelas/Repasses</a>
								</li>
								<li>
									<a href="?url=pgto">Gerar Pagamentos</a>
								</li>
							</ul>                         
						</li>
					</ul>
                   
                    
				<ul class="nav navbar-nav navbar-left">
						<li>
							<a href="?url=pessoa">Pessoas</a>
						</li>
                        <li>
							<a href="?url=freq">Frequência</a>
						</li>
					<li>
							<a href="?url=doc">Documentos</a>
						</li>
                        
                   <li class="dropdown1"><!--  Incluido "1" em virtude do editor de texto longo.  -->
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatórios<strong class="caret"></strong></a>
							 <ul class="dropdown-menu">
								<li>
									<a href="?url=rel_pgto">Pagamentos por Parcela</a>
								</li>
                                <li>
									<a href="?url=rel_pgtoBanco">Pagamentos Por Banco</a>
								</li>
                               <li>
									<a href="?url=rel_pgtoPIX">Pagamentos PIX</a>
								</li>
                                <li class="divider"></li>
                                <li>
									<a href="?url=rel_dadosP">Dados Pessoais - Todos</a>
								</li>
                                <li>
									<a href="?url=rel_dadosPV">Dados Pessoais - Situação</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="?url=rel_pub">Inscrições - Publicação</a>
                                    <a href="?url=rel_pub_pgto">Pagamentos - Publicação</a>
								</li>
							</ul>                         
						</li>     
                              
                 </ul>
				               
               <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown1"><!--  Incluido "1" em virtude do editor de texto longo.  -->
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['us_nome']; ?><strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="?url=usuario">Usuários</a>
								</li>
								<li>
									<a href="backup.php">Backup</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="logoff.php">Sair do Sistema</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				
			</nav>
		</div>
	</div>
    
    
    <!-- DIV DO CONTEUDO DINAMICO -->
	<div class="row clearfix">
		<div class="col-md-12 column">
        <?php
			if(isset($_GET['url'])){
				$url = $_GET['url'];
			} else {
				$url = '';
			};
			
			switch($url) {
				case 'assoc' : include('associacao.php'); break;
				case 'inst' : include('instituicao.php'); break;
				case 'curso' : include('curso.php'); break;
				case 'inf' : include('informacoes.php'); break;
				case 'arquivo' : include('arquivos.php'); break;
				case 'nivel' : include('nivel.php'); break;
				case 'parcela' : include('parcela.php'); break;
				case 'doc' : include('documentacao.php'); break;	
				case 'pessoa' : include('pessoa.php'); break;
				case 'freq' : include('frequencia.php'); break;
				case 'usuario' : include('usuario.php'); break;
				case 'pgto' : include('pgto.php'); break;
				case 'salva_pgto' : include("salva_pgto.php"); break;
				case 'rel_pgto' : include("rel_pgto.php"); break;
				case 'rel_pgtoBanco' : include("rel_pgtoBanco.php"); break;
				case 'rel_pgtoPIX' : include("rel_pgtoPIX.php"); break;
				case 'rel_dadosP' : include("rel_dadosPessoais.php"); break;
				case 'rel_dadosPV' : include("rel_dadosPessoaisV.php"); break;
				case 'rel_pub' : include("rel_publicacao.php"); break;
				case 'rel_pub_pgto' : include("rel_publicacao_pgto.php"); break;
				default	:	include('inicial_tela.php');	break;
			}
		?>
		</div>
	</div>
</div>
</body>
</html>
