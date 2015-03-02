<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tlicitacao
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tlicitacao extends Database
{
	protected $TableName = "tlicitacao";
	protected $Fields = array("ID", "Status", "Modalidade", "Numero", "Objeto", "Questionamento", "Comunicado", "Andamento", "Ordem");
	public $ID, $Status, $Modalidade, $Numero, $Objeto, $Questionamento, $Comunicado, $Andamento, $Ordem;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tlicitacao()
	{
		parent::Database();
	}
	
	public $StatusLista = array
	(
		"licitacoes-em-aberto" => "Licita��es em aberto",
		"licitacoes-em-andamento" => "Licita��es em andamento",
		"licitacoes-concluidas" => "Licita��es concluidas"
	);
	
	public $ModalidadeLista = array
	(
		"pregao" => "Preg�o",
		"convite" => "Convite",
		"tomada-de-precos" => "Tomada de Pre�os",
		"concorrencia-publica" => "Concorr�ncia P�blica",
		"concurso" => "Concurso",
		"leilao" => "Leil�o",
		"chamamento-publico" => "Chamamento P�blico",
		"credenciamento" => "Credenciamento"
	);
}

?>