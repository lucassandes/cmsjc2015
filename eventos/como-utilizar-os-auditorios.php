<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Eventos - Como utilizar os audit�rios");
$oMasterPage->AddParameter("css", "eventos/como-utilizar-os-auditorios");
$oMasterPage->AddParameter("pagina", "eventos");
$oMasterPage->AddParameter("titulo", "eventos/como-utilizar-os-auditorios");
$oMasterPage->Open("PageContent");

?>
    <h1>Como Utilizar os Audit�rios</h1>
    <p>A Portaria n.� 48, de 26 de fevereiro de 2002, disciplina a forma de utiliza��o do plen�rio e audit�rios da
        C�mara Municipal.</p>
    <p>Os espa�os somente podem ser utilizados por entidades ou segmentos representativos da comunidade, desde que
        constitu�dos legalmente.</p>
    <p>Para obter informa��es a respeito, basta ligar para o telefone 3925-6544, fazer a reserva e encaminhar documento
        � presid�ncia da C�mara solicitando o uso do espa�o. O pedido deve conter o nome da entidade, endere�o, nome do
        respons�vel e telefone de contato.</p>
    <div class="clear" style="height: 50px"></div>
    <div class="auditorios row">
        <div class="col-md-6">
            <div class=" box container-box bs-callout bs-callout-dark-blue bancadas-partidarias homenagens">
                <div class="feat-image"><img src="imgs/eventos/como-utilizar-os-auditorios/aud-mario-covas.png" alt=""
                                             title=""/></div>

                <h3>Audit�rio M�rio Covas</h3>
                <p><strong>Capacidade:</strong> 97 Lugares</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class=" box container-box bs-callout bs-callout-dark-blue bancadas-partidarias homenagens">
                <div class="feat-image"><img
                        src="imgs/eventos/como-utilizar-os-auditorios/aud-luiz-eduardo-magalhaes.png" class="feat-image"
                        alt="" title=""/></div>

                <h3>Audit�rio Luiz Eduardo Magalh�es</h3>
                <p><strong>Capacidade:</strong> 99 Lugares</p>


            </div>
        </div>
        <div class="col-md-6">
            <div class="box container-box bs-callout bs-callout-dark-blue bancadas-partidarias homenagens">
                <div class="feat-image"><img src="imgs/eventos/como-utilizar-os-auditorios/plenario-e-galeria.png" alt="" title=""/></div>

                <h3>Plen�rio e Galeria</h3>
                <p><strong>Capacidade:</strong> 520 Lugares</p>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box container-box bs-callout bs-callout-dark-blue bancadas-partidarias homenagens">
                <div class="feat-image"><img src="imgs/eventos/como-utilizar-os-auditorios/tancredo-neves.png" alt="" title=""/></div>

                <h3>Tancredo Neves</h3>
                <p><strong>Capacidade:</strong> 33 Lugares</p>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box container-box bs-callout bs-callout-dark-blue bancadas-partidarias homenagens">
                <div class="feat-image"><img src="imgs/eventos/como-utilizar-os-auditorios/nicolau-estefano.png" alt="" title=""/></div>

                <h3>Nicolau Est�fano</h3>
                <p><strong>Capacidade:</strong> 33 Lugares</p>

            </div>
        </div>
    </div>
    <div class="clear"></div>
    <a href="eventos/" class="mid">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>