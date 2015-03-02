<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tsessao
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tsessao extends Database
{
	protected $TableName = "tsessao";
	protected $Fields = array("ID", "Titulo", "Tipo", "Data", "Hora", "Vereador", "Local", "Arquivo", "Imagem", "GaleriaID", "Descricao");
	public $ID, $Titulo, $Tipo, $Data, $Hora, $Vereador, $Local, $Arquivo, $Imagem, $GaleriaID, $Descricao;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tsessao()
	{
		parent::Database();
	}
		
	public $TipoLista = array
	(
		"sessoes-solenes-e-homenagens-proximas-sessoes" => "Sessões Solenes e Homenagens - Próximas Sessões",
		"sessoes-solenes-e-homenagens-sessoes-anteriores" => "Sessões Solenes e Homenagens - Sessões Anteriores",
		"sessoes-de-3-feira-pauta" => "Sessões de 3ª feira - Pauta",
		"sessoes-de-3-feira-resultado" => "Sessões de 3ª feira - Resultado",
		"sessoes-de-5-feira-pauta" => "Sessões de 5ª feira - Pauta",
		"sessoes-de-5-feira-resultado" => "Sessões de 5ª feira - Resultado",
		"sessoes-extraordinarias-pauta" => "Sessões Extraordinárias - Pauta",
		"sessoes-extraordinarias-resultado" => "Sessões Extraordinárias - Resultado"
	);
	
	public $Tipo2Lista = array
	(
		"sessoes-solenes-e-homenagens" => array
		(
			"sessoes-solenes-e-homenagens-proximas-sessoes" => "Próximas Sessões",
			"sessoes-solenes-e-homenagens-sessoes-anteriores" => "Sessões Anteriores"
		),
		
		"sessoes-de-3-feira" => array
		(
			"sessoes-de-3-feira-pauta" => "Pauta",
			"sessoes-de-3-feira-resultado" => "Resultado"
		),
		
		"sessoes-de-5-feira" => array
		(
			"sessoes-de-5-feira-pauta" => "Pauta",
			"sessoes-de-5-feira-resultado" => "Resultado"
		),
		
		"sessoes-extraordinarias" => array
		(
			"sessoes-extraordinarias-pauta" => "Pauta",
			"sessoes-extraordinarias-resultado" => "Resultado"
		)
	);
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateURL()
	{
		return $this->GenerateFriendlyURL("sessoes-plenarias", $this->ID, $this->Titulo);
	}
}

?>