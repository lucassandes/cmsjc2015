<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tdownload
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tdownload extends Database
{
	protected $TableName = "tdownload";
	protected $Fields = array("ID", "CategoriaDownloadID", "Titulo", "Arquivo", "Imagem", "Ordem");
	public $ID, $CategoriaDownloadID, $Titulo, $Arquivo, $Imagem, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tdownload()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os downloads por categoria
	 * 
	 * @access public
	 * @param int $CategoriaDownloadID
	 * @return bool
	 */
	public function LoadByCategoriaDownloadID($CategoriaDownloadID)
	{
		$this->SQLWhere = "CategoriaDownloadID = '" . intval($CategoriaDownloadID) . "'";
		$this->SQLOrder = "Ordem DESC";
		return $this->LoadSQLAssembled();
	}
}

?>