<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tevento
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tevento extends Database
{
	protected $TableName = "tevento";
	protected $Fields = array("ID", "Titulo", "Data", "Hora", "Local", "Descricao", "AudienciaPublica");
	public $ID, $Titulo, $Data, $Hora, $Local, $Descricao, $AudienciaPublica;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tevento()
	{
		parent::Database();
	}
	
	/**
	 * Carrega por data
	 * 
	 * @access public
	 * @param int $Dia
	 * @param int $Mes
	 * @param int $Ano
	 * @return bool
	 */
    public function LoadByDiaMesAno($Dia, $Mes, $Ano)
    {
    	$this->SQLWhere = "DAY(Data) = '" . intval($Dia) . "' AND MONTH(Data) = '" . intval($Mes) . "' AND YEAR(Data) = '" . intval($Ano) . "'";
  		$this->SQLOrder = "Data DESC, Titulo ASC";
  		return $this->LoadSQLAssembled();
    }
}

?>