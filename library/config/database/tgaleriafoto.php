<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tgaleriafoto
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tgaleriafoto extends Database
{
	protected $TableName = "tgaleriafoto";
	protected $Fields = array("ID", "GaleriaID", "Imagem", "Legenda", "Ordem");
	public $ID, $GaleriaID, $Imagem, $Legenda, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tgaleriafoto()
	{
		parent::Database();
	}
	
	/**
	 * Carrega as fotos por galeria
	 * 
	 * @access public
	 * @param int $GaleriaID
	 * @return bool
	 */
	public function LoadByGaleriaID($GaleriaID)
	{
		$this->SQLWhere = (($this->SQLWhere) ? $this->SQLWhere . " AND " : "") . "GaleriaID = '" . intval($GaleriaID) . "'";
		$this->SQLOrder = "Ordem ASC";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Remove as fotos por galeria
	 * 
	 * @access public
	 * @param int $GaleriaID
	 * @return void
	 */
	public function RemoveFileByGaleriaID($GaleriaID)
	{
		if($this->LoadByGaleriaID($GaleriaID))
		{
			for($q = 0; $q < $this->NumRows; $q++)
			{
				$this->RemoveFile("../.." . $this->Imagem);
				$this->MoveNext();
			}
		}
	}
}

?>