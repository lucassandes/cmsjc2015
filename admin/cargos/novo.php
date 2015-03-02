<?php

$Chave = "cargos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tcargo.php");
include_once("../../library/config/database/tpadrao.php");

$oCargo = new tcargo();
$bEditar = $oCargo->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oCargo->Titulo = $_POST["txtTitulo"];
	$oCargo->PadraoID = $_POST["ddlPadrao"];
	$oCargo->Vinculo = $_POST["rbVinculo"];
	
	//validação
	$oValidator = new Validator();   
	$oValidator->Add("Titulo", $oCargo->Titulo, true, null, "Digite o título.");
	$oValidator->Add("PadraoID", $oCargo->PadraoID, true, null, "Selecione o padrão.");
	$oValidator->Add("Vinculo", $oCargo->Vinculo, true, null, "Digite o vínculo.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oCargo->AddNew();
		}             		
         
		$oCargo->Save();
		
		//redireciona
		$oCargo->SetMessage((($bEditar) ? "Azul" : "Verde"));
		header("Location: " . (($_POST["hFA"] == "outro") ? "novo.php" : "index.php?" . $_SERVER["QUERY_STRING"]));
		exit();
	}
	else
	{
		$msg = $oValidator->Create();
	}
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

$NoticiaData = explode('-',$oCargo->Data);
$oCargo->Data =  $NoticiaData[2] . '/' . $NoticiaData[1] . '/' . $NoticiaData[0];

?>
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem" enctype="multipart/form-data">
	<ul>    
    	<li>
			<label>
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oCargo->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>   
    	<li>
			<label>
				Padrão*:
				<select name="ddlPadrao" class="{required:true}" id="ddlPadrao" title="Selecione o padrão.">
                    <option value="">Selecione...</option>
                    <?php
                    $oPadrao = new tpadrao();
                    $oPadrao->SQLOrder = "Titulo ASC";
                    $oPadrao->LoadSQLAssembled();
                    for($c = 0; $c < $oPadrao->NumRows; $c++)
                    {
                        ?>
                        <option value="<?=$oPadrao->ID;?>" <?=($oPadrao->ID == $oCargo->PadraoID) ? 'selected="selected"' : '';?>><?=$oPadrao->Titulo;?> (R$ <?=$oPadrao->DecimalShow($oPadrao->Salario);?>)</option>
                        <?php
                        $oPadrao->MoveNext();                        
                    } 
                    ?>
                </select>
			</label>
		</li>   
    	<li>       
			Vínculo*:<br />
			<label> 
				<input type="radio" id="rbVinculo" name="rbVinculo" value="comissao" <?=(($oCargo->Vinculo == 'comissao') ? 'checked="checked"' : '');?> />
				&nbsp;Comissão &nbsp;   
			</label>     
			<label> 
				<input type="radio" id="rbVinculo" name="rbVinculo" value="efetivo" <?=(($oCargo->Vinculo != 'comissao') ? 'checked="checked"' : '');?> />
				&nbsp;Efetivo
			</label>
		</li>   
	</ul>  
    <input type="hidden" id="hFA" name="hFA" />
	<input onclick="$('#hFA').val('outro')" type="image" src="../imgs/botoes/enviar-e-cadastrar-outro.png" alt="Enviar e Cadastrar outro" title="Enviar e Cadastrar outro" />
    <input onclick="$('#hFA').val('enviar')" type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>