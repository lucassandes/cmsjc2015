<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tpartido.php");
include_once("../library/config/database/tvereador.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", utf8_encode("Bancadas e Lideranças / Bancadas Partidárias na Câmara"));
$oMasterPage->AddParameter("css", "bancadas-e-liderancas/bancadas-partidarias-na-camara");
$oMasterPage->AddParameter("pagina", "bancadas-e-liderancas");
$oMasterPage->AddParameter("titulo", "bancadas-e-liderancas/bancadas-partidarias-na-camara");
$oMasterPage->Open("PageContent");

?>
<h1><?php echo utf8_encode("Bancadas e Lideranças"); ?></h1>
<?php

$oPartido = new tpartido();
$oPartido->SQLOrder = "Titulo ASC";
if($oPartido->LoadSQLAssembled())
{
	for($c = 0; $c < $oPartido->NumRows; $c++)
	{
		$oVereador = new tvereador();
        switch ($oPartido->Sigla){
            case 'DEM':
                $class = 'bs-callout-blue';
                break;

            case 'PSDB':
                $class = 'bs-callout-dark-blue';
                break;

            case 'PMDB':
                $class = 'bs-callout-black';
                break;
            case 'PT':
                $class = 'bs-callout-red';
                break;

            case 'PPS':
                $class = 'bs-callout-red';
                break;

            case 'PP':
                $class = 'bs-callout-dark-blue';
                break;

            case 'PRB':
                $class = 'bs-callout-green';
                break;

            case 'PROS':
                $class = 'bs-callout-blue';
                break;

            case 'PRP':
                $class = 'bs-callout-blue';
                break;

            case 'PSB':
                $class = 'bs-callout-red';
                break;

            case 'PV':
                $class = 'bs-callout-green';
                break;

           default:
                $class= 'bs-callout-blue';
                break;
        }

		if($oVereador->LoadByPartidoID($oPartido->ID))
		{
			?>
			<div class="box container-box bs-callout <?= $class ?> bancadas-partidarias">
				<h3 class="partido-title"><?=$oPartido->Sigla;?> - <?= utf8_encode($oPartido->Titulo);?></h3>
			    <ul>
			    	<?php
			    	for($q = 0; $q < $oVereador->NumRows; $q++)
					{
						?>
			    		<li><a href="<?=$oVereador->GenerateURL();?>"><?= utf8_encode($oVereador->Nome);?></a></li>
			    		<?php
			    		$oVereador->MoveNext();
			    	}
			    	?>
			    </ul>
			</div>
			<?php
		}
		$oPartido->MoveNext();
	}
}
else
{
	?>
	<p>Nenhum registro encontrado.</p>
	<?php
}

?>
<a href="bancadas-e-liderancas/" class="voltar">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>