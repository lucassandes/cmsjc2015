<?php

/**
 * Classe utilizada para criar páginas mestres
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class MasterPage
{
    protected $Template = null;
    protected $Title = null;
    protected $Content = array();
    protected $Parameter = array();

    /**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
    public function MasterPage()
    {
    	
    }
    
    /**
     * Adiciona parâmetros na página mestre
     * 
     * @access public
     * @param string $Key
     * @param string $Value
     * @return void
     */
    public function AddParameter($Key, $Value)
    {
    	$this->Parameter[$Key] = $Value;
    }
    
    /**
     * Inicia template
     * 
     * @access public
     * @param string $Path
     * @param string $Title (Default: null)
     * @return void
     */
    public function Init($Path, $Title = null)
    {
        $this->Template = $Path;
        
        if(!is_file($this->Template))
        {
        	throw new Exception("Template não encontrado.");
        }
        
        $this->Title = $Title;
        $this->Content = array();
    }

    /**
     * Finaliza template
     * 
     * @access public
     * @return void
     */
    public function End()
    {
        //Parameter
        foreach ($this->Parameter as $c => $v)
        {
            ${$c} = $v;
        }

        //Content
        foreach ($this->Content as $s)
        {
            ${$s} = $this->{$s};
        }

        $PageTitle = $this->Title;
        include ($this->Template);
    }

    /**
     * Abre Bloco
     * 
     * @access public
     * @param string $Name
     * @return void
     */
    public function Open($Name)
    {
        if (!in_array($Name, $this->Content))
        {
        	array_push($this->Content, $Name);
        }
        
        ob_start();
    }

    /**
     * Fecha Bloco
     * 
     * @access public
     * @param string $Name
     * @return void
     */
    public function Close($Name)
    {
        if (in_array($Name, $this->Content))
        {
        	$this->{$Name} = ob_get_contents();
        }

        ob_end_clean();
    }
}

?>