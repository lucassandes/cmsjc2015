<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tlink
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tlink extends Database
{
	protected $TableName = "tlink";
	protected $Fields = array("ID", "CategoriaLinkID", "Titulo", "URL", "Ordem");
	public $ID, $CategoriaLinkID, $Titulo, $URL, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tlink()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os links por categoria
	 * 
	 * @access public
	 * @param int $CategoriaLinkID
	 * @return bool
	 */
	public function LoadByCategoriaLinkID($CategoriaLinkID)
	{
		$this->SQLWhere = "CategoriaLinkID = '" . intval($CategoriaLinkID) . "'";
		$this->SQLOrder = "Ordem DESC";
		return $this->LoadSQLAssembled();
	}
}

?>