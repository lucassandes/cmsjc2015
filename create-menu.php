<?php
//0 = menu mobile
//1 = menu da esquerda
//2 = menu fat footer

function create_menu($local)
{
    $filhoCamara = '        <li><a href="conheca-a-camara/">Conheça a Câmara</a></li>
                            <li><a href="memorial-legislativo/">Memorial</a></li>
                            <li><a href="programa-de-visita-de-escolas/">Programa de Visita de Escolas</a></li>
                            <li><a href="cac/">CAC</a></li>
                            <li><a href="http://www.camarasjc.sp.gov.br/promemoria/">Pró-Memória</a></li>
                            <li><a href="noticias/3255/divulgacao+dos+editais+do+concurso+publico+da+camara">Concurso Público</a></li>
                            <li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/grh/grh_rh_online.php" target="_blank">Portal do Servidor</a></li>
                            <li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/fol/veracidade_holerith.php" target="_blank">Autenticidade do Holerith</a></li>
                            <li><a href="http://camarasjc2.hospedagemdesites.ws/download/integracao.pdf" target="_blank">Manual de Integração do Servidor Público</a></li>

    ';

    $filhoVereadores = '
                            <li><a href="vereadores/">Vereadores</a></li>
                            <li><a href="mesa-diretora/">Mesa Diretora</a></li>
                            <li><a href="comissoes/comissoes-permanentes/">Comissões permanentes</a></li>
                            <li><a href="bancadas-e-liderancas/">Bancadas e Lideranças</a></li>
    ';

    $filhoTransparencia = '
    <li><a href="portal-da-transparencia/">Portal da Transparência</a></li>
    <li><a href="orcamento/">Orçamentos</a></li>
    <li><a href="cronograma-de-acoes/">Cronograma Portaria STN 828/2011</a></li>
    <li><a href="licitacoes/">Licitações e Contratos</a></li>
    ';

    $filhoAtividadesLegis = ' <li><a href="comissoes/comissoes-temporarias/">Comissões Temporais</a></li>
                            <!--<li><a href="#">CEIs</a></li>-->
                            <li><a href="audiencias-publicas/"> Audiências Públicas</a></li>';

    $filhoLegislacao = ' <li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Leis Municipais</a></li>
                            <li><a href="http://camarasjc2.hospedagemdesites.ws/clicknow/arquivo/regimento-interno/ead29b798fe67d11bde3.pdf">Regimento interno</a></li>
                            <li><a href="http://camarasjc2.hospedagemdesites.ws/clicknow/arquivo/lei-organica-do-municipio/3f6c067e4cc5320b2745.pdf">Lei Orgânica do Município</a></li>
                            <li><a href="http://www.ceaam.net/sjc/legislacao/">Pesquisa de Leis</a></li>
                            <li><a href="http://ged.camarasjc.sp.gov.br/municipe/">GED - Pesquisa de Projetos de Lei</a></li>';

    $filhoUtilidade = '<li><a href="http://www.sjc.sp.gov.br/mapa_google_itinerario.aspx">Horários e Itinerários de ônibus</a></li>
                            <li><a href="links-institucionais/">Links institucionais</a></li>
                            <li><a href="telefones-uteis/">Telefones úteis</a></li>
                            <li><a href="http://www.maesdase.org.br/">Pessoas desaparecidas</a></li>';
    $filhoSessoes = '
                            <li><a href="#">Sessões de terça</a></li>
                            <li><a href="sessoes-plenarias/">Sessões de quinta</a></li>
                            <li><a href="sessoes-plenarias/">Sessões extraordinárias</a></li>
                            <li><a href="sessoes-plenarias/">Sessões solenes próximas</a></li>
                            <li><a href="sessoes-plenarias/">Sessões solenes anteriores</a></li>
    ';

    $filhoTV = '<li><a href="tv-camara/">Conheça a TV Câmara</a></li>
                           <!-- <li><a href="tv-camara/">Regimento</a></li>
                            <li><a href="tv-camara/">Programação</a></li>-->
                            <li><a href="http://www.camarasjc.sp.gov.br/assista.php" target="_blank">Assista online</a></li>';

    $linkNoticias = 'noticias/';

    if ($local == 0) {
        echo('

<nav class="navbar navbar-inverse visible-xs visible-sm" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-1-collapse">
            <ul id="menu-menu-superior" class="nav navbar-nav">
                <li><a href="#">Página Inicial</a></li>
                <li><a title="Home" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">A
                        Câmara <span class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoCamara . '
                    </ul>

                </li>

                <li><a href="' . $linkNoticias . '">Notícias</a></li>

                <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Vereadores <span
                            class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoVereadores . '
                    </ul>

                </li>

                <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Transparência <span
                            class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoTransparencia . '
                    </ul>

                </li>

                <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Atividades
                        Legislativas <span class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoAtividadesLegis . '
                    </ul>

                </li>

                <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Legislação <span
                            class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoLegislacao . '
                    </ul>

                </li>

                <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Sessões Plenárias
                        <span class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoVereadores . '
                    </ul>

                </li>
                <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">TV Câmara
                        <span class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoTV . '
                    </ul>

                </li>

                  <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Utilidade Pública
                        <span class="caret"></span></a>
                    <ul role="menu" class=" dropdown-menu">
                        ' . $filhoUtilidade . '
                    </ul>

                </li>

                <li><a href="#">Perguntas Frequentes</a></li>

                <li><a href="#">Entre em contato</a></li>
            </ul>
        </div>
    </div>
</nav>

                    ');
    } //MENU DA ESQUERDA
    else if ($local == 1) {

        echo('


<ul id="left-menu">
    <li class="has-child">
        <a href="javascript:void(0)">A Câmara  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><!--<span class="hidden-xs"> > </span>--></a>
        <ul>
            ' . $filhoCamara . '
        </ul>
    </li>

    <li><a href="' . $linkNoticias . '">Notícias</a></li>
    <li><a href="javascript:void(0)">Vereadores <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><!--<span class="hidden-xs"> > </span>--></a>
        <ul>
            ' . $filhoVereadores . '
        </ul>
    </li>
    <li><a href="javascript:void(0)">Transparência  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>  </a>
        <ul>
         ' . $filhoTransparencia . '
        </ul>

    </li>

    <li><a href="javascript:void(0)">Atividades Legislativas  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></a>
        <ul>
             ' . $filhoAtividadesLegis . '
        </ul>
    </li>
    <li><a href="javascript:void(0)">Legislação  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
        <ul>
         ' . $filhoLegislacao . '
        </ul>
    </li>
    <li><a href="sessoes-plenarias/">Sessões Plenárias  </a>
        <!--<ul>
         ' . $filhoSessoes . '
        </ul>-->
    </li>
    <li><a href="javascript:void(0)">TV Câmara  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
        <ul>
         ' . $filhoTV . '
        </ul>
    </li>
    <li class="last"><a href="javascript:void(0)">Utilidade Pública  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
        <ul>
         ' . $filhoUtilidade . '
        </ul>
    </li>
</ul>



    ');
    } else {
        echo('
<ul class="site-map">

    <div class="row">

        <div class="col-md-5ths col-xs-4">
            <li class="fat-footer-column">
                <ul>
                    <li>
                        <span>A Câmara</span>
                        <ul>
                            ' . $filhoCamara . '
                        </ul>
                    </li>

                    <li>
                        <span>Notícias</span>
                        <ul>
                            <li><a href="' . $linkNoticias . '">Notícias</a></li>

                        </ul>
                    </li>


                </ul>
            </li>
        </div>
        <div class="col-md-5ths col-xs-4">
            <li class="fat-footer-column">
                <ul>
                    <li>
                        <span>Vereadores</span>
                        <ul>
                            ' . $filhoVereadores . '
                        </ul>
                    </li>

                    <li>
                        <span>Transparência</span>
                        <ul>
                            ' . $filhoTransparencia . '
                        </ul>
                    </li>
                </ul>
            </li>
        </div>
        <div class="col-md-5ths col-xs-4">
            <li class="fat-footer-column">
                <ul>
                    <li>
                        <span>Atividades Legislativas</span>
                        <ul>
                            ' . $filhoAtividadesLegis . '

                        </ul>
                    </li>

                    <li>
                        <span>Legislação</span>
                        <ul>
                            ' . $filhoLegislacao . '
                        </ul>
                    </li>
                </ul>
            </li>
        </div>
        <div class="col-md-5ths col-xs-4">
            <li class="fat-footer-column">
                <ul>
                    <li>
                        <span>Utilidade Pública</span>
                        <ul>
                                    ' . $filhoUtilidade . '

                        </ul>
                    </li>

                    <li>
                        <span>Sessões Plenárias</span>
                        <ul><li><a href="sessoes-plenarias/">Sessões Plenárias</a></li></ul>
                        <!--<ul>
                            ' . $filhoSessoes . '
                        </ul>-->
                    </li>
                </ul>
            </li>
        </div>
        <div class="col-md-5ths col-xs-4">
            <li class="fat-footer-column">
                <ul>
                    <li>
                        <span>TV Câmara</span>
                        <ul>
                            ' . $filhoTV . '

                        </ul>
                    </li>

                    <li>
                        <span>Portal do Servidor</span>
                        <ul>
                            <li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/grh/grh_rh_online.php" target="_blank" >Portal do Servidor</a></li>
                            <li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/fol/veracidade_holerith.php" target="_blank">Autenticidade do Holerith</a></li>

                        </ul>

                    </li>
                </ul>
            </li>
        </div>
    </div>
</ul>


        ');
    }


    /*echo('
    <p>Erro ao carregar o menu. Favor entrar em contato com o Adminstrador.</p>
    ');*/
}

?>

