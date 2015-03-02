<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tadministradorlog
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tadministradorlog extends Database
{
	protected $TableName = "tadministradorlog";
	protected $Fields = array("ID", "AdministradorID", "DataHora", "IP");
	public $ID, $AdministradorID, $DataHora, $IP;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tadministradorlog()
	{
		parent::Database();
	}
}

?>