<?php

/**
 * Classe utilizada para armazenar configura��es b�sicas
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Config
{
	public $WebTitle = null;
	public $WebURL = null;
	public $WebURLAdmin = null;
	public $WebURLCommon = null;
	public $WebURLMMKT = null;
	
	public $DirectoryRoot = null;
	public $DirectoryUserFilesName = null;
	public $DirectoryUserFilesPath = null;
	public $DirectoryUserFilesEditorName = null;
	public $DirectoryUserFilesEditorPath = null;
	public $DirectoryCommonName = null;
	public $DirectoryCommonPath = null;
	public $DirectoryMMKTName = null;
	public $DirectoryMMKTPath = null;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function Config()
	{
		//url
		$this->WebTitle = "Câmara Municipal de São José dos Campos";
		//$this->WebURL = "http://camarasjc2.hospedagemdesites.ws/clicknow/";
       // $this->WebURL = "http://camarasjc2.hospedagemdesites.ws/2015/";
        $this->WebURL = "http://localhost/cmsjc2015/";

        //$this->WebURL = "http://camarasjc.sp.tempsite.ws/clicknow/";
		//$this->WebURL = "http://192.168.0.80/camarasjc.sp.gov.br/";
		//$this->WebURLAdmin = $this->WebURL . "admin/";
        $this->WebURLAdmin = "http://camarasjc2.hospedagemdesites.ws/clicknow/admin/";
		$this->WebURLCommon = $this->WebURL . "common/";
		$this->WebURLMMKT = $this->WebURLCommon . "mmkt/";
		
		//dir
		//$this->DirectoryRoot = str_replace("\\", "/", dirname(dirname(dirname(__FILE__))));
        //$this->DirectoryRoot = str_replace("\\", "/", realpath('/clicknow/'));
        $this->DirectoryRoot = str_replace("\\", "/", dirname(dirname(dirname(__FILE__))));
        //$this->DirectoryRoot = str_replace('clicknow2', 'clicknow',  $this->DirectoryRoot);
        //$this->DirectoryRoot = "http://camarasjc2.hospedagemdesites.ws/clicknow";
        $this->DirectoryUserFilesName = "/arquivo/";


		$this->DirectoryUserFilesPath = $this->DirectoryRoot . $this->DirectoryUserFilesName;

        //echo $this->DirectoryUserFilesPath ;
        $this->DirectoryUserFilesEditorName = $this->DirectoryUserFilesName . "editor/";
		$this->DirectoryUserFilesEditorPath = $this->DirectoryRoot . $this->DirectoryUserFilesEditorName;
		$this->DirectoryCommonName = "/common/";
		$this->DirectoryCommonPath = $this->DirectoryRoot . $this->DirectoryCommonName;
		$this->DirectoryMMKTName = $this->DirectoryCommonName . "mmkt/";
		$this->DirectoryMMKTPath = $this->DirectoryRoot . $this->DirectoryMMKTName;
	}
}

?>