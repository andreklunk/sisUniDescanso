<div class="panel panel-default">
  <!-- Default panel contents -->
	 <style type="text/css">
 #dados {
	 font-style:italic;
	 font-weight:bold;
 }
	 h4 {
		 text-align: center;
		 color:#8ECC86;
		 font-weight: bold;
	 }
 </style> 
  <div class="panel-heading">
      <h4>Dados Cadastrais Atualizados com Sucesso</h4>
  </div>
<?php
include_once("intranet/conexao.php");
	//$cod_usuario = $_GET['id'];
	$cod_pessoa = base64_decode($_GET['id']);
	$query = "Select nome, sobrenome, cpf, rg, endereco, telefone, email, banco, agencia, conta, 
	tipo_conta, obs, razao_social as associacao
	 from pessoa PE, associacao A
	 where PE.id_associacao=A.id_associacao
	 and PE.id_pessoa=$cod_pessoa;";
	$resultado = mysqli_query($link,$query) or die (mysqli_error($link));
	$reg = mysqli_fetch_array($resultado);
		$nome = $reg['nome'].' '.$reg['sobrenome'];;
		$rg = $reg['rg'];
		$cpf = $reg['cpf'];
		$endereco = $reg['endereco'];
		$telefone = $reg['telefone'];
		$email = $reg['email'];
		$banco = $reg['banco'];
		$agencia = $reg['agencia'];
		$conta = $reg['conta'];
		$tp_conta = $reg['tipo_conta'];
		$obs = $reg['obs'];
		$associacao = $reg['associacao'];		
?>


  <div class="panel-body">
  <p></p>
     
    <table width="400" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
            <tr>
              <th colspan="4" align="center">Dados Pessoais</th>
            </tr>
            <tr>
              <td width="16%" align="right">Nº Cadastro:</td>
              <td width="42%" id="dados"><?php echo $cod_pessoa; ?>
              <input name="freq" type="hidden" id="freq" value="<?php echo $cod_freq; ?>"></td>
              <td width="17%" align="right">CPF:</td>
              <td width="25%" id="dados"><?php echo $cpf; ?></td>
            </tr>
            <tr>
              <td align="right">Nome:</td>
              <td id="dados"><?php echo $nome; ?></td>
              <td align="right">RG:</td>
              <td id="dados"><?php echo $rg; ?></td>
            </tr>
            <tr>
              <td align="right">Endereço:</td>
              <td colspan="3" id="dados"><?php echo $endereco; ?></td>
            </tr>
            <tr>
              <td align="right">Telefone:</td>
              <td id="dados"><?php echo $telefone; ?></td>
              <td colspan="2" align="left">E-mail: <span id="dados"><?php echo $email; ?></span></td>
            </tr>
            <tr>
              <td align="right">Associação:</td>
              <td id="dados"><?php echo $associacao; ?></td>
              <td align="right">&nbsp;</td>
              <td id="dados2">&nbsp;</td>
            </tr>
            <tr>
              <td align="right">Banco:</td>
              <td id="dados"><?php echo $banco; ?></td>
              <td align="right">Agência/Conta:</td>
              <td id="dados"><?php echo $agencia.' / '.$conta; ?></td>
            </tr>
            <tr>
              <td align="right">OBS:</td>
              <td colspan="3" id="dados"><?php echo $obs; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            </table>
</div>

