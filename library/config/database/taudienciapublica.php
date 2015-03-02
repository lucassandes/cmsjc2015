<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela taudienciapublica
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class taudienciapublica extends Database
{
	protected $TableName = "taudienciapublica";
	protected $Fields = array("ID", "Titulo", "Data", "Imagem", "Arquivo", "GaleriaID", "Descricao");
	public $ID, $Titulo, $Data, $Imagem, $Arquivo, $GaleriaID, $Descricao;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function taudienciapublica()
	{
		parent::Database();
	}
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateURL()
	{
		return $this->GenerateFriendlyURL("audiencias-publicas", $this->ID, $this->Titulo);
	}
}

?>