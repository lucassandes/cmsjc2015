<?php

/**
 * Classe utilizada para gerenciar carrinho de compras
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class ShoppingCart
{
	protected $Itens = array();
	protected $SessionName = null;
	public $PesoTotal = null;
	public $AlturaTotal = null;
	public $LarguraTotal = null;
	public $ComprimentoTotal = null;
	public $DiametroTotal = null;
	public $Subtotal = null;
	public $ValorTotal = null;
	public $CEP = null;
	public $PrazoEntrega = null;
	public $TipoFrete = null;
	public $ValorFrete = null;
	public $EnderecoID = null;
	public $TaxaEmbalagem = null;
	public $TipoEmbalagem = null;
	public $ValorEmbalagem = null;
	public $TipoEntrega = null;
	public $EnviarCartao = null;
	public $MensagemCartao = null;
	
	/**
     * Construtor da classe
     * 
     * @access public
	 * @param string $SessionName
     * @return void
     */
	public function ShoppingCart($SessionName = "ShoppingCart")
	{
		session_start();
		$this->SessionName = $SessionName;
		$this->Preloader();
	}
	
	/**
	 * Carrega os itens da sessão
	 * 
	 * @access protected
	 * @return void
	 */
	protected function Preloader()
	{
		$ar = $_SESSION[$this->SessionName];
		if(is_array($ar))
		{
			$this->CEP = $ar["CEP"];
			$this->PrazoEntrega = $ar["PrazoEntrega"];
			$this->TipoFrete = $ar["TipoFrete"];
			$this->ValorFrete = $ar["ValorFrete"];
			$this->EnderecoID = $ar["EnderecoID"];
			$this->TaxaEmbalagem = $ar["TaxaEmbalagem"];
			$this->TipoEmbalagem = $ar["TipoEmbalagem"];
			$this->ValorEmbalagem = $ar["ValorEmbalagem"];
			$this->TipoEntrega = $ar["TipoEntrega"];
			$this->EnviarCartao = $ar["EnviarCartao"];
			$this->MensagemCartao = $ar["MensagemCartao"];
			
			if(is_array($ar["Itens"]))
			{
				foreach($ar["Itens"] as $c => $v)
				{
					$this->Itens[$c] = unserialize($v);
				}
			}
		}
		
		$this->Store();
	}
	
	/**
	 * Armeza itens na sessão
	 * 
	 * @access public
	 * @return void
	 */
	public function Store()
	{
		$this->PesoTotal = 0;
		$this->AlturaTotal = 0;
		$this->LarguraTotal = 0;
		$this->ComprimentoTotal = 0;
		$this->DiametroTotal = 0;
		$this->Subtotal = 0;
		$this->ValorEmbalagem = 0;
		$this->ValorTotal = 0;
		
		$arItens = array();
		foreach($this->Itens as $c => $v)
		{
			$this->PesoTotal += ($v->Peso * $v->Quantidade);
			$this->AlturaTotal += ($v->Altura * $v->Quantidade);
			$this->LarguraTotal += ($v->Largura * $v->Quantidade);
			$this->ComprimentoTotal += ($v->Comprimento * $v->Quantidade);
			$this->DiametroTotal += ($v->Diametro * $v->Quantidade);
			$this->Subtotal += $v->ValorTotal;
			$this->ValorEmbalagem += ($v->Quantidade * $this->TaxaEmbalagem);
			$arItens[$c] = serialize($v);
		}
		$this->ValorTotal = ($this->Subtotal + $this->ValorFrete + $this->ValorEmbalagem);
		
		$ar = array();
		$ar["CEP"] = $this->CEP;
		$ar["PrazoEntrega"] = $this->PrazoEntrega;
		$ar["TipoFrete"] = $this->TipoFrete;
		$ar["ValorFrete"] = $this->ValorFrete;
		$ar["EnderecoID"] = $this->EnderecoID;
		$ar["TaxaEmbalagem"] = $this->TaxaEmbalagem;
		$ar["TipoEmbalagem"] = $this->TipoEmbalagem;
		$ar["ValorEmbalagem"] = $this->ValorEmbalagem;
		$ar["TipoEntrega"] = $this->TipoEntrega;
		$ar["EnviarCartao"] = $this->EnviarCartao;
		$ar["MensagemCartao"] = $this->MensagemCartao;
		$ar["Itens"] = $arItens;
		$_SESSION[$this->SessionName] = $ar;
	}
	
	/**
	 * Adiciona item
	 * 
	 * @access public
	 * @param string $Key
	 * @param ShoppingCartItem $oShoppingCartItem
	 * @return void
	 */
	public function Add($Key, $oShoppingCartItem)
	{
		if(array_key_exists($Key, $this->Itens))
		{
			$oShoppingCartItem->Quantidade += $this->Itens[$Key]->Quantidade;
			$oShoppingCartItem->Quantidade = (($oShoppingCartItem->Estoque > 0) ? (($oShoppingCartItem->Quantidade > $oShoppingCartItem->Estoque) ? $oShoppingCartItem->Estoque : $oShoppingCartItem->Quantidade) : $oShoppingCartItem->Quantidade);
		}
		
		$oShoppingCartItem->ValorTotal = ($oShoppingCartItem->Quantidade * $oShoppingCartItem->ValorUnitario);
		$this->Itens[$Key] = $oShoppingCartItem;
		$this->ClearFrete();
	}
	
	/**
	 * Atualiza item
	 * 
	 * @access public
	 * @param string $Key
	 * @param int $Quantidade
	 * @return void
	 */
	public function Update($Key, $Quantidade)
	{
		$Quantidade = intval($Quantidade);
		if($Quantidade > 0 && array_key_exists($Key, $this->Itens) && $Quantidade != $this->Itens[$Key]->Quantidade)
		{
			$Estoque = $this->Itens[$Key]->Estoque;
			$this->Itens[$Key]->Quantidade = (($Estoque > 0) ? (($Quantidade > $Estoque) ? $Estoque : $Quantidade) : $Quantidade);
			$this->Itens[$Key]->ValorTotal = ($this->Itens[$Key]->Quantidade * $this->Itens[$Key]->ValorUnitario);
			$this->ClearFrete();
		}
	}
	
	/**
	 * Remove item
	 * 
	 * @access public
	 * @param string $Key
	 * @return void
	 */
	public function Remove($Key)
	{
		if(array_key_exists($Key, $this->Itens))
		{
			unset($this->Itens[$Key]);
			$this->ClearFrete();
		}
	}
	
	/**
	 * Limpa frete
	 * 
	 * @access public
	 * @return void
	 */
	public function ClearFrete()
	{
		$this->CEP = null;
		$this->PrazoEntrega = null;
		$this->TipoFrete = null;
		$this->ValorFrete = null;
	}
	
	/**
	 * Limpa carrinho
	 * 
	 * @access public
	 * @return void
	 */
	public function Clear()
	{
		$this->Itens = array();
		$this->PesoTotal = null;
		$this->AlturaTotal = null;
		$this->LarguraTotal = null;
		$this->ComprimentoTotal = null;
		$this->DiametroTotal = null;
		$this->Subtotal = null;
		$this->ValorTotal = null;
		$this->CEP = null;
		$this->PrazoEntrega = null;
		$this->TipoFrete = null;
		$this->ValorFrete = null;
		$this->EnderecoID = null;
		$this->TaxaEmbalagem = null;
		$this->TipoEmbalagem = null;
		$this->ValorEmbalagem = null;
		$this->TipoEntrega = null;
		$this->EnviarCartao = null;
		$this->MensagemCartao = null;
		session_unregister($this->SessionName);
	}
	
	/**
	 * Carrega itens do carrinho
	 * 
	 * @access public
	 * @return array
	 */
	public function Load()
	{
		return $this->Itens;
	}
	
	/**
	 * Verifica carrinho
	 * 
	 * @access public
	 * @return bool
	 */
	public function CheckItem()
	{
		return (count($this->Itens) > 0);
	}
	
	/**
	 * Verifica carrinho e frete
	 * 
	 * @access public
	 * @return bool
	 */
	public function Check()
	{
		return
		(
			$this->CheckItem()
			&& $this->CEP
			&& $this->PrazoEntrega
			&& $this->TipoFrete
		);
	}
}

/**
 * Classe utilizada para gerenciar itens do carrinho de compras
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class ShoppingCartItem
{
	public $ID = null;
	public $Titulo = null;
	public $Imagem = null;
	public $ValorUnitario = null;
	public $Quantidade = 1;
	public $ValorTotal = null;
	public $Estoque = null;
	public $Descricao = null;
	public $Peso = null;
	public $Altura = null;
	public $Largura = null;
	public $Comprimento = null;
	public $Diametro = null;
	public $Link = null;
	public $AtributoID = null;
	public $Extra = null;
}
	
?>