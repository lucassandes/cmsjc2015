<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tnoticia
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tnoticia extends Database
{
	protected $TableName = "tnoticia";
	protected $Fields = array("ID", "Data", "Hora", "Titulo", "Subtitulo", "Imagem", "GaleriaID", "Video", "Audio", "Descricao", "Destaque", "Destaque2", "ImagemDestaque", "ImagemDestaque2");
	public $ID, $Data, $Hora, $Titulo, $Subtitulo, $Imagem, $GaleriaID, $Video, $Audio, $Descricao, $Destaque, $Destaque2, $ImagemDestaque, $ImagemDestaque2;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tnoticia()
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
		return $this->GenerateFriendlyURL("noticias", $this->ID, $this->Titulo);
	}
	
	/**
	 * Gera URL
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateURLImprimir()
	{
		return $this->GenerateFriendlyURL(array("noticias", "imprimir"), $this->ID, $this->Titulo);
	}
	
	/**
     * Filtra o ID do vídeo do YouTube
     * 
     * @access public
     * @param string $Value
     * @return string
     */
	public static function GetYouTubeID($Value)
	{
		if(!$Value) return false;
		
		$Output = array();
		preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/]{11})/i', $Value, $Output);
		return (($Output[1]) ? $Output[1] : false);
	}
}

?>