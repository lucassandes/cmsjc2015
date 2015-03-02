<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tadministradorpermissao
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tadministradorpermissao extends Database
{
	protected $TableName = "tadministradorpermissao";
	protected $Fields = array("ID", "AdministradorID", "PermissaoID");
	public $ID, $AdministradorID, $PermissaoID;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tadministradorpermissao()
	{
		parent::Database();
	}
	
	/**
	 * Remove as permissões por administrador
	 * 
	 * @access public
	 * @param int $AdministradorID
	 * @return void
	 */
	public function DeleteByAdministradorID($AdministradorID)
	{
		$this->ExecuteSQL("DELETE FROM " . $this->TableName . " WHERE AdministradorID = '" . intval($AdministradorID) . "'");
	}
	
	/**
	 * Carrega a permissão por administrador
	 * 
	 * @access public
	 * @param int $AdministradorID
	 * @param int $PermissaoID
	 * @return bool
	 */
	public function LoadByAdministradorIDAndPermissaoID($AdministradorID, $PermissaoID)
	{
		$this->SQLWhere = " AdministradorID = '" . intval($AdministradorID) . "' AND PermissaoID = '" . intval($PermissaoID) . "' ";
		return $this->LoadSQLAssembled();
	}
}

?>