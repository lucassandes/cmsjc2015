<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tcargo
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tcargo extends Database
{
	protected $TableName = "tcargo";
	protected $Fields = array("ID", "Titulo", "PadraoID", "Vinculo");
	public $ID, $Titulo, $Padrao, $Vinculo;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tcargo()
	{
		parent::Database();
	} 
	
	/**
     * Função que carrega um <select> com os cargos por vinculo
     *
     * @access public
     * @param string $Vinculo
     * @param int $Cargo (Default: null)
     * @return void
     */
    public static function ddl($Vinculo, $Cargo = null)
    {
		$oCargo = new tcargo();      
		$oCargo->SQLOrder = " Titulo ASC"; 
		$oCargo->SQLWhere = " Vinculo = '" . $Vinculo . "'";   
		$oCargo->LoadSQLAssembled();     
		for($c = 0; $c < $oCargo->NumRows; $c++)
		{
			?>
			<option value="<?=$oCargo->ID;?>" <?=(($Cargo == $oCargo->ID) ? 'selected="selected"' : '')?>><?=$oCargo->Titulo;?></option>
			<?php
			$oCargo->MoveNext();
		}
    }
}

?>