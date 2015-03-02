<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktretorno
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktretorno extends Database
{
	protected $TableName = "tmmktretorno";
	protected $Fields = array("ID", "EnvioID", "Email", "Campanha", "Quantidade");
	public $ID, $EnvioID, $Email, $Campanha, $Quantidade;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktretorno()
	{
		parent::Database();
	}
	
	/**
	 * Carrega retorno por envio
	 * 
	 * @access public
	 * @param int $EnvioID
	 * @return bool
	 */
	public function LoadByEnvioID($EnvioID)
	{
		$this->SQLWhere = "EnvioID = '" . intval($EnvioID) . "'";
		$this->SQLOrder = "ID ASC";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Carrega retorno
	 * 
	 * @access public
	 * @param int $EnvioID
	 * @param string $Campanha
	 * @return bool
	 */
	public function LoadByEnvioIDAndCampanha($EnvioID, $Campanha)
	{
		$this->SQLWhere = "EnvioID = '" . intval($EnvioID) . "' AND Campanha = '" . $Campanha . "'";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Carrega retorno
	 * 
	 * @access public
	 * @param int $EnvioID
	 * @param string $Email
	 * @param string $Campanha
	 * @return bool
	 */
	public function LoadByEnvioIDAndEmailAndCampanha($EnvioID, $Email, $Campanha)
	{
		$this->SQLWhere = "EnvioID = '" . intval($EnvioID) . "' AND Email = '" . $Email . "' AND Campanha = '" . $Campanha . "'";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @param int $EnvioID
	 * @param string $Email
	 * @param string $Campanha
	 * @param string $URL
	 * @return string
	 */
	public function GenerateURL($EnvioID, $Email, $Campanha, $URL)
	{
		return $this->WebURLCommon . "mmkt/clique.php?envioid=" . $EnvioID . "&email=" . $Email . "&campanha=" . urlencode($Campanha) . "&url=" . urlencode($URL);
	}
}

?>