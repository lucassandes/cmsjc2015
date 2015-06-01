<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tcomissao.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Comissões");
$oMasterPage->AddParameter("css", "comissoes/index");
$oMasterPage->AddParameter("pagina", "comissoes");
$oMasterPage->Open("PageContent");

?>
<p>As <strong>comissões permanentes</strong> subsistem através da legislatura e têm como objetivo estudar projetos submetidos ao seu exame e manifestar sobre eles a sua opinião, quer quanto ao aspecto técnico, quer quanto ao mérito. Ao todo, são 15 comissões permanentes compostas de um presidente, um relator e um revisor.</p>
<p>As <strong>comissões temporárias</strong> são constituídas com finalidades especiais, ou de representação, que se extinguem quando preenchidos os fins para os quais foram criadas. Elas têm como objetivo examinar irregularidades ou fato determinado que se incluam na competência municipal. As comissões temporárias podem ser: especiais de inquérito, especiais de representação, especiais de investigação, processantes e especiais de estudos.</p>
<h2 class="zwo3Italic">Veja Mais:</h2>
<div class="veja-mais">
    <ul>
    	<?php
    	
		$oComissao = new tcomissao();
		foreach($oComissao->TipoLista as $c => $v)
		{
			?>
			<li><a href="comissoes/<?=$c;?>/"><?=$v;?></a></li>
			<?php
		}
		
		?>
    </ul>


</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>