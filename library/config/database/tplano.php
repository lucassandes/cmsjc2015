<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tplano
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tplano extends Database
{
	protected $TableName = "tplano";
	protected $Fields = array("ID", "PeriodoInicial", "PeriodoFinal", "Percentual");
	public $ID, $PeriodoInicial, $PeriodoFinal, $Percentual;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tplano()
	{
		parent::Database();
	}
	
}

?>