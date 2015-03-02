<?php

include_once("../library/master-page.php");
include_once("../library/validator.php");
include_once("../library/config/sendmail.php");
include_once("../library/config/database/tmmktemail.php");
include_once("../library/config/database/tvereador.php");
include_once("../library/config/database/tpartido.php");
include_once("../library/config/database/tparametro.php");

$oVereador = new tvereador();
if(!$oVereador->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: " . $oVereador->WebURL);
	exit();
}

//post
$bForm = true;
$msg = "";
$cbReceber = 1;
if($oVereador->CheckKeyForm($_POST) && $oVereador->Email)
{
	//vars
	$txtNome = $_POST["txtNome"];
	$txtEmail = $_POST["txtEmail"];
	$txtTelefone = $_POST["txtTelefone"];
	$txtMensagem = $_POST["txtMensagem"];
	$cbReceber = $_POST["cbReceber"];

	//valida��o
	$oValidator = new Validator();
	$oValidator->Add("Nome", $txtNome, true, null, "Digite o nome.");
	$oValidator->Add("Email", $txtEmail, true, "email", "Digite o e-mail corretamente.");
	$oValidator->Add("Telefone", $txtTelefone, false, "phone", "Digite o telefone corretamente.");
	$oValidator->Add("Mensagem", $txtMensagem, true, null, "Digite a mensagem.");
	if($oValidator->Validate())
	{
		//par�metros
		$arParam = tparametro::Load();
		
		//mmkt
		if($cbReceber)
		{
			tmmktemail::Create($txtEmail, $txtNome, "fale-com-o-vereador");
		}

		//mensagem
		$Mensagem  = "<h1>Fale com o Vereador</h1>";
		$Mensagem .= "<ul>";
		$Mensagem .= "<li><b>Nome: </b>" . $txtNome . "</li>";
		$Mensagem .= "<li><b>E-mail: </b>" . $txtEmail . "</li>";
		$Mensagem .= "<li><b>Telefone: </b>" . $txtTelefone . "</li>";
		$Mensagem .= "<li><b>Mensagem: </b>" . nl2br($txtMensagem) . "</li>";
		$Mensagem .= "</ul>";
		
		//envia e-mail
		$oMail = new SendMail();
		$oMail->AddAddress($oVereador->Email, $oVereador->Nome);
		$oMail->SetFrom($arParam["email-sistema"], $oVereador->WebTitle);
		$oMail->Sender = $arParam["email-retorno"];
		$oMail->Subject = "Fale com o Vereador";
		$oMail->MsgHTML($oVereador->TemplateEmail($Mensagem));
		$bSend = $oMail->Send();
		$bForm = false;
	}
	else
	{
		$msg = implode("\\r\\n", $oValidator->Message);
	}
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Vereadores / " . utf8_encode($oVereador->Nome));
$oMasterPage->AddParameter("css", "vereadores/detalhe");
$oMasterPage->AddParameter("pagina", "vereadores");
$oMasterPage->AddParameter("alt", "Vereadores");
$oMasterPage->AddParameter("msg", $msg);
$oMasterPage->Open("PageContent");


?>
<h1>Vereadores</h1>
<?php

if($oVereador->Imagem)
{// echo $oVereador->Imagem;
	?>
	<div class="foto-detalhe col-md-6 col-sm-6 ">
		<span></span>
		<img src="<?=$oVereador->Thumbnail($oVereador->Imagem, 340*1.3, 353*1.3, "", true);?>" alt="<?=$oVereador->Nome;?>" title="<?=$oVereador->Nome;?>" class="img-responsive center-block"/>
	</div>
	<?php
}

?>
<div class="informacoes col-md-6 col-sm-6  <?php if(!$oVereador->Imagem) { ?> semFoto<?php } ?>">
    <h2><?php echo (utf8_encode($oVereador->Nome));?></h2>
    <?php
    
    $oPartido = new tpartido();
    if($oPartido->LoadByPrimaryKey($oVereador->PartidoID))
    {
    	?>
    	<p class="partido">Partido: <?=$oPartido->Sigla;?></p>
    	<?php
    }
    
    if(!$oVereador->IsClear($oVereador->Informacao) || $oVereador->Email || $oVereador->Telefone || $oVereador->LocalTrabalho)
    {
    	?>
	    <ul class="dadosPessoais">
	    	<?php if(!$oVereador->IsClear($oVereador->Informacao)) { ?><li><strong>Dados Pessoais:</strong><br /><?php echo (utf8_encode($oVereador->HTMLDecode($oVereador->Informacao)));?></li><?php } ?>
		    <?php if($oVereador->Email) { ?><li><strong>E-mail:</strong><br /><a href="mailto:<?=$oVereador->Email;?>"><?=$oVereador->Email;?></a></li><?php } ?>
		    <?php if($oVereador->Telefone) { ?><li><strong>Telefone:</strong><br /><?=$oVereador->Telefone;?></li><?php } ?>
	        <?php if($oVereador->LocalTrabalho) { ?><li><strong>Local de Trabalho:</strong><br /><?=utf8_encode($oVereador->LocalTrabalho);?></li><?php } ?>
	    </ul>
	    <?php
	}
	
	?>
</div>
<div class="clear"></div>
<?php if(!$oVereador->IsClear($oVereador->Descricao)) { ?><div class="fckEditor col-md-12">
    <?php
    $string = $oVereador->HTMLDecode($oVereador->Descricao);
    echo utf8_encode($string);
    ?></div><?php } ?>
<?php

if($oVereador->Email)
{
	?>
	<div class="formulario col-md-12">
		<?php
		
		if($bForm)
		{
			?>
			<h3>Preencha o formulário abaixo e fale com o vereador:</h3>
            <div class="input-group container-box bs-callout bs-callout-red">
		    <form action="" method="post" class="formAlert">
		    	<?=$oVereador->GenerateKeyForm();?>
		        <ul>
		            <li class="input330">
		                <label>
		                    Nome:
		                    <span><input value="<?=$txtNome;?>" type="text" id="txtNome" name="txtNome" maxlength="150" class="form-control {required:true}" title="Digite o nome." /></span>
		                </label>
		            </li>
		            <li class="input330 noMarginRight">
		                <label>
		                    E-mail:
		                    <span><input value="<?=$txtEmail;?>" type="text" id="txtEmail" name="txtEmail" maxlength="150" class="form-control {required:true, email:true}" title="Digite o e-mail corretamente." /></span>
		                </label>
		            </li>
		            <li class="input330 noMarginRight">
		                <label>
		                    Telefone:
		                    <span><input value="<?=$txtTelefone;?>" type="text" id="txtTelefone" name="txtTelefone" maxlength="14" class="form-control {phone:true, mask:'(99) 9999-9999'}" title="Digite o telefone corretamente." /></span>
		                </label>
		            </li>
		            <li class="clear mensagem">
		                <label>
		                    Mensagem:
		                    <span><textarea cols="90" rows="10" id="txtMensagem" name="txtMensagem" class="form-control {required:true}" title="Digite a mensagem."><?=$txtMensagem;?></textarea></span>
		                </label>
		            </li>
		            <li class="checkbox text-right">
			        	<label>
			        		<input type="checkbox" id="cbReceber" name="cbReceber" value="1" <?php if($cbReceber) { ?> checked="checked" <?php } ?> />
			        		Desejo receber novidades da <b>Câmara Municipal de São José dos Campos</b> em meu e-mail
			        	</label>
					</li>

                    <button type="button" class="btn btn-default botEnviar pull-right">
                        <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar
                    </button>
		           <!--<li class="botEnviar"><input type="image" src="imgs/vereadores/detalhe/bot-enviar.png" alt="Enviar" title="Enviar" /></li>-->
		        </ul>
		    </form>
            </div>
		    <div class="clear"></div>
		    <?php
		}
		else
		{
			if($bSend)
			{
				?>
				<h2>Mensagem enviada!</h2>
				<p>Obrigado. Continue em contato com nossos vereadores.</p>
				<?php
			}
			else
			{
				?>
				<h2>Desculpe!</h2>
				<p>Problemas ao enviar sua mensagem, tente novamente mais tarde.</p>
				<?php
			}
		}
		
	    ?>
	</div>
	<?php
}

?>
<a href="javascript:history.back();" class="mid">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>