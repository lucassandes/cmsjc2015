<?php

include_once(dirname(__FILE__) . "/util.php");

/**
 * Classe utilizada para uploads
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Upload extends Util
{
	public $Name = null;
	public $Size = null;
	public $Type = null;
	public $Temp = null;
	public $Error = null;
	public $Extension = null;
	public $Message = null;
	
    /**
     * Construtor da classe
     * 
     * @access public
     * @param $_FILES $File
     * @param int $Position (Defautl: -1)
     * @return void
     */
    public function Upload($File, $Position = -1)
    {
    	parent::Util();
    	
    	$this->Name = $File["name"];
	    $this->Size = $File["size"];
	    $this->Type = $File["type"];
	    $this->Temp = $File["tmp_name"];
	    $this->Error = $File["error"];
	    
	    //caso for um array de $_FILES
    	if($Position >= 0)
    	{
    		$this->Name = $this->Name[$Position];
		    $this->Size = $this->Size[$Position];
		    $this->Type = $this->Type[$Position];
		    $this->Temp = $this->Temp[$Position];
		    $this->Error = $this->Error[$Position];
    	}
    	
    	$this->Extension = $this->GetExtension($this->Name);
    }
    
    /**
     * Valida upload
     * 
     * @access public
     * @param bool $Required (Default: false)
     * @param array $Extension (Default: array())
     * @param int $ImageSize (Default: 2097152) 2MB
     * @param array $ImageExtension (Default: array("jpg", "jpeg", "gif", "png"))
     * @return bool
     */
    public function Validate($Required = false, $Extension = array(), $ImageSize = 2097152, $ImageExtension = array("jpg", "jpeg", "gif", "png"))
    {
    	//Verifica se é obrigatório e se o arquivo temporário existe
    	if(!$this->Temp && !$Required)
    	{
    		return true;
    	}
    	
    	//Verifica o status do arquivo
        if($this->Error != UPLOAD_ERR_OK)
        {
        	$this->Message = $this->UploadMessage();
            return false;
        }
        
        //Verifica o tamanho da imagem
        if($this->Size > $ImageSize && in_array($this->Extension, $ImageExtension))
        {
        	$this->Message = "Imagem muito grande.";
        	return false;
        }
        
        //Verifica a extensão do arquivo
        if(count($Extension) > 0)
    	{
    		return $this->ValidateExtension($Extension);
		}
		else
		{
			return true;
		}
    }
    
    /**
     * Valida arquivo temporário
     * 
     * @access public
     * @return bool
     */
    public function ValidateTemp()
    {
        return ($this->Temp);
    }

    /**
     * Valida a extensão do arquivo
     * 
     * @access public
     * @param array $Extension (Default: array())
     * @return bool
     */
    public function ValidateExtension($Extension = array())
    {
        if (!in_array($this->Extension, $Extension))
        {
            $this->Message = "Arquivo inválido! Extensões permitidas: (*." . implode(", *.", $Extension) . ")";
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Executa upload
     * 
     * @access public
     * @param string $DirName
     * @param string $File (Default: null)
     * @param bool $SaveName (Default: false)
     * @return string
     */
    public function Save($DirName, $File = null, $SaveName = false)
    {
    	//Verifica Upload
    	if(!$this->Validate() || !$this->ValidateTemp())
    	{
    		if($File)
    		{
    			return $File;
    		}
    		
    		return false;
    	}
    	
    	//remove o arquivo
    	$this->RemoveFile($this->DirectoryRoot . $File);
		    	
    	//Gera caminho do arquivo
    	$File = $this->GenerateFilePath($DirName, (($SaveName) ? $this->Name : $SaveName), $this->Extension);
    	
    	//Executa o Upload
    	move_uploaded_file($this->Temp, $File);
    	
    	//Permissões do arquivo
        if(is_file($File))
        {
            $Mask = umask(0);
            chmod($File, 0777);
            umask($Mask);
        }
        
        return $this->ParseFilePath($File);
    }

	/**
     * Mensagem de erro
     * 
     * @access public
     * @return string
     */
    protected function UploadMessage()
    {
        switch ($this->Error)
        {
            case UPLOAD_ERR_INI_SIZE: return "Arquivo muito grande! Tamanho máximo permitido " . intval(ini_get("upload_max_filesize")) . " MB"; break;
            case UPLOAD_ERR_FORM_SIZE: return "Arquivo muito grande! Tamanho máximo permitido " . intval(ini_get("upload_max_filesize")) . " MB"; break;
            case UPLOAD_ERR_PARTIAL: return "Arquivo inválido! Falha ao carregar arquivo!"; break;
            case UPLOAD_ERR_NO_FILE: return "Arquivo inválido! Nenhum arquivo foi selecionado!"; break;
            case UPLOAD_ERR_NO_TMP_DIR: return "Arquivo inválido! Falha ao salvar arquivo!"; break;
            case UPLOAD_ERR_CANT_WRITE: return "Arquivo inválido! Falha ao salvar arquivo!"; break;
            case UPLOAD_ERR_EXTENSION: return "Arquivo inválido! Falha ao salvar arquivo!"; break;
            default: return "Arquivo desconhecido!"; break;
        }
    }
}

?>