<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tparametro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tparametro extends Database
{
	protected $TableName = "tparametro";
	protected $Fields = array("ID", "Chave", "Valor");
	public $ID, $Chave, $Valor;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tparametro()
	{
		parent::Database();
	}
	
	/**
	 * Carrega todos os objetos
	 * 
	 * @access public
	 * @return array
	 */
	public static function Load()
	{
		$ar = array();
		$oParametro = new tparametro();
		$oParametro->LoadSQLAssembled();
		for($c = 0; $c < $oParametro->NumRows; $c++)
		{
			$ar[$oParametro->Chave] = $oParametro->Valor;
			$oParametro->MoveNext();
		}
		return $ar;
	}
	
	/**
	 * Carrega por chave
	 * 
	 * @access public
	 * @param string $Chave
	 * @return bool
	 */
	public function LoadByChave($Chave)
	{
		$this->SQLWhere = " Chave = '" . $Chave . "' ";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Retorna o valor por chave
	 * 
	 * @access public
	 * @param string $Chave
	 * @return string
	 */
	public static function Get($Chave)
	{
		$oParametro = new tparametro();
		if($oParametro->LoadByChave($Chave))
		{
			return $oParametro->Valor;
		}
		return "";
	}
	
	/**
	 * Define o valor por chave
	 * 
	 * @access public
	 * @param string $Chave
	 * @param string $Valor
	 * @return void
	 */
	public static function Set($Chave, $Valor)
	{
		$oParametro = new tparametro();
		if(!$oParametro->LoadByChave($Chave))
		{
			$oParametro->AddNew();
			$oParametro->Chave = $Chave;
		}
		$oParametro->Valor = $Valor;
		$oParametro->Save();
	}
}

?>