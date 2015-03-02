<?php

/**
 * Classe utilizada para redimensionar imagens
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Resize
{
    public $Path = null;
    public $Extension = null;
    public $Width = 0;
    public $Height = 0;
    public $NewWidth = 0;
    public $NewHeight = 0;
    public $NewWidthResize = 0;
    public $NewHeightResize = 0;
    public $IsCut = false;
    public $IsCenter = false;
    public $IsCenterX = true;
    public $IsCenterY = true;
    public $QualityJPG = 90;
    public $QualityPNG = 8;

    /**
     * Construtor da classe
     * 
     * @access public
	 * @param string $Path
	 * @param int $Size (Default: 2097152) 2MB
     * @return void
     */
    public function Resize($Path, $Size = 2097152)
    {
        $this->Path = $Path;
        
        if(!function_exists("gd_info"))
		{
			throw new Exception("Desculpe, a extensão GD é necessária.");
		}
        
        if(!is_file($this->Path))
        {
        	throw new Exception("Imagem original não existe.");
        }
        
        if(filesize($this->Path) > $Size)
        {
        	throw new Exception("Imagem muito grande.");
        }
        
        $arxy = getimagesize($this->Path);
		$this->Extension = strtolower(end(explode(".", $this->Path)));
		$this->Width = $arxy[0];
        $this->Height = $arxy[1];
    }

    /**
     * Redimensiona a imagem proporcionalmente
     * 
     * @access protected
     * @return void
     */
    protected function SizeProportional()
    {
        if ($this->IsCut == false)
        {
            //height
            if ($this->Height < $this->NewHeightResize)
            {
                $this->NewHeightResize = $this->Height;
            }

            //width
            if ($this->Width < $this->NewWidthResize)
            {
                $this->NewWidthResize = $this->Width;
            }
        }

        //calcula o fator
        if (($this->Width / $this->NewWidthResize) > ($this->Height / $this->NewHeightResize))
        {
            $fator = ($this->Width / $this->NewWidthResize);
        }
        else
        {
            $fator = ($this->Height / $this->NewHeightResize);
        }

        $this->NewWidthResize = ceil($this->Width / $fator);
        $this->NewHeightResize = ceil($this->Height / $fator);
    }

    /**
     * Corta a imagem
     * 
     * @access protected
     * @return void
     */
    protected function Cut()
    {
        if ($this->IsCut)
        {
            $lm = ceil($this->NewWidthResize);
            $am = ceil($this->NewHeightResize);

            $x = ceil($this->Width);
            $y = ceil($this->Height);

            //Paisagem
            if (($x / $lm) > ($y / $am))
            {
                $dif = abs($am - $y);
                $pct = ($dif * 100) / $y;
                $da = $am;
                $dl = $x + (($x * $pct) / 100);

                $x = ceil($dl);
                $y = ceil($da);
            }
            //Retrato
            else
            {
                if (($x / $lm) < ($y / $am))
                {
                    $dif = $lm - $x;
                    $dif = abs($dif);
                    $pct = ($dif * 100) / $x;
                    $dl = $lm;
                    $da = $y + (($y * $pct) / 100);

                    $x = ceil($dl);
                    $y = ceil($da);
                }
                //Quadrado
                else
                {
                    if ($lm > $am)
                    {
                        $x = $lm;
                        $y = $x;
                    }
                    else
                    {
                        $y = $am;
                        $x = $y;
                    }
                }
            }

            $this->NewWidthResize = ceil($x);
            $this->NewHeightResize = ceil($y);
        }
    }

    /**
     * Função que cria a imagem
     * 
     * @access public
     * @param bool $Open (Default: true)
     * @param string $Save (Default: "")
     * @return bool
     */
    public function Create($Open = true, $Save = "")
    {
    	try
    	{
	        //seta os tamanhos das imagens redimensionadas
	        $this->NewHeightResize = ceil($this->NewHeight);
	        $this->NewWidthResize = ceil($this->NewWidth);
	
	        //corta a imagem
	        $this->Cut();
	
	        //redimensiona a imagem proporcionalmente
	        $this->SizeProportional();
	
	        //gera imagem
	        if ($this->IsCut)
	        {
	            $ImageNew = imagecreatetruecolor($this->NewWidth, $this->NewHeight);
	        }
	        else
	        {
	            $ImageNew = imagecreatetruecolor($this->NewWidthResize, $this->NewHeightResize);
	        }
	
	        //verifica a extensão da imagem
	        switch ($this->Extension)
	        {
	            case "jpg":
	                $ImageOriginal = imagecreatefromjpeg($this->Path);
	                break;
	            case "jpeg":
	                $ImageOriginal = imagecreatefromjpeg($this->Path);
	                break;
	            case "gif":
	                $ImageOriginal = imagecreatefromgif($this->Path);
	                break;
	            case "png":
	                $ImageOriginal = imagecreatefrompng($this->Path);
	                break;
	        }
	        
	        //centraliza
			$dst_x = 0;
			$dst_y = 0;
			
			$src_x = 0;
			$src_y = 0;
			
			if($this->IsCenter && $this->IsCut)
			{
				//x
				if($this->IsCenterX)
				{
					$p = (($this->NewWidth * 100) / $this->NewWidthResize);
					$c = (($this->Width * $p) / 100);
					$src_x = (($this->Width - $c) / 2);
				}
				
				//y
				if($this->IsCenterY)
				{
					$p = (($this->NewHeight * 100) / $this->NewHeightResize);
					$c = (($this->Height * $p) / 100);
					$src_y = (($this->Height - $c) / 2);
				}
			}
			
			//transparencia
			if($this->Extension == "gif" || $this->Extension == "png")
			{
				imagecolortransparent($ImageNew, imagecolorallocatealpha($ImageNew, 0, 0, 0, 127));
				imagealphablending($ImageNew, false);
				imagesavealpha($ImageNew, true);
			}
	
	        //gera imagem no tamanho correto
	        imagecopyresampled($ImageNew, $ImageOriginal, $dst_x, $dst_y, $src_x, $src_y, $this->NewWidthResize, $this->NewHeightResize, $this->Width, $this->Height);
	
	        //salva imagem de acordo com sua extensão
	        if ($Save)
	        {
	            switch ($this->Extension)
	            {
	                case "jpg":
	                    imagejpeg($ImageNew, $Save, $this->QualityJPG);
	                    break;
	                case "jpeg":
	                    imagejpeg($ImageNew, $Save, $this->QualityJPG);
	                    break;
	                case "gif":
	                    imagegif($ImageNew, $Save);
	                    break;
	                case "png":
	                    imagepng($ImageNew, $Save, $this->QualityPNG);
	                    break;
	            }
	            
	            if(is_file($Save))
		        {
		            $Mask = umask(0);
		            chmod($Save, 0777);
		            umask($Mask);
		        }
	        }
	
	        //mostra a imagem
	        if ($Open)
	        {
	            switch ($this->Extension)
	            {
	                case "jpg":
	                    header("Content-Type: image/jpg");
						imagejpeg($ImageNew, null, $this->QualityJPG);
	                    break;
	                case "jpeg":
	                    header("Content-Type: image/jpeg");
						imagejpeg($ImageNew, null, $this->QualityJPG);
	                    break;
	                case "gif":
	                    header("Content-Type: image/gif");
						imagegif($ImageNew);
	                    break;
	                case "png":
	                    header("Content-Type: image/png");
						imagepng($ImageNew, null, $this->QualityPNG);
	                    break;
	            }
	        }
	
	        //destroi imagem
	        imagedestroy($ImageOriginal);
	        imagedestroy($ImageNew);
	        
	        return true;
        }
        catch(Exception $ex)
        {
        	return fase;
        }
    }
}

?>