<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tadministrador
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tadministrador extends Database
{
	protected $TableName = "tadministrador";
	protected $Fields = array("ID", "Nome", "Email", "Login", "Senha", "Ativo");
	public $ID, $Nome, $Email, $Login, $Senha, $Ativo;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tadministrador()
	{
		parent::Database();
	}
	
	private $SessionName = "Administrador";
	
	/**
	 * Autenticaчуo
	 * 
	 * @access public
	 * @param string $Login
	 * @param string $Senha
	 * @return bool
	 */
	public function Authentication($Login, $Senha)
	{
		if($this->LoadSQL("call AdministradorAuthentication('" . $Login . "', '" . md5($Senha) . "', '" . $_SERVER["REMOTE_ADDR"] . "')"))
		{
			$_SESSION[$this->SessionName] = $this->ID;
			return true;
		}
		
		return false;
	}
	
	/**
	 * Verifica autenticaчуo
	 * 
	 * @access public
	 * @return bool
	 */
	public function CheckAuthentication()
	{
		$this->SQLField = "*, AdministradorLastAccess(ID) AS UltimoAcesso";
		return ($this->LoadByPrimaryKey($_SESSION[$this->SessionName]) && $this->Ativo);
	}
	
	/**
	 * Logout
	 * 
	 * @access public
	 * @return void
	 */
	public function Logout()
	{
		session_unregister($this->SessionName);
		//session_destroy();
	}
	
	/**
	 * Carrega o administrador pelo login
	 * 
	 * @access public
	 * @param string $Login
	 * @return bool
	 */
	public function LoadByLogin($Login)
	{
		$this->SQLWhere = " Login = '" . $Login . "' ";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Carrega o administrador pelo login e ativo
	 * 
	 * @access public
	 * @param string $Login
	 * @param int $Ativo (Default: 1)
	 * @return bool
	 */
	public function LoadByLoginAndAtivo($Login, $Ativo = 1)
	{
		$this->SQLWhere = " Login = '" . $Login . "' AND Ativo = '" . intval($Ativo) . "' ";
		return $this->LoadSQLAssembled();
	}
}

?>