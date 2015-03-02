<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tpartido
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tpartido extends Database
{
	protected $TableName = "tpartido";
	protected $Fields = array("ID", "Titulo", "Sigla", "Ordem");
	public $ID, $Titulo, $Sigla, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tpartido()
	{
		parent::Database();
	}
	
	/**
     * Carrega um <select>
     * 
     * @access public
     * @param int $PartidoID (Default: null)
     * @return void
     */
	public static function ddl($PartidoID = null)
	{
		$oPartido = new tpartido();
		$oPartido->SQLOrder = "Ordem DESC";
		$oPartido->LoadSQLAssembled();
		for($c = 0; $c < $oPartido->NumRows; $c++)
		{
			?>
			<option value="<?=$oPartido->ID;?>" <?php if($oPartido->ID == $PartidoID) { ?> selected="selected" <?php } ?>><?=$oPartido->Sigla;?></option>
			<?php
			$oPartido->MoveNext();
		}
	}
}

?>