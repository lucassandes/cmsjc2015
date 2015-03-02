<?php

header("Content-Type: text/html;  charset=ISO-8859-1", true);

include("verifica.php");
	
$reportPagina = $oGoogleAnalytics->Report(
	array
	(
		"dimensions" => "ga:pagePath",
		"metrics" => "ga:pageviews",
		"sort" => "-ga:pageviews,-ga:pagePath",
		"max-results" => $quantidade
	)
);

if($reportPagina)
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td>Página</td>
				<td width="90">Visualizações</td>
				<td width="90">% Visualizações</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($reportPagina as $c => $v)
			{
				?>
				<tr>
					<td><?=$oGoogleAnalytics->Parse($c);?></td>
					<td align="center"><?=number_format($v["ga:pageviews"], 0, ",", ".");?></td>
					<td align="center"><?=$oGoogleAnalytics->Calculate($v["ga:pageviews"], $report["ga:pageviews"]);?> %</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<?php
}
else
{
	?>
	Nenhum registro encontrado.
	<?php
}
?>