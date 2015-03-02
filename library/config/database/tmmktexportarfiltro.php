<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktexportarfiltro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktexportarfiltro extends Database
{
	protected $TableName = "tmmktexportarfiltro";
	protected $Fields = array("ID", "ExportarID", "FiltroID");
	public $ID, $ExportarID, $FiltroID;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktexportarfiltro()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os filtros por exportaчуo 
	 * 
	 * @access public
	 * @param int $ExportarID
	 * @return bool
	 */
	public function LoadWithFiltroByExportarID($ExportarID)
	{
		$this->SQLField = "*, tmmktfiltro.Titulo AS Filtro";
		$this->SQLJoin = "INNER JOIN tmmktfiltro ON tmmktfiltro.ID = tmmktexportarfiltro.FiltroID";
		$this->SQLWhere = "tmmktexportarfiltro.ExportarID = '" . intval($ExportarID) . "'";
		return $this->LoadSQLAssembled();
	}
}

?>