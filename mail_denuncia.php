<?php
require_once('phpMailer/class.phpmailer.php');
include_once('intranet/config.inc.php');
$mail = new PHPMailer();

$mail->IsHTML(true); // envio como HTML se 'true'
$mail->WordWrap = 75; // Definição de quebra de linha
//$mail->CharSet = 'utf-8';
$mail->IsSMTP(); // send via SMTP
$mail->SMTPAuth = true; // 'true' para autenticação
$mail->Mailer = "smtp"; //Usando protocolo SMTP
$mail-> $mail_porta;
if($mail_SMTPSecure!='')
	$mail->SMTPSecure = $mail_SMTPSecure;	// SSL REQUERIDO pelo GMail
$mail->Host = $mail_host; 
$mail->Username = $mail_usuario; 
$mail->Password = $mail_senha; 
$mail->From = $mail_from;
$mail->FromName = "SISUNI - $municipio";


$mail->AddAddress($email_den_principal);
if($email_den_copia!='')
	$mail->AddBcc($email_den_copia);
$mail->AddBcc($mail_from);
//$mail->AddReplyTo("andreklunk@yahoo.com.br");

//$mail->AddAttachmente("/var/tmp/arquivo.ext");
//CONVERTER O NOME PARA FORMATAÇÃO CERTA NO E-MAIL		
	//	$iso88591_1 = utf8_decode($_SESSION[us_nome]);
		$denunciante = iconv('UTF-8', 'ISO-8859-1', $_POST['denunciante']);
		$denunciante = mb_convert_encoding($_POST['denunciante'], 'ISO-8859-1', 'UTF-8');
		$denunciado = iconv('UTF-8', 'ISO-8859-1', $_POST['denunciado']);
		$denunciado = mb_convert_encoding($_POST['denunciado'], 'ISO-8859-1', 'UTF-8');
		$denuncia = iconv('UTF-8', 'ISO-8859-1', $_POST['denuncia']);
		$denuncia  = mb_convert_encoding($_POST['denuncia'], 'ISO-8859-1', 'UTF-8');
date_default_timezone_set('America/Sao_Paulo');
$dt = date('d/m/Y');
$hr = date('H:i:s');
$data = $dt.' '.$hr;		
		
$mail->Subject = "SISUNI - DENÚNCIA";
$corpo = "<font color='000099'>Programa Municipal de Concessão de Bolsas de Estudo </font><br>";
$corpo .= "<b>Denunciante:</b> $denunciante  <br>";
$corpo .= "<b>Denunciado:</b> $denunciado <br>";
$corpo .= "<b>Data/Hora:</b> $data <br><hr>";
$corpo .= "<b>Teor da Denúncia:</b> $denuncia <br>";
$corpo .= "<hr>";
//$mail-> Body = $corpo;
$mail->Body .= nl2br($corpo);
//echo $corpo; break;
if(!$mail->Send()) {
    echo "A mensagem nao foi enviada";
    echo "Erro: " . $mail->ErrorInfo;
    exit;
    } else {
		header('location:index.php?url=msg_denuncia'); 
		exit;
	}
?> 