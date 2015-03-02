<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmesadiretora
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmesadiretora extends Database
{
	protected $TableName = "tmesadiretora";
	protected $Fields = array("ID", "Titulo", "PresidenteID", "VicePresidente1ID", "VicePresidente2ID", "Secretario1ID", "Secretario2ID", "Descricao");
	public $ID, $Titulo, $PresidenteID, $VicePresidente1ID, $VicePresidente2ID, $Secretario1ID, $Secretario2ID, $Descricao;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmesadiretora()
	{
		parent::Database();
	}
}

?>