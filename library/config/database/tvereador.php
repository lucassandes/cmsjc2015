<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tvereador
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tvereador extends Database
{
	protected $TableName = "tvereador";
	protected $Fields = array("ID", "PartidoID", "Nome", "Informacao", "Email", "Telefone", "LocalTrabalho", "Imagem", "Descricao", "Ordem", "LiderPartidario", "LiderGoverno");
	public $ID, $PartidoID, $Nome, $Informacao, $Email, $Telefone, $LocalTrabalho, $Imagem, $Descricao, $Ordem, $LiderPartidario, $LiderGoverno;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tvereador()
	{
		parent::Database();
	}
	
	/**
     * Carrega um <select>
     * 
     * @access public
     * @param int $VereadorID (Default: null)
     * @return void
     */
	public static function ddl($VereadorID = null)
	{
		$oVereador = new tvereador();
		$oVereador->SQLOrder = "Ordem DESC";
		$oVereador->LoadSQLAssembled();
		for($c = 0; $c < $oVereador->NumRows; $c++)
		{
			?>
			<option value="<?=$oVereador->ID;?>" <?php if($oVereador->ID == $VereadorID) { ?> selected="selected" <?php } ?>><?=$oVereador->Nome;?></option>
			<?php
			$oVereador->MoveNext();
		}
	}
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateURL()
	{
		return $this->GenerateFriendlyURL("vereadores", $this->ID, $this->Nome);
	}
	
	/**
	 * Carrega os vereadores por partido
	 * 
	 * @access public
	 * @param int $PartidoID
	 * @return bool
	 */
	public function LoadByPartidoID($PartidoID)
	{
		$this->SQLWhere = "PartidoID = '" . intval($PartidoID) . "'";
		$this->SQLOrder = "Nome ASC";
		return $this->LoadSQLAssembled();
	}
	
}

?>