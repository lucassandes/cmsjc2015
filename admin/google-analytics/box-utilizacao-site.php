<?php

header("Content-Type: text/html;  charset=ISO-8859-1",true);

include("verifica.php");

if($report)
{
	?>
	<div class="utilizacao-do-site">
		<ul>
			<li>
				<a href="javascript:void(0);" onclick="findSWF('chart').reload('box-utilizacao-site-visita.php?<?=$_SERVER["QUERY_STRING"];?>');">
					<b><?=number_format($report["ga:visits"], 0, ",", ".");?></b>
					Visitas
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" onclick="findSWF('chart').reload('box-utilizacao-site-visualizacao.php?<?=$_SERVER["QUERY_STRING"];?>');">
					<b><?=number_format($report["ga:pageviews"], 0, ",", ".");?></b>
					Visualizações
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" onclick="findSWF('chart').reload('box-utilizacao-site-visualizacao-visita.php?<?=$_SERVER["QUERY_STRING"];?>');">
					<b><?=$oGoogleAnalytics->Calculate($report["ga:pageviews"], $report["ga:visits"], false);?></b>
					Visualizações/Visitas
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" onclick="findSWF('chart').reload('box-utilizacao-site-indice-rejeicao.php?<?=$_SERVER["QUERY_STRING"];?>');">
					<b><?=$oGoogleAnalytics->Calculate($report["ga:bounces"], $report["ga:entrances"]);?> %</b>
					Indice de rejeição
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" onclick="findSWF('chart').reload('box-utilizacao-site-tempo-medio.php?<?=$_SERVER["QUERY_STRING"];?>');">
					<b><?=$oGoogleAnalytics->CalculateTime($report["ga:timeOnSite"], $report["ga:visits"]);?></b>
					Tempo médio no site
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" onclick="findSWF('chart').reload('box-utilizacao-site-nova-visita.php?<?=$_SERVER["QUERY_STRING"];?>');">
					<b><?=$oGoogleAnalytics->Calculate($report["ga:newVisits"], $report["ga:visits"]);?> %</b>
					% Novas visitas
				</a>
			</li>
		</ul>
	</div>
	<?php
}
else
{
	?>
	Nenhum registro encontrado.
	<?php
}
?>