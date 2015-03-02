<?php

header("Content-Type: text/html;  charset=ISO-8859-1", true);

include("verifica.php");
	
$reportTipoConexao = $oGoogleAnalytics->Report(
	array
	(
		"dimensions" => "ga:connectionSpeed",
		"metrics" => "ga:visits",
		"sort" => "-ga:visits,-ga:connectionSpeed",
		"max-results" => $quantidade
	)
);

if($reportTipoConexao)
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td>Tipo de coxexão</td>
				<td width="90">Visitas</td>
				<td width="90">% Visitas</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($reportTipoConexao as $c => $v)
			{
				?>
				<tr>
					<td><?=$oGoogleAnalytics->Parse($c);?></td>
					<td align="center"><?=number_format($v["ga:visits"], 0, ",", ".");?></td>
					<td align="center"><?=$oGoogleAnalytics->Calculate($v["ga:visits"], $report["ga:visits"]);?> % </td>
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