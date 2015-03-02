<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tmmktenvio
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tmmktenvio extends Database
{
	protected $TableName = "tmmktenvio";
	protected $Fields = array("ID", "Nome", "Email", "Assunto", "Modelo", "Enviado", "DataHora", "DataHoraEnviado", "Total", "TotalEnviado", "TotalErro");
	public $ID, $Nome, $Email, $Assunto, $Modelo, $Enviado, $DataHora, $DataHoraEnviado, $Total, $TotalEnviado, $TotalErro;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tmmktenvio()
	{
		parent::Database();
	}
	
	/**
	 * Busca modelos disponíveis para envio
	 * 
	 * @access public
	 * @return array
	 */
	public function GetModelo()
	{
		$ar = array();
        if ($handle = opendir($this->DirectoryMMKTPath))
        {
            chmod($this->DirectoryMMKTPath, 0777);
            while (false !== ($file = readdir($handle)))
            {
                if (is_dir($this->DirectoryMMKTPath . "/" . $file) && $file != "." && $file != "..")
                {
                    array_push($ar, $file);
                }
            }
            closedir($handle);
        }
        return $ar;
	}
}

?>