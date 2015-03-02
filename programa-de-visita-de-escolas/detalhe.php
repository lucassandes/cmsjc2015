<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tgaleria.php");
include_once("../library/config/database/tgaleriafoto.php");

$oGaleria = new tgaleria();
if(!$oGaleria->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: " . $oGaleria->WebURL);
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Programa de Visita de Escolas / " . utf8_encode($oGaleria->Titulo));
$oMasterPage->AddParameter("css", "programa-de-visita-de-escolas/detalhe");
$oMasterPage->AddParameter("pagina", "programa-de-visita-de-escolas");
$oMasterPage->AddParameter("alt", "Programa de Visita de Escolas");
$oMasterPage->Open("PageContent");

?>
<h1>Programa de Visita de Escolas</h1>
<div class="col-md-12">
    <div class="cabecalho">
        <span class="data"><?=$oGaleria->DateFormat("d \d\e MONTH \d\e Y", $oGaleria->Data);?></span>
        <p><?=utf8_encode($oGaleria->Titulo);?></p>
    </div>
</div>
<?php if(!$oGaleria->IsClear($oGaleria->Descricao)) { ?><div class="fckEditor"><?=$oGaleria->HTMLDecode($oGaleria->Descricao);?></div><?php } ?>
<div class="clear"></div>
<?php

$GaleriaID = $oGaleria->ID;
include("../common/galeria-de-fotos.php");

?>
<a href="javascript:history.back();" class="mid">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>