<?php

$Chave = "setores-da-camara";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tsetor.php");
include_once("../../library/config/database/tsetoremail.php");

$oSetor = new tsetor();
$bEditar = $oSetor->LoadByPrimaryKey($_GET["id"]);

$txtEmail = array();

$oSetorEmail = new tsetoremail();
if($oSetorEmail->LoadBySetorID($oSetor->ID))
{
	for($c = 0; $c < $oSetorEmail->NumRows; $c++)
	{
		array_push($txtEmail, $oSetorEmail->Email);
		$oSetorEmail->MoveNext();
	}
}

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oSetor->Titulo = $_POST["txtTitulo"];
	$oSetor->Descricao = $_POST["txtDescricao"];
	$oSetor->Telefones = $_POST["txtTelefones"];
	$txtEmail = ((is_array($_POST["txtEmail"])) ? $_POST["txtEmail"] : array());
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oSetor->Titulo, true, null, "Digite o título.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oSetor->AddNew();
		}
		$oSetor->Save();
		
		//Remove
		$oSetorEmailDel = new tsetoremail();
		$oSetorEmailDel->DeleteBySetorID($oSetor->ID);
		
		//Add
		foreach($txtEmail as $key => $value)
		{
			if(Validator::ValidateEmail($value))
			{
				$oSetorEmailAdd = new tsetoremail();
				$oSetorEmailAdd->AddNew();
				$oSetorEmailAdd->SetorID = $oSetor->ID;
				$oSetorEmailAdd->Email = $value;
				$oSetorEmailAdd->Save();
			}
		}
		
		//redireciona
		$oSetor->SetMessage((($bEditar) ? "Azul" : "Verde"));
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

?>
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem">
	<ul>
    	<li>
			<label>
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oSetor->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Descrição:
				<textarea cols="80" rows="5" id="txtDescricao" name="txtDescricao"><?=$oSetor->Descricao;?></textarea>
			</label>
		</li>
		<li>
			<label>
				Telefones:
				<input size="80" maxlength="250" type="text" id="txtTelefones" name="txtTelefones" value="<?=$oSetor->Telefones;?>" />
			</label>
		</li>
		<li>
			<table class="lista" style="width:auto;">
				<thead>
					<tr>
						<td>E-mail</td>
						<td>Opções</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$TotalEmail = ((count($txtEmail) > 0) ? count($txtEmail) : 1);
					for($c = 0; $c < $TotalEmail; $c++)
					{
						?>
						<tr>
							<td><input size="60" maxlength="150" type="text" name="txtEmail[]" value="<?=$txtEmail[$c];?>" /></td>
							<td align="center">
								<a href="javascript:void(0);" onclick="addDefault($(this).parent().parent())" class="add" <?php if(($c + 1) < $TotalEmail) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/add_16x16.gif" alt="Adicionar" title="Adicionar" /></a>
								<a href="javascript:void(0);" onclick="delDefault($(this).parent().parent())" class="del" <?php if(($c + 1) >= $TotalEmail) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/delete_16x16.gif" alt="Remover" title="Remover" /></a>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
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