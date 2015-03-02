<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tcategoriadownload
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tcategoriadownload extends Database
{
	protected $TableName = "tcategoriadownload";
	protected $Fields = array("ID", "Titulo", "Ordem");
	public $ID, $Titulo, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tcategoriadownload()
	{
		parent::Database();
	}
	
	/**
     * Carrega um <select>
     * 
     * @access public
     * @param int $CategoriaDownloadID (Default: null)
     * @return void
     */
	public static function ddl($CategoriaDownloadID = null)
	{
		$oCategoriaDownload = new tcategoriadownload();
		$oCategoriaDownload->SQLOrder = "Ordem DESC";
		$oCategoriaDownload->LoadSQLAssembled();
		for($c = 0; $c < $oCategoriaDownload->NumRows; $c++)
		{
			?>
			<option value="<?=$oCategoriaDownload->ID;?>" <?php if($oCategoriaDownload->ID == $CategoriaDownloadID) { ?> selected="selected" <?php } ?>><?=$oCategoriaDownload->Titulo;?></option>
			<?php
			$oCategoriaDownload->MoveNext();
		}
	}
}

?>