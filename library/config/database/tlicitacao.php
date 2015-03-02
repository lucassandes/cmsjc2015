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
		"licitacoes-em-aberto" => "Licitações em aberto",
		"licitacoes-em-andamento" => "Licitações em andamento",
		"licitacoes-concluidas" => "Licitações concluidas"
	);
	
	public $ModalidadeLista = array
	(
		"pregao" => "Pregão",
		"convite" => "Convite",
		"tomada-de-precos" => "Tomada de Preços",
		"concorrencia-publica" => "Concorrência Pública",
		"concurso" => "Concurso",
		"leilao" => "Leilão",
		"chamamento-publico" => "Chamamento Público",
		"credenciamento" => "Credenciamento"
	);
}

?>