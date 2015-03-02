<?php

include(dirname(__FILE__) . "/verifica.php");
include_once(dirname(dirname(__FILE__)) . "/library/config/database/tpermissao.php");
include_once(dirname(dirname(__FILE__)) . "/library/config/database/tpermissaotitulo.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Painel Administrativo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURLAdmin;?>css/geral.css" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURLAdmin;?>css/master.css" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/autocomplete/css/autocomplete.css" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/colorpicker/css/colorpicker.css" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/datepicker/css/datepicker.css" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/imgareaselect/css/imgareaselect-default.css" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/lightbox/css/lightbox.css" />
	<link type="text/css" rel="stylesheet" href="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/rating/css/rating.css" />
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/geral.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.alphanumeric.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.function.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.interface.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.iutil.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.limit.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.textfill.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.maskinput.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.metadata.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.priceformat.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.printElement.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.scrollTo.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.swfobject.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.validate.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.watermarkinput.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.easing.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.bxslider.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.mousewheel.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.mwheelintent.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/jquery.jscrollpane.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/swfobject.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/mask.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/cropimage.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/autocomplete/autocomplete.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/colorpicker/colorpicker.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/datepicker/datepicker.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/imgareaselect/imgareaselect.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/lightbox/lightbox.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/rating/rating.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$oAdministradorLogado->WebURL;?>library/plugins/jquery/swfupload/swfupload.js"></script>
	<!--<script language="javascript" type="text/javascript" src="http://www.clicknow.com.br/crossbrowser/fonte.js"></script>-->
	<script language="javascript" type="text/javascript">
		var WebURL = "<?=$oAdministradorLogado->WebURL;?>";
		$(function(){
			$("a[rel*=lightbox]").lightBox({
				imageLoading: '../../library/plugins/jquery/lightbox/imgs/carregando.gif',
				imageBtnPrev: '../../library/plugins/jquery/lightbox/imgs/anterior.gif',
				imageBtnNext: '../../library/plugins/jquery/lightbox/imgs/proxima.gif',
				imageBtnClose: '../../library/plugins/jquery/lightbox/imgs/fechar.gif',
				imageBlank: '../../library/plugins/jquery/lightbox/imgs/blank.gif'
			});
			$(".menu .bloco").click(function(){
				$(".menu>ul>li>ul").removeClass("aberto");
				$(this).next().addClass("aberto");
			});
			init();
		});
	</script>
</head>
<body>
	<table cellpadding="0" cellspacing="5" bgcolor="#f1f1f1" width="100%">
		<tr valign="top" bgcolor="#FFFFFF">
			<td width="200px">
				<h1 title="<?=$oAdministradorLogado->WebTitle;?>"><a href="<?=$oAdministradorLogado->WebURLAdmin;?>"><img src="<?=$oAdministradorLogado->WebURLAdmin;?>imgs/logo.jpg" alt="<?=$oAdministradorLogado->WebTitle;?>" title="<?=$oAdministradorLogado->WebTitle;?>" /></a></h1>
				<div class="menu">
					<ul>
						<?php
						$oPermissaoTitulo = new tpermissaotitulo();
						$oPermissaoTitulo->LoadByAdministradorID($oAdministradorLogado->ID);
						for($a = 0; $a < $oPermissaoTitulo->NumRows; $a++)
						{
							$oPermissao = new tpermissao();
							if($oPermissao->LoadByAdministradorIDAndPermissaoTituloID($oAdministradorLogado->ID, $oPermissaoTitulo->ID))
							{
								?>
								<li>
									<a href="javascript:void(0);" class="bloco"><?=$oPermissaoTitulo->Titulo;?></a>
									<ul <?php if(($oPermissaoTitulo->ID == $oPermissaoVerifica->PermissaoTituloID) || (!$oPermissaoVerifica->PermissaoTituloID && $a < 1)) { ?> class="aberto" <?php } ?>>
										<?php
										for($c = 0; $c < $oPermissao->NumRows; $c++)
										{
											?>
											<li><a <?php if($oPermissaoVerifica->ID == $oPermissao->ID) { ?> class="sel" <?php } ?> href="<?=$oAdministradorLogado->WebURLAdmin;?><?=$oPermissao->Chave;?>/"><?=$oPermissao->Titulo;?></a></li>
											<?php
											$oPermissao->MoveNext();
										}
										?>
									</ul>
								</li>
								<?php
							}
							$oPermissaoTitulo->MoveNext();
						}
						?>
					</ul>
				</div>
			</td>
			<td>
				<div class="topo">
					<ul class="saudacao">
						<li>Olá <b><?=$oAdministradorLogado->Nome;?></b></li>
						<?php
						if($oAdministradorLogado->UltimoAcesso)
						{
							?>
							<li>Último acesso: <b><?=date("d/m/Y \à\s H:i", $oAdministradorLogado->DateShow($oAdministradorLogado->UltimoAcesso));?></b></li>
							<?php
						}
						?>
						<li>IP: <b><?=$_SERVER["REMOTE_ADDR"];?></b></li>
						<li class="direita"><a href="<?=$oAdministradorLogado->WebURLAdmin;?>sair.php">· Sair</a></li>
						<li class="direita"><a href="<?=$oAdministradorLogado->WebURLAdmin;?>alterar-senha.php">· Alterar senha</a></li>
	                </ul>
	                <div class="clear"></div>
	                <noscript>		                
						<?=$oAdministradorLogado->CreateMessage("Amarelo", "O javascript do seu navegador não está habilidado. Para tudo funcionar perfeitamente é necessário habilitá-lo.");?>
					</noscript>
	                <?php
	                if($oPermissaoVerifica->Titulo || $PageTitle)
	                {
	                	?>
						<h2><?=(($PageTitle) ? $PageTitle : $oPermissaoVerifica->Titulo);?></h2>
						<?php
					}
					?>
					<?=$PageTop;?>
					<?=$oAdministradorLogado->GetMessage();?>
				</div>
				<div class="conteudo">
					<div class="validacao" id="divMensagem">
						Mensagem
						<ul><li style="display:none;"></li></ul>
					</div>
					<?=$PageContent;?>
				</div>
			</td>
		</tr>
	</table>
	<div class="rodape">
		<a href="http://www.clicknow.com.br" target="_blank">Desenvolvimento Web: <strong>ClickNow</strong>®</a>
	</div>
</body>
</html>