<div class="panel panel-default">
  <!-- Default panel contents -->
<?php
//=========================================================================
function UrlAtual(){
 $dominio= $_SERVER['HTTP_HOST'];
 $url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
 return $url;
}
$urlAtual = UrlAtual();
$urlMail = substr($urlAtual,0,-7);
//=========================================================================
	include "intranet/conexao.php";
	$cod_freq = base64_decode($_GET['cod_freq']);
	$query = "Select F.id_frequencia, PE.id_pessoa, nome, sobrenome, cpf, rg, endereco, telefone, email, banco, agencia, conta, tipo_conta, obs, razao_social as associacao, instituicao, curso, descricao as parcela, ano, semestre, num_dias_trans, num_disciplinas, num_reprovacao, DATE_FORMAT(F.data_cadastro,'%d/%m/%Y %H:%i:%s')as data_cadastro,DATE_FORMAT(F.dt_alteracao,'%d/%m/%Y %H:%i:%s')as dt_alteracao  
	 from pessoa PE, frequencia F, instituicao I, curso C, parcela PA, associacao A
	 where F.id_pessoa=PE.id_pessoa and F.id_instituicao=I.id_instituicao
	 and F.id_curso=C.id_curso and F.id_parcela=PA.id_parcela and PE.id_associacao=A.id_associacao
	 and F.id_frequencia=$cod_freq;";
	$resultado = mysqli_query($link,$query) or die (mysqli_error($link));
	$reg = mysqli_fetch_array($resultado);
		$id_pessoa = $reg['id_pessoa'];
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
		$instituicao = $reg['instituicao'];
		$curso = $reg['curso'];
		$parcela = $reg['parcela'];
		$ano = $reg['ano'];
		$semestre = $reg['semestre'];
		$num_dias = $reg['num_dias_trans'];
		$num_disciplinas = $reg['num_disciplinas'];
		$num_reprovacao = $reg['num_reprovacao'];
		$data = $reg['data_cadastro'];
		$data_alt = $reg['dt_alteracao']??'';
		
		/*$data = substr($data_hora,0,10);
	 	$data= explode("-",$data);
	    $data=$data[2]."/".$data[1]."/".$data[0];		
		$hora = substr($data_hora,11,10);*/
?>


  <div class="panel-heading">
      <h4>Procedimento de inscrição realizado com Sucesso</h4>
  </div>
  <div class="panel-body">
  <p></p>
 <style type="text/css">
 #dados {
	 font-style:italic;
	 font-weight:bold;
 }
 </style>      
    <table width="400" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
            <tr>
              <th colspan="4" align="center">Dados Pessoais</th>
            </tr>
            <tr>
              <td width="16%" align="right">Nº Inscrição:</td>
              <td width="42%" id="dados"><?php echo $cod_freq; ?>
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
            
            
            <table width="400" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
            <tr>
              <th colspan="4">Dados de Frequência</th>
            </tr>
            <tr>
              <td width="18%" align="right">Parcela:</td>
              <td width="24%" valign="middle" id="dados"><?php echo $parcela; ?></td>
              <td width="20%" align="right">Data Cadastro:<br>Data Alteração:</td>
              <td width="38%" valign="middle" id="dados"><?php echo $data; ?><br><?php echo $data_alt; ?></td>
            </tr>
            <tr>
              <td align="right">Instituição:</td>
              <td valign="middle" id="dados"><?php echo $instituicao; ?></td>
              <td align="right">Curso:</td>
              <td valign="middle" id="dados"><?php echo $curso; ?></td>
            </tr>
            <tr>
              <td align="right">Nº Dias de Transporte::</td>
              <td valign="middle" id="dados"><?php echo $num_dias; ?></td>
              <td align="right">Semestre/Ano:</td>
              <td valign="middle" id="dados"><?php echo $semestre.'/'.$ano; ?></td>
            </tr>
            <tr>
              <td align="right">Nº Disciplinas: </td>
              <td valign="middle"><?php echo $num_disciplinas; ?></td>
              <td align="right">Reprovação:</td>
              <td valign="middle"><?php echo $num_reprovacao; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2" align="right"><a href="javascript:void(null);" onclick="javascript:window.open('gera_pdf_documentos.php?codPessoa=<?php echo base64_encode($id_pessoa); ?>');"> <button id="botao" name="botao" class="btn btn-primary">Imprimir Documentação</button></a></td>
              <td colspan="2" align="right"><a href="javascript:void(null);" onclick="javascript:window.open('gera_comprovante.php?freq=<?php echo base64_encode($cod_freq); ?>');"> <button id="botao" name="botao" class="btn btn-primary">Imprimir Comprovante de Inscrição</button></a></td>
            </tr>
    </table>
   
  </div>

</div>
<?php
//Se a url vier do cadastro, manda email
if (substr($urlAtual, -6)=='mail=S') {
	include_once('mail.php');
}
?>

