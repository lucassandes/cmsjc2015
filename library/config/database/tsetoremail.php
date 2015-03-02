<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tsetoremail
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tsetoremail extends Database
{
	protected $TableName = "tsetoremail";
	protected $Fields = array("ID", "SetorID", "Email");
	public $ID, $SetorID, $Email;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tsetoremail()
	{
		parent::Database();
	}
	
	/**
	 * Remove os e-mails por setor
	 * 
	 * @access public
	 * @param int $SetorID
	 * @return void
	 */
	public function DeleteBySetorID($SetorID)
	{
		$this->ExecuteSQL("DELETE FROM " . $this->TableName . " WHERE SetorID = '" . intval($SetorID) . "'");
	}
	
	/**
	 * Carrega os e-mails por setor
	 * 
	 * @access public
	 * @param int $SetorID
	 * @return bool
	 */
	public function LoadBySetorID($SetorID)
	{
		$this->SQLWhere = "SetorID = '" . intval($SetorID) . "'";
		$this->SQLOrder = "ID ASC";
		return $this->LoadSQLAssembled();
	}
}

?>