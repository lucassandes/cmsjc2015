<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmkttemplate
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmkttemplate extends Database
{
	protected $TableName = "tmmkttemplate";
	protected $Fields = array("ID", "Titulo", "Descricao", "Ativo");
	public $ID, $Titulo, $Descricao, $Ativo;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmkttemplate()
	{
		parent::Database();
	}
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateURL()
	{
		return $this->WebURLMMKT . "template/?id=" . $this->ID;
	}
}

?>