<?php
require_once('phpMailer/class.phpmailer.php');
include_once('intranet/config.inc.php');

$mail = new PHPMailer();

$mail->IsHTML(true); // envio como HTML se 'true'
//$email->SetLanguage("br");
$mail->WordWrap = 75; // Definição de quebra de linha
//$mail->CharSet = 'utf-8';
$mail->IsSMTP(); // send via SMTP
$mail->SMTPAuth = true; // 'true' para autenticação
//$mail->$SMTPAuth; # Usar autenticação SMTP 
$mail->Mailer = "smtp"; //Usando protocolo SMTP
$mail->Port=$mail_porta;
$mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível

if($mail_SMTPSecure!='')
	$mail->SMTPSecure = $mail_SMTPSecure;	// SSL REQUERIDO pelo GMail
$mail->Host = $mail_host; 
$mail->Username = $mail_usuario; 
$mail->Password = $mail_senha; 
$mail->From = $mail_from;
$mun = iconv('UTF-8', 'ISO-8859-1', $municipio);
		$mun = mb_convert_encoding($municipio, 'ISO-8859-1', 'UTF-8');
$mail->FromName = "SISUNI";

$mail->AddAddress($email);
//$mail->AddBcc("andreklunk@yahoo.com.br");
//$mail->AddBcc("andre@saojoao.sc.gov.br");
//$mail->AddReplyTo("andreklunk@yahoo.com.br");

//$mail->AddAttachmente("/var/tmp/arquivo.ext");
//CONVERTER O NOME PARA FORMATAÇÃO CERTA NO E-MAIL		
	//	$iso88591_1 = utf8_decode($_SESSION[us_nome]);

//		$nome = iconv('UTF-8', 'ISO-8859-1', $nome);
		$nome = mb_convert_encoding($nome, 'ISO-8859-1', 'UTF-8');
		$cpf = $cpf;
		$data = $data;
		$parcela = $parcela;		
$mail->Subject = "Parcela - $parcela";
$corpo = "<font color='000099'>PROGRAMA MUNICIPAL DE CONCESSÃO DE BOLSAS DE ESTUDO - $mun </font><br>";
$corpo .= "<b>Nome:</b> $nome |  <b>CPF:</b> $cpf <br>";
$corpo .= "<b>E-mail:</b> $email <br>";
$corpo .= "<b>Parcela:</b> $parcela <br>";
$corpo .= "<b>Data Cadastro:</b> $data<br>";
$corpo .= "<b>Data Alteração:</b> $data_alt<br><hr>";
$corpo .= "<b><br>Link de Confirmação da Inscrição:</b> $urlMail <br><br>";
$corpo .= "Mantenha esse link caso necessite reimprimir o comprovante de inscrição<br><br><br><br>";
//$mail-> Body = $corpo;
$mail->Body .= nl2br($corpo);
//echo $corpo; break;
if(!$mail->Send()) {
    echo "A mensagem nao foi enviada";
    echo "Erro: " . $mail->ErrorInfo;
    exit;
    } 
	//else {
	//	header('location:msg_OK.php'); 
	//	exit;
	//}
?> 