<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela timpostoderenda
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class timpostoderenda extends Database
{
	protected $TableName = "timpostoderenda";
	protected $Fields = array("ID", "SalarioInicial", "SalarioFinal", "Percentual");
	public $ID, $SalarioInicial, $SalarioFinal, $Percentual;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function timpostoderenda()
	{
		parent::Database();
	}
	
}

?>