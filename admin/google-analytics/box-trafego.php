<?php

header("Content-Type: text/html;  charset=ISO-8859-1", true);

include("verifica.php");
	
$reportTrafego = $oGoogleAnalytics->Report(
	array
	(
		"dimensions" => "ga:source",
		"metrics" => "ga:visits",
		"sort" => "-ga:visits,ga:source",
		"max-results" => $quantidade
	)
);

if($reportTrafego)
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td>Fonte</td>
				<td width="90">Visitas</td>
				<td width="90">% Visitas</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($reportTrafego as $c => $v)
			{
				?>
				<tr>
					<td><?=$oGoogleAnalytics->Parse($c);?></td>
					<td align="center"><?=number_format($v["ga:visits"], 0, ",", ".");?></td>
					<td align="center"><?=$oGoogleAnalytics->Calculate($v["ga:visits"], $report["ga:visits"]);?> %</td>
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