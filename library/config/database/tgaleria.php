<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tgaleria
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tgaleria extends Database
{
	protected $TableName = "tgaleria";
	protected $Fields = array("ID", "Titulo", "Data", "Descricao", "Chave");
	public $ID, $Titulo, $Data, $Descricao, $Chave;
		
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tgaleria()
	{
		parent::Database();
	}
	
	public $ChaveLista = array(
		"programa-de-visita-de-escolas" => "Programa de Visita de Escolas"
	);
	
	/**
     * Carrega um <select>
     * 
     * @access public
     * @param int $GaleriaID (Default: null)
     * @return void
     */
	public static function ddl($GaleriaID = null)
	{
		$oGaleria = new tgaleria();
		$oGaleria->SQLOrder = "ID DESC";
		$oGaleria->LoadSQLAssembled();
		for($c = 0; $c < $oGaleria->NumRows; $c++)
		{
			?>
			<option value="<?=$oGaleria->ID;?>" <?php if($oGaleria->ID == $GaleriaID) { ?> selected="selected" <?php } ?>><?=$oGaleria->Titulo;?></option>
			<?php
			$oGaleria->MoveNext();
		}
	}
	
	/**
	 * Carrega a galeria por chave
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
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateURL()
	{
		return $this->GenerateFriendlyURL($this->Chave, $this->ID, $this->Titulo);
	}
	
}

?>