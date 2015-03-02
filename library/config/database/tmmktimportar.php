<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktimportar
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktimportar extends Database
{
	protected $TableName = "tmmktimportar";
	protected $Fields = array("ID", "Arquivo", "Total", "TotalInvalido", "TotalJaCadastrado", "TotalImportado", "DataHora");
	public $ID, $Arquivo, $Total, $TotalInvalido, $TotalJaCadastrado, $TotalImportado, $DataHora;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktimportar()
	{
		parent::Database();
	}
}

?>