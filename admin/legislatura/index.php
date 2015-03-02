<?php

$Chave = "legislatura";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/config/database/tparametro.php");

//post
if($_POST)
{
	tparametro::Set($Chave . "-ano",  $_POST["txtAno"]);
	tparametro::Set($Chave . "-duracao",  $_POST["txtDuracao"]);
	
	//redireciona
	tparametro::SetMessage("Azul");
	header("Location: index.php");
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem">
	<ul>
		<li>
			<label>
				Ano*:
				<input size="2" maxlength="2" type="text" id="txtAno" name="txtAno" value="<?=tparametro::Get($Chave . "-ano");?>" class="{required:true, mask:'99'}" title="Digite o ano." />
			</label>
		</li>
		<li>
			<label>
				Duração*:
				<input size="9" maxlength="9" type="text" id="txtDuracao" name="txtDuracao" value="<?=tparametro::Get($Chave . "-duracao");?>" class="{required:true, mask:'9999/9999'}" title="Digite a duração." />
			</label>
		</li>
	</ul>
    <input type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="../"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>