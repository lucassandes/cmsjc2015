<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tvereadorexterno.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", utf8_encode("Bancadas e Lideranças / Vereadores em Representação Externas"));
$oMasterPage->AddParameter("css", "bancadas-e-liderancas/vereadores-em-representacao-externas");
$oMasterPage->AddParameter("pagina", "bancadas-e-liderancas");
$oMasterPage->AddParameter("titulo", "bancadas-e-liderancas/vereadores-em-representacao-externas");
$oMasterPage->Open("PageContent");

?>
<h1><?php echo utf8_encode("Vereadores em represetação externa"); ?></h1>
    <h3><?php echo utf8_encode("Representantes da Câmara em Orgãos Externos"); ?></h3>
<?php

$oVereadorExterno = new tvereadorexterno();
$oVereadorExterno->SQLOrder = "Titulo DESC";
if($oVereadorExterno->LoadSQLAssembled())
{
	?>
    <div class="container-box lista-representacao col-md-12">
	<ul>
		<?php
		for($c = 0; $c < $oVereadorExterno->NumRows; $c++)
		{
			?>
			<li>
    			<?=utf8_encode($oVereadorExterno->Titulo);?>
    			<?php if(!$oVereadorExterno->IsClear($oVereadorExterno->Descricao)) { ?>
                    <div class="titular">
                    <?php //echo($oNoticia->HTMLDecode(utf8_encode($oNoticia->Descricao)));
                    $string = $oVereadorExterno->HTMLDecode($oVereadorExterno->Descricao);
                    echo utf8_encode($string); ?>


                    </div><?php } ?>
			</li>
			<?php
			$oVereadorExterno->MoveNext();
		}
		?>
	</ul>
    </div>
	<?php
}
else
{
	?>
	<br /><p>Nenhum registro encontrado.</p>
	<?php
}

?>
<a href="bancadas-e-liderancas/" class="voltar">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>