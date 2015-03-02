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
		"sessoes-solenes-e-homenagens-proximas-sessoes" => "Sess�es Solenes e Homenagens - Pr�ximas Sess�es",
		"sessoes-solenes-e-homenagens-sessoes-anteriores" => "Sess�es Solenes e Homenagens - Sess�es Anteriores",
		"sessoes-de-3-feira-pauta" => "Sess�es de 3� feira - Pauta",
		"sessoes-de-3-feira-resultado" => "Sess�es de 3� feira - Resultado",
		"sessoes-de-5-feira-pauta" => "Sess�es de 5� feira - Pauta",
		"sessoes-de-5-feira-resultado" => "Sess�es de 5� feira - Resultado",
		"sessoes-extraordinarias-pauta" => "Sess�es Extraordin�rias - Pauta",
		"sessoes-extraordinarias-resultado" => "Sess�es Extraordin�rias - Resultado"
	);
	
	public $Tipo2Lista = array
	(
		"sessoes-solenes-e-homenagens" => array
		(
			"sessoes-solenes-e-homenagens-proximas-sessoes" => "Pr�ximas Sess�es",
			"sessoes-solenes-e-homenagens-sessoes-anteriores" => "Sess�es Anteriores"
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