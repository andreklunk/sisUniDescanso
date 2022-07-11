<?php
//	include "intranet/sessao.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>SISUNI - Controle de Repasses Financeiros</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Itech Informática">
  <meta name="author" content="André Klunk">

	
	<link href="intranet/css/bootstrap.min2.css" rel="stylesheet">
	<link href="intranet/bootstrap4/bootstrap.min.css" rel="stylesheet">
	<link href="intranet/css/style.css" rel="stylesheet">


  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="intranet/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="intranet/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="intranet/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="intranet/img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="intranet/img/favicon.png">
  
</head>

<body>
<header class="navbar navbar-default navbar-static-top" role="banner">
  <div class="container">   
    <nav class="collapse navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">

        <li>
        <?php include_once ('intranet/config.inc.php');?>
        <h2><img src="logo.png"> &nbsp; <?=$municipio;?></h2>      <br/>
        </li>
      </ul>
    </nav>
  </div>
</header>

<!-- Begin Body -->
<div class="container" id="corpo">
  <div class="row">
	  <div class="col-md-3" id="leftCol">
              	<p></p>
				<div class="well" id="menu"> 
              	<ul class="nav nav-stacked" id="sidebar">
                <li><a href="?url=inicial">Início</a></li>
                  <li><a href="?url=inf">Informações </a></li>
                  <li><a href="?url=inscricao">Efetuar Inscrição </a></li>
                  <li><a href="?url=solicitacoes">Consulta Inscrições </a></li>
                  <li><a href="?url=denuncia">Denúncias </a></li>
              	</ul>
  				</div>
      		</div>  
           
            
      		<div class="col-md-9" id="conteudo" align="justify">
            <p> </p>  	
  			<?php 
							$url = $_GET['url'];
							switch($url) {
								case 'inicial' : include('inicial.php'); break;
								case 'inscricao' : include('inscricao.php'); break;
								case 'msgCadPessoalOK' : include('msg_cadpessoalOK.php'); break;
								case 'msgOK_PrimeiroCad' : include('frequencia_cadastro.php'); break;
								case 'freqAlt' : include('frequencia_alteracao.php'); break;
								case 'msgErro' : include('msg_erro.php'); break;
								case 'msgDuplicado' : include('msg_duplicado.php'); break;
								case 'inscOK' : include('inscricaoOK.php'); break;
								case 'doc' : include('documentacao.php'); break;
								case 'inf' : include('inf.php'); break;
								case 'solicitacoes' : include('solicitacoes.php'); break;
								case 'sol_lista' : include('sol_lista.php'); break;
								case 'denuncia' : include('denuncia.php'); break;
								case 'msg_denuncia' : include('msg_denunciaOK.php'); break;
							default	:	include('inicial.php');	break;
			}

		 ?>
						</p>
					</div>
				</div>
 	</div>
</div>
	<script type="text/javascript" src="intranet/js/jquery.min.js"></script>
	<script type="text/javascript" src="intranet/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="intranet/js/scripts.js"></script>
	<script type="text/javascript" src="intranet/js/popper.min.js"></script>
    <script src="intranet/js/jquery.maskedinput.js" type="text/javascript"></script>
</body>
</html>
