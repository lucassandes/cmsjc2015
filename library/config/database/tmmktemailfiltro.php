<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktemailfiltro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktemailfiltro extends Database
{
	protected $TableName = "tmmktemailfiltro";
	protected $Fields = array("ID", "EmailID", "FiltroID");
	public $ID, $EmailID, $FiltroID;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktemailfiltro()
	{
		parent::Database();
	}
	
	/**
	 * Carrega o filtro por e-mail
	 * 
	 * @access public
	 * @param int $EmailID
	 * @param int $FiltroID
	 * @return bool
	 */
	public function LoadByEmailIDAndFiltroID($EmailID, $FiltroID)
	{
		$this->SQLWhere = "EmailID = '" . intval($EmailID) . "' AND FiltroID = '" . intval($FiltroID) . "'";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Remove os filtros por e-mail
	 * 
	 * @access public
	 * @param int $EmailID
	 * @return void
	 */
	public function DeleteByEmailID($EmailID)
	{
		$this->ExecuteSQL("DELETE FROM " . $this->TableName . " WHERE EmailID = '" . intval($EmailID) . "'");
	}
}

?>