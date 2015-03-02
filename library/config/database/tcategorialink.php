<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tcategorialink
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tcategorialink extends Database
{
	protected $TableName = "tcategorialink";
	protected $Fields = array("ID", "Titulo", "Ordem");
	public $ID, $Titulo, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tcategorialink()
	{
		parent::Database();
	}
	
	/**
     * Carrega um <select>
     * 
     * @access public
     * @param int $CategoriaLinkID (Default: null)
     * @return void
     */
	public static function ddl($CategoriaLinkID = null)
	{
		$oCategoriaLink = new tcategorialink();
		$oCategoriaLink->SQLOrder = "Ordem DESC";
		$oCategoriaLink->LoadSQLAssembled();
		for($c = 0; $c < $oCategoriaLink->NumRows; $c++)
		{
			?>
			<option value="<?=$oCategoriaLink->ID;?>" <?php if($oCategoriaLink->ID == $CategoriaLinkID) { ?> selected="selected" <?php } ?>><?=$oCategoriaLink->Titulo;?></option>
			<?php
			$oCategoriaLink->MoveNext();
		}
	}
}

?>