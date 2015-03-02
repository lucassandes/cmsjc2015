<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktemail
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktemail extends Database
{
	protected $TableName = "tmmktemail";
	protected $Fields = array("ID", "Nome", "Email", "Dia", "Mes", "Ativo", "DataHora");
	public $ID, $Nome, $Email, $Dia, $Mes, $Ativo, $DataHora;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktemail()
	{
		parent::Database();
	}
	
	const CREATE_SUCCESS = 1;
	const CREATE_ERROR = 0;
	const CREATE_INVALID = 2;
	
	/**
	 * Carrega pelo e-mail
	 * 
	 * @access public
	 * @param string $Email
	 * @return bool
	 */
	public function LoadByEmail($Email)
	{
		$this->SQLWhere = " Email = '" . $Email . "' ";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Cria e-mail
	 * 
	 * @access public
	 * @param string $Email
	 * @param string $Nome (Default: null)
	 * @param string $Chave (Default: null)
	 * @param int $FiltroID (Default: null)
	 * @param int $Dia (Default: null)
	 * @param int $Mes (Default: null)
	 * @return cont (CREATE_SUCCESS | CREATE_ERROR | CREATE_INVALID)
	 */
	public static function Create($Email, $Nome = null, $Chave = null, $FiltroID = null, $Dia = null, $Mes = null)
	{
		$oEmail = new tmmktemail();
		
		//Valida e-mail
		if(!preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", $Email))
		{
			return self::CREATE_INVALID;
		}
		
		//Verifica filtro
		include_once(dirname(__FILE__) . "/tmmktfiltro.php");
		
		$oFiltro = new tmmktfiltro();
		if($FiltroID)
		{
			$oFiltro->LoadByPrimaryKey($FiltroID);
		}
		else
		{
			$oFiltro->LoadByChave($Chave);
		}
		if($oFiltro->NumRows < 1)
		{
			throw new Exception("Filtro inválido.");
		}
		
		//Verifica e-mail cadastrado
		if(!$oEmail->LoadByEmail($Email))
		{
			$oEmail->AddNew();
			$oEmail->Nome = $Nome;
			$oEmail->Email = $Email;
			$oEmail->Dia = intval($Dia);
			$oEmail->Mes = intval($Mes);
			$oEmail->Ativo = 1;
			$oEmail->DataHora = date("Y-m-d H:i:s");
			$oEmail->Save();
		}
		
		//Verifica se o e-mail já está cadastrado nessse filtro
		include_once(dirname(__FILE__) . "/tmmktemailfiltro.php");
		
		$oEmailFiltro = new tmmktemailfiltro();
		if(!$oEmailFiltro->LoadByEmailIDAndFiltroID($oEmail->ID, $oFiltro->ID))
		{
			$oEmailFiltro->AddNew();
			$oEmailFiltro->EmailID = $oEmail->ID;
			$oEmailFiltro->FiltroID = $oFiltro->ID;
			$oEmailFiltro->Save();
			
			return self::CREATE_SUCCESS;
		}
		
		return self::CREATE_ERROR;
	}
}

?>