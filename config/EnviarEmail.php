<?php
/**
 * Created by IntelliJ IDEA.
 * User: isaias
 * Date: 07/07/2017
 * Time: 11:34
 */

namespace Config {

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class EnviarEmail
	{
		private $assunto;
		private $destinatario;
		private $remetente;
		private $mensagem;
		private $destinatarioNome;
		private $remetenteNome;


		public function setRemetenteNome($remetenteNome)
		{
			$this->remetenteNome = $remetenteNome;
		}

		public function getRemetenteNome()
		{
			return $this->remetenteNome;
		}

		public function setDestinatarioNome($destinatarioNome)
		{
			$this->destinatarioNome = $destinatarioNome;
		}

		public function getDestinatarioNome()
		{
			return $this->destinatarioNome;
		}


		public function setMensagem($mensagem)
		{
			$this->mensagem = $mensagem;
		}

		public function getMensagem()
		{
			return $this->mensagem;
		}

		public function setRemetente($remetente)
		{
			$this->remetente = $remetente;
		}

		public function getRemetente()
		{
			return $this->remetente;
		}

		public function setDestinatario($destinatario)
		{
			$this->destinatario = $destinatario;
		}

		public function getDestinatario()
		{
			return $this->destinatario;
		}

		public function setAssunto($assunto)
		{
			$this->assunto = $assunto;
		}

		public function getAssunto()
		{
			return $this->assunto;
		}

		function __construct()
		{

		}

		public function enviarEmail()
		{
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';
			//$mail->SMTPDebug = 3;                               // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = $GLOBALS['SMTP_ENDPOINT'];  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $GLOBALS['SMTP_USERNAME'];                 // SMTP username
			$mail->Password = $GLOBALS['SMTP_PASSWORD'];                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = $GLOBALS['SMTP_PORT'];                                    // TCP port to connect to

			$mail->setFrom($GLOBALS['EMAILCONTATO'], $GLOBALS['DESCRICAOSITE']);
			$mail->addAddress($this->getDestinatario(), $this->getDestinatarioNome());     // Add a recipient
			if ($this->getRemetente()) $mail->addReplyTo($this->getRemetente(), $this->getRemetenteNome());
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = $this->getAssunto();
			$mail->Body = $this->mensagemHTML();
			$mail->AltBody = strip_tags(str_replace("<br>", "\n", $this->getMensagem()));

			if (!$mail->send()) {
				throw new Exception("Falha no envio do e-mail! Tente novamente!" . $mail->ErrorInfo, 1);
			}
		}

        private function mensagemHTML()
        {
            $mensagemSaida = file_get_contents($GLOBALS['CAMINHOPADRAO']."/config/modeloEmail/index.html");
            $mensagemSaida = str_replace("CONTEUDO",$this->getMensagem(),$mensagemSaida);
            /*$botao = "";
            if($this->getBotaoTexto()){
                $botao = file_get_contents($GLOBALS['CAMINHOPADRAO']."/config/EnviarEmailTemplateButton.html");
                $botao = str_replace("LINK",$this->getBotaoLink(),$botao);
                $botao = str_replace("BOTAO",$this->getBotaoTexto(),$botao);
            }
            $mensagemSaida = str_replace("BOTAO",$botao,$mensagemSaida);*/

            return $mensagemSaida;
        }
	}
}