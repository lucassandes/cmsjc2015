<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tvereadorexterno
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tvereadorexterno extends Database
{
	protected $TableName = "tvereadorexterno";
	protected $Fields = array("ID", "Titulo", "Descricao", "Ordem");
	public $ID, $Titulo, $Descricao, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tvereadorexterno()
	{
		parent::Database();
	}
}

?>