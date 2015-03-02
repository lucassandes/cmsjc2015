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
	$oValidator->Add("datainicio", $datainicio, true, "date", "Digite a data de início corremente.");
	$oValidator->Add("datatermino", $datatermino, true, "date", "Digite a data de término corremente.");
	$oValidator->Add("datatermino", $datatermino, false, "dategreaterthan", "Digite a data de término maior que a data de início.", $datainicio);
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
		<p>Procurar por período:</p>
		<form method="get" action="">
			<table>
				<tr>
					<td><input size="12" maxlength="10" type="text" id="datainicio" name="datainicio" value="<?=$datainicio;?>" class="{mask:'99/99/9999'}" /></td>
					<td><a href="javascript:void(0);" class="datePicker {target:'#datainicio'}"></a></td>
					<td width="30" align="center">até</td>
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
	
	<!-- Utilização do Site -->
	<table width="100%">
		<tr valign="top">
			<td width="250" class="info-box" height="230">
				<h4>Utilização do Site</h4>
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
	
	<!-- Separação -->
	<br />
	
	<!-- Visualizações por página / Navegador dos visitantes -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>Visualizações por página</h4>
				<div id="divPagina"><div class="carregando"></div></div>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Navegador dos visitantes</h4>
				<div id="divNavegador"><div class="carregando"></div></div>
			</td>
		</tr>
	</table>
	
	<!-- Separação -->
	<br />
	
	<!-- Média de visitação /  Visitas por horário -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>Média de visitação</h4>
				<?php open_flash_chart_object("100%", 200, "box-media-visitacao.php?" . $_SERVER["QUERY_STRING"], false, "../../library/plugins/open-flash-chart/"); ?>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Visitas por horário</h4>
				<?php open_flash_chart_object("100%", 200, "box-horario.php?" . $_SERVER["QUERY_STRING"], false, "../../library/plugins/open-flash-chart/"); ?>
			</td>
		</tr>
	</table>
	
	<!-- Separação -->
	<br />
	
	<!-- País dos visitantes / Tipos de conexões -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>País dos visitantes</h4>
				<div id="divPais"><div class="carregando"></div></div>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Tipos de conexões</h4>
				<div id="divConexao"><div class="carregando"></div></div>
			</td>
		</tr>
	</table>
	
	<!-- Separação -->
	<br />
	
	<!-- Palavras mais procuradas / Tipos de conexões -->
	<table width="100%">
		<tr valign="top">
			<td width="49%" class="info-box" height="200">
				<h4>Palavras mais procuradas</h4>
				<div id="divPalavra"><div class="carregando"></div></div>
			</td>
			<td>&nbsp;</td>
			<td width="49%" class="info-box">
				<h4>Tráfego</h4>
				<div id="divTrafego"><div class="carregando"></div></div>
			</td>
		</tr>
	</table>
</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>