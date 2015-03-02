<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tlicitacaocadastro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tlicitacaocadastro extends Database
{
	protected $TableName = "tlicitacaocadastro";
	protected $Fields = array("ID", "LicitacaoID", "DataHora", "Nome", "CNPJCPF", "Email", "CEP", "Endereco", "Numero", "Complemento", "Bairro", "Cidade", "Estado", "Telefone", "Fax");
	public $ID, $LicitacaoID, $DataHora, $Nome, $CNPJCPF, $Email, $CEP, $Endereco, $Numero, $Complemento, $Bairro, $Cidade, $Estado, $Telefone, $Fax;
		
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tlicitacaocadastro()
	{
		parent::Database();
	}
	
	/**
	 * Carrega por licitaчуo
	 * 
	 * @access public
	 * @param int $LicitacaoID
	 * @return bool
	 */
	public function LoadByLicitacaoID($LicitacaoID)
	{
		$this->SQLWhere = "LicitacaoID = '" . intval($LicitacaoID) . "'";
		$this->SQLOrder = "ID ASC";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Carrega por licitaчуo
	 * 
	 * @access public
	 * @param int $LicitacaoID
	 * @param string $CNPJCPF
	 * @return bool
	 */
	public function LoadByLicitacaoIDAndCNPJCPF($LicitacaoID, $CNPJCPF)
	{
		$this->SQLWhere = "LicitacaoID = '" . intval($LicitacaoID) . "' AND CNPJCPF = '" . $CNPJCPF . "'";
		return $this->LoadSQLAssembled();
	}
}

?>