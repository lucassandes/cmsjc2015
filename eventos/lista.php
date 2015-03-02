<?php

header("Content-Type: text/html;  charset=iso-8859-1", true);

include_once("../library/config/database/tevento.php");

$dia = (($_GET["dia"]) ? $_GET["dia"] : date("d"));
$mes = (($_GET["mes"]) ? $_GET["mes"] : date("m"));
$ano = (($_GET["ano"]) ? $_GET["ano"] : date("Y"));

$oEvento = new tevento();
$oEvento->SQLTotal = 2;
$oEvento->LoadByDiaMesAno($dia, $mes, $ano);

?>
<p class="data"><?=$oEvento->DateFormat("d \d\e MONTH \d\e Y", $oEvento->DateConvert($dia . "/" . $mes . "/" . $ano));?></p>
<?php

if($oEvento->NumRows > 0)
{
	?>
	<ul>
		<?php
		for($c = 0; $c < $oEvento->NumRows; $c++)
		{
			?>
			<li>
		    	<a href="eventos/?ano=<?=$ano;?>&amp;mes=<?=$mes;?>#evento<?=$oEvento->ID;?>">
					<?php if($oEvento->Hora || $oEvento->Local) { ?><strong><?=$oEvento->Hora;?><?=(($oEvento->Hora && $oEvento->Local) ? " - " : "");?><?=$oEvento->Local;?></strong><br /><?php } ?>
					<?=$oEvento->Titulo;?>
		        </a>
			</li>
			<?php
			$oEvento->MoveNext();
		}
		?>
	</ul>
	<a href="eventos/?ano=<?=$ano;?>&amp;mes=<?=$mes;?>" class="vejaMaisEventos">Veja Mais Eventos</a>
	<?php
}
else
{
	?>
	<p>Nenhum registro encontrado.</p>
	<?php
}

?>