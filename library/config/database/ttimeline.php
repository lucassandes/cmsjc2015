<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela ttimeline
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class ttimeline extends Database
{
	protected $TableName = "ttimeline";
	protected $Fields = array("ID", "Titulo", "Periodo", "Vereadores", "Suplentes", "Observacao");
	public $ID, $Titulo, $Periodo, $Vereadores, $Suplentes, $Observacao;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function ttimeline()
	{
		parent::Database();
	}
}

?>