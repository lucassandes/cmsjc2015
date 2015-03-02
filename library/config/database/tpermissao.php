<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tpermissao
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tpermissao extends Database
{
	protected $TableName = "tpermissao";
	protected $Fields = array("ID", "PermissaoTituloID", "Titulo", "Chave", "Listar", "Ordem");
	public $ID, $PermissaoTituloID, $Titulo, $Chave, $Listar, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tpermissao()
	{
		parent::Database();
	}
	
	/**
	 * Carrega as permissões por titulo e administrador
	 * 
	 * @access public
	 * @param int $AdministradorID
	 * @param int $PermissaoTituloID
	 * @return bool
	 */
	public function LoadByAdministradorIDAndPermissaoTituloID($AdministradorID, $PermissaoTituloID)
	{
		$this->SQLJoin = " INNER JOIN tadministradorpermissao ON tadministradorpermissao.PermissaoID = tpermissao.ID ";
		$this->SQLWhere = " tadministradorpermissao.AdministradorID = '" . intval($AdministradorID) . "' AND tpermissao.PermissaoTituloID = '" . intval($PermissaoTituloID) . "' ";
		$this->SQLGroup = " tpermissao.ID ";
		$this->SQLOrder = " tpermissao.Ordem ASC ";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Carrega a permissão pela chave por administrador
	 * 
	 * @access public
	 * @param int $AdministradorID
	 * @param string $Chave
	 * @return bool
	 */
	public function LoadByAdministradorIDAndChave($AdministradorID, $Chave)
	{
		$this->SQLJoin = " INNER JOIN tadministradorpermissao ON tadministradorpermissao.PermissaoID = tpermissao.ID ";
		$this->SQLWhere = " tadministradorpermissao.AdministradorID = '" . intval($AdministradorID) . "' AND tpermissao.Chave = '" . $Chave . "' ";
		return $this->LoadSQLAssembled();
	}
		
	/**
	 * Carrega as permissões por titulo e listar
	 * 
	 * @access public
	 * @param int $PermissaoTituloID
	 * @param int $Listar (Default: 1)
	 * @return bool
	 */
	public function LoadByPermissaoTituloIDAndListar($PermissaoTituloID, $Listar = 1)
	{
		$this->SQLWhere = " PermissaoTituloID = '" . intval($PermissaoTituloID) . "' AND Listar = '" . intval($Listar) . "' ";
		$this->SQLOrder = " Ordem ASC ";
		return $this->LoadSQLAssembled();
	}
}

?>