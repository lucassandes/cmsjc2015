<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktimportarfiltro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktimportarfiltro extends Database
{
	protected $TableName = "tmmktimportarfiltro";
	protected $Fields = array("ID", "ImportarID", "FiltroID");
	public $ID, $ImportarID, $FiltroID;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktimportarfiltro()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os filtros por importaηγo 
	 * 
	 * @access public
	 * @param int $ImportarID
	 * @return bool
	 */
	public function LoadWithFiltroByImportarID($ImportarID)
	{
		$this->SQLField = "*, tmmktfiltro.Titulo AS Filtro";
		$this->SQLJoin = "INNER JOIN tmmktfiltro ON tmmktfiltro.ID = tmmktimportarfiltro.FiltroID";
		$this->SQLWhere = "tmmktimportarfiltro.ImportarID = '" . intval($ImportarID) . "'";
		return $this->LoadSQLAssembled();
	}
}

?>