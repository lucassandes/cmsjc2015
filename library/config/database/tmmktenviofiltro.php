<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktenviofiltro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktenviofiltro extends Database
{
	protected $TableName = "tmmktenviofiltro";
	protected $Fields = array("ID", "EnvioID", "FiltroID");
	public $ID, $EnvioID, $FiltroID;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktenviofiltro()
	{
		parent::Database();
	}
	
	/**
	 * Carrega o filtro por envio
	 * 
	 * @access public
	 * @param int $EnvioID
	 * @param int $FiltroID
	 * @return bool
	 */
	public function LoadByEnvioIDAndFiltroID($EnvioID, $FiltroID)
	{
		$this->SQLWhere = "EnvioID = '" . intval($EnvioID) . "' AND FiltroID = '" . intval($FiltroID) . "'";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Remove os filtros por envio
	 * 
	 * @access public
	 * @param int $EnvioID
	 * @return void
	 */
	public function DeleteByEnvioID($EnvioID)
	{
		$this->ExecuteSQL("DELETE FROM " . $this->TableName . " WHERE EnvioID = '" . intval($EnvioID) . "'");
	}
}

?>