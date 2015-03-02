<?php

$Chave = "licitacoes";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/config/database/tlicitacao.php");
include_once("../../library/config/database/tlicitacaocadastro.php");

$oLicitacao = new tlicitacao();
if(!$oLicitacao->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<?php
$oLicitacaoCadastro = new tlicitacaocadastro();
if($oLicitacaoCadastro->LoadByLicitacaoID($oLicitacao->ID))
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td>Nome</td>
				<td>CNPJ/CPF</td>
				<td>E-mail</td>
				<td>CEP</td>
				<td>Endereco</td>
				<td>Numero</td>
				<td>Complemento</td>
				<td>Bairro</td>
				<td>Cidade</td>
				<td>Estado</td>
				<td>Telefone</td>
				<td>Fax</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oLicitacaoCadastro->NumRows; $c++)
			{
				?>
				<tr>
					<td><?=$oLicitacaoCadastro->Nome;?></td>
					<td><?=$oLicitacaoCadastro->CNPJCPF;?></td>
					<td><?=$oLicitacaoCadastro->Email;?></td>
					<td><?=$oLicitacaoCadastro->CEP;?></td>
					<td><?=$oLicitacaoCadastro->Endereco;?></td>
					<td><?=$oLicitacaoCadastro->Numero;?></td>
					<td><?=$oLicitacaoCadastro->Complemento;?></td>
					<td><?=$oLicitacaoCadastro->Bairro;?></td>
					<td><?=$oLicitacaoCadastro->Cidade;?></td>
					<td><?=$oLicitacaoCadastro->Estado;?></td>
					<td><?=$oLicitacaoCadastro->Telefone;?></td>
					<td><?=$oLicitacaoCadastro->Fax;?></td>
				</tr>
				<?php
				$oLicitacaoCadastro->MoveNext();
			}
			?>
		</tbody>
	</table>
	<?php
}
else
{
	?>
	<p>Nenhum registro encontrado</p>
	<?php
}
?>
<a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>