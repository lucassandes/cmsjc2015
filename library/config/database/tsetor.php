<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tsetor
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tsetor extends Database
{
	protected $TableName = "tsetor";
	protected $Fields = array("ID", "Titulo", "Descricao", "Telefones");
	public $ID, $Titulo, $Descricao, $Telefones;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tsetor()
	{
		parent::Database();
	}
}

?>