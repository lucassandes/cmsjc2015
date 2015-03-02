<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tpermissaotitulo
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tpermissaotitulo extends Database
{
	protected $TableName = "tpermissaotitulo";
	protected $Fields = array("ID", "Titulo", "Ordem");
	public $ID, $Titulo, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tpermissaotitulo()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os títulos das permissões por administrador
	 * 
	 * @access public
	 * @param int $AdministradorID
	 * @return bool
	 */
	public function LoadByAdministradorID($AdministradorID)
	{
		$this->SQLJoin = " INNER JOIN tpermissao ON tpermissao.PermissaoTituloID = tpermissaotitulo.ID 
						   INNER JOIN tadministradorpermissao ON tadministradorpermissao.PermissaoID = tpermissao.ID ";
		$this->SQLWhere = " tadministradorpermissao.AdministradorID = '" . intval($AdministradorID) . "' ";
		$this->SQLGroup = " tpermissaotitulo.ID ";
		$this->SQLOrder = " tpermissaotitulo.Ordem ASC ";
		return $this->LoadSQLAssembled();
	}
}

?>