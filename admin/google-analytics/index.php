<?php

$init = true;
include("verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/plugins/open-flash-chart/php-ofc-library/open_flash_chart_object.php");

$msg = "";
$datainicio = $_GET["datainicio"];
$datatermino = $_GET["datatermino"];
if($datainicio || $datatermino)
{
	$oValidator = new Validator();
	$oValidator->Add("datainicio", $datainicio, true, "date", "Digite a data de in�cio corremente.");
	$oValidator->Add("datatermino", $datatermino, true, "date", "Digite a data de t�rmino corremente.");
	$oValidator->Add("datatermino", $datatermino, false, "dategreaterthan", "Digite a data de t�rmino maior que a data de in�cio.", $datainicio);
	if(!$oValidator->Validate())
	{
		$msg = $oValidator->Create();
	}
}
else
{
	$datainicio = date("d/m/Y", strtotime($oGoogleAnalytics->StartDate));
	$datatermino = date("d/m/Y", strtotime($oGoogleAnalytics->EndDate));
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");
	
?>
<?=$msg;?>
<script language="javascript" type="text/javascript">
$(function(){
	$.get("box-utilizacao-site.php?<?=$_SERVER["QUERY_STRING"];?>", function(d){$("#divUtilizacaoSite").html(d);});
	$.get("box-pagina.php?<?=$_SERVER["QUERY_STRING"];?>", function(d){$("#divPagina").html(d);});
	$.get("box-navegador.php?<?=$_SERVER["QUERY_STRING"];?>", function(d){$("#divNavegador").html(d);});
	$.get("box-pais.php?<?=$_SERVER["QUERY_STRING"];?>", function(d){$("#divPais").html(d);});
	$.get("box-conexao.php?<?=$_SERVER["QUERY_STRING"];?>", function(d){$("#divConexao").html(d);});
	$.get("box-palavra.php?<?=$_SERVER["QUERY_STRING"];?>", function(d){$("#divPalavra").html(d);});
	$.get("box-trafego.php?<?=$_SERVER["QUERY_STRING"];?>", function(d){$("#divTrafego").html(d);});
});
</script>
<div class="google-analytics">

	<!-- Procurar -->
	<div class="area">
		<p>Procurar por per�odo:</p>
		<form method="get" action="">
			<table>
				<tr>
					<td><input size="12" maxlength="10" type="text" id="datainicio" name="datainicio" value="<?=$datainicio;?>" class="{mask:'99/99/9999'}" /></td>
					<td><a href="javascript:void(0);" class="datePicker {target:'#datainicio'}"></a></td>
					<td width="30" align="center">at�</td>
					<td><input size="12" maxlength="10" type="text" id="datatermino" name="datatermino" value="<?=$datatermino;?>" class="{mask:'99/99/9999'}" /></td>
					<td><a href="javascript:void(0);" class="datePicker {target:'#datatermino'}"></a></td>
					<td width="30">&nbsp;</td>
					<td>Exibir:</td>
					<td>
						<select id="quantidade" name="quantidade">
							<?php foreach($arQuantidade as $c) { ?>
							<option value="<?=$c;?>" <?php if($c == $quantidade) { ?> selected="selected" <?php } ?>><?=$c;?></option>
							<?php } ?>
						</select>
					</td>
					<td>&nbsp; itens</td>
					<td width="30">&nbsp;</td>
					<td><input type="image" src="../imgs/botoes/procurar.png" alt="Procurar" title="Procurar" /></td>
				</tr>
			</table>
		</form>
	</div>
	
	<!-- Utiliza��o do Site -->
	<table width="100%">
		<tr valign="top">
			<td width="250" class="info-box" height="230">
				<h4>Utiliza��o do Site</h4>
				<div id="divUtilizacaoSite">
					<div class="carregando"></div>
				</div>
			</td>
			<td width="10">&nbsp;</td>
			<td>
				<?php open_flash_chart_object("100%", 230, "box-utilizacao-site-visita.php?" . $_SERVER["QUERY_STRING"], false, "../../library/plugins/open-flash-chart/"); ?>
			</td>
		</tr>
	</table>
	
	<!-- Separa��o -->
	<br />
	
	<!-- Visualiza��es por p�gina / Navegador dos visitantes -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>Visualiza��es por p�gina</h4>
				<div id="divPagina"><div class="carregando"></div></div>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Navegador dos visitantes</h4>
				<div id="divNavegador"><div class="carregando"></div></div>
			</td>
		</tr>
	</table>
	
	<!-- Separa��o -->
	<br />
	
	<!-- M�dia de visita��o /  Visitas por hor�rio -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>M�dia de visita��o</h4>
				<?php open_flash_chart_object("100%", 200, "box-media-visitacao.php?" . $_SERVER["QUERY_STRING"], false, "../../library/plugins/open-flash-chart/"); ?>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Visitas por hor�rio</h4>
				<?php open_flash_chart_object("100%", 200, "box-horario.php?" . $_SERVER["QUERY_STRING"], false, "../../library/plugins/open-flash-chart/"); ?>
			</td>
		</tr>
	</table>
	
	<!-- Separa��o -->
	<br />
	
	<!-- Pa�s dos visitantes / Tipos de conex�es -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>Pa�s dos visitantes</h4>
				<div id="divPais"><div class="carregando"></div></div>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Tipos de conex�es</h4>
				<div id="divConexao"><div class="carregando"></div></div>
			</td>
		</tr>
	</table>
	
	<!-- Separa��o -->
	<br />
	
	<!-- Palavras mais procuradas / Tipos de conex�es -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>Palavras mais procuradas</h4>
				<div id="divPalavra"><div class="carregando"></div></div>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Tr�fego</h4>
				<div id="divTrafego"><div class="carregando"></div></div>
			</td>
		</tr>
	</table>
</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>