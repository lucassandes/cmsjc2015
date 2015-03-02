<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tcomissao
 *
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tcomissao extends Database
{
	protected $TableName = "tcomissao";
	protected $Fields = array("ID", "Titulo", "PresidenteID", "PresidenteSuplenteID", "RevisorID", "RevisorSuplenteID", "Relator1ID", "Relator1SuplenteID", "Relator2ID", "Relator2SuplenteID", "Relator3ID", "Relator3SuplenteID", "Tipo", "Ordem");
	public $ID, $Titulo, $PresidenteID, $PresidenteSuplenteID, $RevisorID, $RevisorSuplenteID, $Relator1ID, $Relator1SuplenteID, $Relator2ID, $Relator2SuplenteID, $Relator3ID, $Relator3SuplenteID, $Tipo, $Ordem;

	/**
     * Construtor da classe
     *
     * @access public
     * @return void
     */
	public function tcomissao()
	{
		parent::Database();
	}

	public $TipoLista = array
	(
		"comissoes-permanentes" => "Comiss�es Permanentes",
		"comissoes-temporarias" => "Comiss�es Tempor�rias",
		"comissoes-encerradas" => "Comiss�es Encerradas"
	);

	/**
	 * Carrega os or�amentos por tipo
	 *
	 * @access public
	 * @param string $Tipo
	 * @return bool
	 */
	public function LoadByTipo($Tipo)
	{
		if(!array_key_exists($Tipo, $this->TipoLista))
		{
			throw new Exception("Tipo inv�lido.");
		}

		$this->SQLWhere = "Tipo = '" . $Tipo . "'";
		$this->SQLOrder = "Ordem DESC";
		return $this->LoadSQLAssembled();
	}
}

?>