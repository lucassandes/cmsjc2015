<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tcac
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tcac extends Database
{
	protected $TableName = "tcac";
	protected $Fields = array("ID", "Titulo", "Descricao", "Ordem");
	public $ID, $Titulo, $Descricao, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tcac()
	{
		parent::Database();
	} 
}

?>