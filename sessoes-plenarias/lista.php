<?php

include_once("../library/master-page.php");
include_once("../library/paginator.php");
include_once("../library/config/database/tsessao.php");

$tipo = $_GET["tipo"];
$filtro = $_GET["filtro"];
//$b = ($filtro == "resultado" || $filtro == "sessoes-anteriores");
$b = ($filtro == "sessoes-anteriores");
$ano = $_GET["ano"];
$mes = $_GET["mes"];
$termo = $_GET["termo"];

$oSessao = new tsessao();
if (!array_key_exists($tipo . "-" . $filtro, $oSessao->TipoLista)) {
    header("Location: " . $oSessao->WebURL);
    exit();
}

$oSessao->SQLWhere = "Tipo = '" . $tipo . "-" . $filtro . "'";
if ($ano) $oSessao->SQLWhere .= " AND YEAR(Data) = '" . intval($ano) . "' ";
if ($mes) $oSessao->SQLWhere .= " AND MONTH(Data) = '" . intval($mes) . "' ";
if ($termo) $oSessao->SQLWhere .= " AND (Titulo LIKE '%" . $termo . "%' OR Descricao LIKE '%" . $termo . "%') ";
$oSessao->SQLOrder = (($b) ? "Data DESC" : "Data ASC");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", utf8_encode("Sessões Plenárias / ") . utf8_encode($oSessao->TipoLista[$tipo . "-" . $filtro]));
$oMasterPage->AddParameter("css", "sessoes-plenarias/lista");
$oMasterPage->AddParameter("pagina", "sessoes-plenarias");
$oMasterPage->AddParameter("titulo", "sessoes-plenarias/" . $tipo . "-" . $filtro);
$oMasterPage->Open("PageContent");


switch ($tipo){
    case "sessoes-solenes-e-homenagens":
        $titulo = "Sessões Solenes e Homenagens";
        break;
    case "sessoes-de-5-feira":
        $titulo = "Sessões de Quinta-Feira";
        break;
    case "sessoes-de-3-feira":
        $titulo = "Sessões de Terça-Feira";
        break;
    case "sessoes-extraordinarias":
        $titulo = "Sessões Solenes e Homenagens";
        break;
    default:
        $titulo = "Seessões Plenárias";

}

switch ($filtro){
    case 'proximas-sessoes':
        $filtro2 = "Próximas Sessões";
        break;
    case 'resultado':
        $filtro2 = "Resultado";
        break;
    case 'pauta':
        $filtro2 = "Pauta";
        break;
    case 'sessoes-anteriores':
        $filtro2 = "Sessões Anteriores";
        break;
    default:
        $filtro2 = ".";

}

?>
<div class="audiencias-publicas ">
    <h1>  <?php echo utf8_encode($filtro2);  ?> </h1>

    <h3>  <?php echo utf8_encode($titulo);  ?> </h3>
</div>
<?php

if ($b) {
$oSessaoAno = new tsessao();
$oSessaoAno->SQLField = "DISTINCT(YEAR(Data)) AS Ano";
$oSessaoAno->SQLWhere = "Tipo = '" . $tipo . "-" . $filtro . "'";
$oSessaoAno->SQLOrder = "Data DESC";
if ($oSessaoAno->LoadSQLAssembled()) {
?>
<div class="buscaResultado">

    <form action="sessoes-plenarias/lista.php" method="get">
        <input type="hidden" name="tipo" value="<?= $tipo; ?>"/>
        <input type="hidden" name="filtro" value="<?= $filtro; ?>"/>


        <div class="clear"></div>
        <div class="buscaSessoes">

            <!--Pesquisar:
		        	<ul>
		            	<li class="bgInput"><input type="text" name="termo" maxlength="50" value="<?= $termo; ?>" /></li>
		            	<li class="botPesquisar"><input type="submit" value="Pesquisar" alt="Pesquisar" title="Pesquisar" /></li>
		        	</ul>-->
            <div class="input-group">
                <input type="text" name="termo" maxlength="50" value="<?= $termo; ?>" class="form-control"
                       placeholder="Digite aqui sua pesquisa">
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" type="button"><span
                                    class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar!
                            </button>
                                            </span>
            </div>
        </div>
        <div class="clear"></div>

        <div class="periodoPesquisa alert alert-warning">
            <div class="input-group">
                <ul>
                    <li class="selecione"><strong>Refine a busca</strong>. Selecione e/o <?php echo utf8_encode("mês");?> ou o ano</li>
                    <li class="w102">
                        <!-- Ano: -->
			                <span>
			                	<select name="ano" class="form-control">
                                    <option value="" selected="selected">Ano</option>
                                    <?php
                                    for ($a = 0;
                                    $a < $oSessaoAno->NumRows;
                                    $a++) {
                                    ?>
                                    <option
                                        value="<?= $oSessaoAno->Ano; ?>" <?php if ($oSessaoAno->Ano == $ano) { ?> selected="selected" <?php } ?>><?= $oSessaoAno->Ano; ?></option>
                                    <?php
                                    $oSessaoAno->MoveNext();
                                    }
                                    ?>
                                </select>
			                </span>
                    </li>
                    <li class="w120">
                        <!--Mês: -->
			                <span>
			                	<select name="mes" class="form-control">
                                    <option value="" selected="selected"> <?php echo utf8_encode("Mês");?></option>
                                    <?php
                                    foreach ($oSessao->Month as $c => $v) {
                                    if ($c) {
                                    ?>
                                    <option
                                        value="<?= $c; ?>" <?php if ($c == $mes) { ?> selected="selected" <?php } ?>><?= utf8_encode($v); ?></option>
                                    <?php
                                    }
                                    }
                                    ?>
                                </select>
			                </span>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>
<?php
} else {
?>
    <p>Nenhum registro encontrado.</p>
<?php
}
} else {
?>
<div class="buscaSessoes">
    <!--Pesquisar:-->
    <form action="sessoes-plenarias/lista.php" method="get">


        <input type="hidden" name="tipo" value="<?= $tipo; ?>"/>
        <input type="hidden" name="filtro" value="<?= $filtro; ?>"/>

        <div class="input-group">
            <input type="text" name="termo" maxlength="50" value="<?= $termo; ?>" class="form-control"
                   placeholder="Digite aqui sua pesquisa">
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" type="button"><span
                                    class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar!
                            </button>
                                            </span>
        </div>
        <!-- /input-group -->

        <!--<input type="text" name="termo" maxlength="50" value="<?= $termo; ?>" />
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
                </button>
				<!--<li class="botPesquisar"><input type="submit" value="Pesquisar" class="btn btn-default " alt="Pesquisar" title="Pesquisar" /></li> -->

    </form>
</div>
<?php
}

?>
<?php

$oPaginator = new Paginator($oSessao->GetCount(), 6, "pg", null, null, null, null);
$oSessao->SQLOrder = (($tipo == "sessoes-solenes-e-homenagens" && $filtro == "proximas-sessoes") ? "Data ASC" : "Data DESC");
if ($oSessao->LoadByPaginator($oPaginator->Limit, $oPaginator->Total)) {
?>
<div class="resultado">
    <!--<ul>-->
    <?php
    for ($c = 0;
    $c < $oSessao->NumRows;
    $c++) {
    ?>
    <div class="box container-box bs-callout bs-callout-blue bancadas-partidarias homenagens">
        <!--<li>
            <!--<table cellpadding="0" cellspacing="0" width="100%" class="texto">
                <tr> -->
        <?php

        if ($oSessao->Imagem) {
        ?>
        <div class="feat-image">
            <img src="<?= $oSessao->Thumbnail($oSessao->Imagem, 180, 150, "", true); ?>"
                 alt="<?= $oSessao->Titulo; ?>" title="<?= $oSessao->Titulo; ?>"
                 class="img-responsive pull-left"/>
        </div>
        <?php
        }

        ?>
        <!--<td>-->
        <div class="">
                <span
                    class="data"><?= $oSessao->DateFormat("d/m/Y", $oSessao->Data); ?><?= (($oSessao->Hora) ? " - " . $oSessao->Hora : ""); ?></span>

            <p><?= utf8_encode($oSessao->Titulo); ?></p>
            <?php

            if ($oSessao->Local || $oSessao->Vereador) {
            ?>
            <p class="info">
                <?php if ($oSessao->Vereador) { ?><strong>Vereador:</strong> <?= utf8_encode($oSessao->Vereador); ?>
            <br/><?php } ?>
                            <?php if ($oSessao->Local) { ?><strong>Local:</strong> <?= utf8_encode($oSessao->Local); ?>
            <br/><?php } ?>
            </p>
            <?php
            }

            if ($oSessao->Arquivo && !$b && $oSessao->IsClear($oSessao->Descricao)) {
            ?>
            <a href="<?= $oSessao->DownloadURL($oSessao->Arquivo); ?>" class="botDownload">
                <img src="imgs/geral/botoes/bot-download.png" alt="Download do Arquivo"
                     title="Download do Arquivo"/>
            </a>
            <?php
            }

            ?>
        </div>
        <!--</td>
    </tr>
</table>-->
        <?php

        if (!$oSessao->IsClear($oSessao->Descricao) || $oSessao->GaleriaID || ($oSessao->Arquivo && $b)) {
        ?>

        <span class="line"></span>
        <a href="<?= $oSessao->GenerateURL(); ?>" class="mid">Leia Mais</a>
        <?php
        }

        ?>
        <div class="clear"></div>
    </div>
    <!--</li> -->
    <?php
    $oSessao->MoveNext();
    }
    ?>
    <!--</ul> -->
</div>
<?php
include ("../common/paginacao.php");
} else {
?>
    <p>Nenhum registro encontrado.</p>
<?php
}

?>
    <a href="javascript:history.back();" class="mid">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>