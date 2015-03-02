<?php

header("Content-Type: text/html;  charset=ISO-8859-1", true);

include("verifica.php");

$reportPais = $oGoogleAnalytics->Report(
	array
	(
		"dimensions" => "ga:country",
		"metrics" => "ga:visits",
		"sort" => "-ga:visits,-ga:country",
		"max-results" => $quantidade
	)
);

if($reportPais)
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td>País</td>
				<td width="90">Visitas</td>
				<td width="90">% Visitas</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($reportPais as $c => $v)
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