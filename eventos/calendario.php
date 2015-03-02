<?php

header("Content-Type: text/html;  charset=iso-8859-1", true);

include_once("../library/config/database/tevento.php");

$oEvento = new tevento();

$mes = intval(date("m", mktime(0, 0, 0, ((isset($_GET["mes"])) ? $_GET["mes"] : date("m")), 1, ((isset($_GET["ano"])) ? $_GET["ano"] : date("Y")))));
$ano = intval(date("Y", mktime(0, 0, 0, ((isset($_GET["mes"])) ? $_GET["mes"] : date("m")), 1, ((isset($_GET["ano"])) ? $_GET["ano"] : date("Y")))));
$total_dias = intval(date("t", mktime(0, 0, 0, $mes, 1, $ano)));

?>
<script language="javascript" type="text/javascript">
	function calendario(mes, ano){
		$.get("eventos/calendario.php", {mes:mes, ano:ano}, function(d){
			$(".agendaEventos .calendario").html(d);
		});
	}
	function evento(dia, mes, ano){
		$.get("eventos/lista.php", {dia:dia, mes:mes, ano:ano}, function(d){
			$(".agendaEventos .evento").html(d);
		});
	}
</script>


<div class="mesNav">
	<a href="javascript:void(0);" onclick="calendario(<?=$mes-1;?>, <?=$ano;?>);" class="botAnt"><img src="imgs/geral/navegacao/bot-seta-anterior.png" alt="Anterior" title="Anterior" /></a>
    <a href="javascript:void(0);" onclick="calendario(<?=$mes+1;?>, <?=$ano;?>);" class="botProx"><img src="imgs/geral/navegacao/bot-seta-proximo.png" alt="Pr�ximo" title="Pr�ximo" /></a>
    <p><?=$oEvento->Month[$mes];?> / <?=$ano;?></p>
</div>
<table cellpadding="0" cellspacing="1" width="100%">
	<thead>
        <tr>
            <td>D</td>
            <td>S</td>
            <td>T</td>
            <td>Q</td>
            <td>Q</td>
            <td>S</td>
            <td>S</td>
        </tr>
    </thead>
    <tbody>
    	<?php
		$k = 1;
		for ($i = 1; $i <= 6; $i++)
		{
			?>
			<tr>
				<?php
				for ($j = 0; $j < 7; $j++)
				{
					$dias = date("w", mktime(0, 0, 0, $mes, $k, $ano));
					$dia_sel = sprintf("%d", $k);
					if($dias == $j && $k <= $total_dias)
					{
						echo '<td>';
						$oEvento = new tevento();
						if($oEvento->LoadByDiaMesAno($dia_sel, $mes, $ano))
						{
							echo '<a href="javascript:void(0);" onclick="evento(' . $dia_sel . ', ' . $mes . ', ' . $ano . ');">' . $dia_sel . '</a>';
						}
						else
						{
							echo $dia_sel;
						}
						echo '</td>';
						$k++;
					}
					else
					{
						echo '<td>&nbsp;</td>';
					}
				}
				?>
			</tr>
			<?php
		}
		?>
    </tbody>
</table>