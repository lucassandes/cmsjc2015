<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela texploracaomineraria
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class texploracaomineraria extends Database
{
	protected $TableName = "texploracaomineraria";
	protected $Fields = array("ID", "Titulo", "Data", "Tipo", "URL", "GaleriaID", "Descricao");
	public $ID, $Titulo, $Data, $Tipo, $URL, $GaleriaID, $Descricao;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function texploracaomineraria()
	{
		parent::Database();
	}
	
	public $TipoLista = array
	(
		"visitas-e-reunioes" => "Visitas e Reuni�es",
		"divulgacao-do-tema-na-midia" => "Divulga��o do tema na m�dia",
		"proposta-sugestoes-e-criticas"	 => "Propostas, sugest�es e cr�ticas"	
	);
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateURL()
	{
		return $this->GenerateFriendlyURL("processo-de-exploracao-mineraria", $this->ID, $this->Titulo);
	}
}

?>