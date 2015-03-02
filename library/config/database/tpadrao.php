<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tpadrao
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tpadrao extends Database
{
	protected $TableName = "tpadrao";
	protected $Fields = array("ID", "Titulo", "Salario");
	public $ID, $Titulo, $Salario;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tpadrao()
	{
		parent::Database();
	} 	
}

?>