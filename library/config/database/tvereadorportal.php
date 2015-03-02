<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tvereadorportal
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tvereadorportal extends Database
{
	protected $TableName = "tvereadorportal";
	protected $Fields = array("ID", "Nome", "Partido", "Salario");
	public $ID, $Nome, $Partido, $Salario;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tvereadorportal()
	{
		parent::Database();
	} 	
}

?>