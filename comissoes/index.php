<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tcomissao.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Comiss�es");
$oMasterPage->AddParameter("css", "comissoes/index");
$oMasterPage->AddParameter("pagina", "comissoes");
$oMasterPage->Open("PageContent");

?>
<p>As <strong>comiss�es permanentes</strong> subsistem atrav�s da legislatura e t�m como objetivo estudar projetos submetidos ao seu exame e manifestar sobre eles a sua opini�o, quer quanto ao aspecto t�cnico, quer quanto ao m�rito. Ao todo, s�o 15 comiss�es permanentes compostas de um presidente, um relator e um revisor.</p>
<p>As <strong>comiss�es tempor�rias</strong> s�o constitu�das com finalidades especiais, ou de representa��o, que se extinguem quando preenchidos os fins para os quais foram criadas. Elas t�m como objetivo examinar irregularidades ou fato determinado que se incluam na compet�ncia municipal. As comiss�es tempor�rias podem ser: especiais de inqu�rito, especiais de representa��o, especiais de investiga��o, processantes e especiais de estudos.</p>
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