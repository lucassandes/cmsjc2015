<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela torcamento
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class torcamento extends Database
{
	protected $TableName = "torcamento";
	protected $Fields = array("ID", "Titulo", "Arquivo", "Tipo", "Ordem");
	public $ID, $Titulo, $Arquivo, $Tipo, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function torcamento()
	{
		parent::Database();
	}
	
	public $TipoLista = array
	(
		"balancos-financeiros" => "Balanços financeiros",
		"congressos-e-seminarios" => "Congressos e Seminários"
	);
	
	/**
	 * Carrega os orçamentos por tipo
	 * 
	 * @access public
	 * @param string $Tipo
	 * @return bool
	 */
	public function LoadByTipo($Tipo)
	{
		if(!array_key_exists($Tipo, $this->TipoLista))
		{
			throw new Exception("Tipo inválido.");
		}
		
		$this->SQLWhere = "Tipo = '" . $Tipo . "'";
		$this->SQLOrder = "Ordem DESC";
		return $this->LoadSQLAssembled();
	}
}

?>