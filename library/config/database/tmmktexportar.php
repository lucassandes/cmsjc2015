<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktexportar
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktexportar extends Database
{
	protected $TableName = "tmmktexportar";
	protected $Fields = array("ID", "Arquivo", "Total", "DataHora");
	public $ID, $Arquivo, $Total, $DataHora;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktexportar()
	{
		parent::Database();
	}
}

?>