<?php

include_once(dirname(dirname(__FILE__)) . "/plugins/phpmailer/class.phpmailer.php");
include_once(dirname(__FILE__) . "/database/tparametro.php");

/**
 * Classe utilizada para definir configurações gerais do envio de e-mail
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class SendMail extends PHPMailer
{
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function SendMail()
	{
		/*
		$this->IsSMTP();
		$this->Host = "";
		$this->SMTPAuth = true;
		$this->Username = "";
		$this->Password = "";
		*/
  	}
}

?>