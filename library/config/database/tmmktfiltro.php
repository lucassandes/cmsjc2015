<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktfiltro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktfiltro extends Database
{
	protected $TableName = "tmmktfiltro";
	protected $Fields = array("ID", "Titulo", "Chave");
	public $ID, $Titulo, $Chave;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktfiltro()
	{
		parent::Database();
	}
	
	/**
	 * Carrega filtro por chave
	 * 
	 * @access public
	 * @param string $Chave
	 * @return bool
	 */
	public function LoadByChave($Chave)
	{
		$this->SQLWhere = "Chave = '" . $Chave . "'";
		return $this->LoadSQLAssembled();
	}
}

?>