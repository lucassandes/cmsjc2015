<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Conheça a Câmara - Organograma");
$oMasterPage->AddParameter("css", "conheca-a-camara/organograma");
$oMasterPage->AddParameter("pagina", "conheca-a-camara");
$oMasterPage->AddParameter("titulo", "conheca-a-camara/organograma");
$oMasterPage->Open("PageContent");

?>
<ul class="listagem">
	<li><span></span>Presidência</li>
    <li class="outraCategoria">
    	<ul>
        	<li><span></span>Secretário Geral</li>
            <li><span></span>Assessor Jurídico</li>
            <li class="outraCategoria">
            	<ul>
                	<li><span></span>Secretário de Administração</li>
                    <li><span></span>Secretário de Expediente</li>
                    <li class="outraCategoria">
                    	<ul>
                        	<li><span></span>Diretor de Comunicação Social</li>
                            <li><span></span>Diretor de Expediente</li>
                            <li><span></span>Diretor de Finanças</li>
                            <li><span></span>Diretor de Manutenção Patrimonial</li>
                            <li><span></span>Diretor de Técnico Legislativo</li>
                            <li class="outraCategoria">
                            	<ul>
                                	<li><span></span>Chefe Div. Administração</li>
                                    <li><span></span>Chefe Div. Adm. Pessoal</li>
                                    <li><span></span>Chefe Div. Arq. Protocolo</li>
                                    <li><span></span>Chefe Div. Atas Anais e Docum.</li>
                                    <li><span></span>Chefe Div. Cerimonial</li>
                                    <li><span></span>Chefe Div. Contabilidade</li>
                                    <li><span></span>Chefe Div. Exped. Corresp.</li>
                                    <li><span></span>Chefe Div. Legislativa</li>
                                    <li><span></span>Chefe Div. Patrimônio</li>
                                    <li><span></span>Chefe Div. Rec. Materiais</li>
                                    <li><span></span>Chefe Div. Serv. Internos</li>
                                    <li><span></span>Chefe Div. Tesouraria</li>
                                    <li><span></span>Assessor Econômico</li>
                                    <li><span></span>Assessor Chefe Informática</li>
                                    <li><span></span>Assessor Relações Comunitárias</li>
                                    <li><span></span>Administrador de Rede</li>
                                    <li><span></span>Consultor Chefe Assessoria de Imprensa</li>
                                    <li><span></span>Consultor Jurídico</li>
                                    <li class="outraCategoria">
                                    	<ul>
                                        	<li><span></span>Supervisor Administração</li>
                                            <li><span></span>Supervisor Empenho</li>
                                            <li><span></span>Supervisor Expediente</li>
                                            <li><span></span>Supervisor Patrimônio</li>
                                            <li><span></span>Supervisor de Pessoal</li>
                                            <li><span></span>Consultor Assuntos Imprensa</li>
                                            <li class="outraCategoria">
                                            	<ul>
                                                	<li><span></span>Supervisor Contr. Tráfego</li>
                                                    <li><span></span>Supervisor Som e Manut. Geral</li>
                                                    <li><span></span>Supervisor Telefonia</li>
                                                    <li><span></span>Supervisor Transportes</li>
                                                    <li><span></span>Supervisor Vigilância</li>
                                                    <li><span></span>Assessor de Informática</li>
                                                    <li><span></span>Assist. Legislativo</li>
                                                    <li><span></span>Fotógrafo</li>
                                                    <li class="outraCategoria">
                                                    	<ul>
                                                        	<li><span></span>Telefonista</li>
                                                            <li><span></span>Datilógrafo</li>
                                                            <li class="outraCategoria">
                                                            	<ul>
                                                                	<li><span></span>Motorista</li>
                                                                    <li class="outraCategoria">
                                                                        <ul>
                                                                        	<li><span></span>Aux. Serv. Gerais</li>
                                                                            <li><span></span>Vigilante</li>
                                                                            <li><span></span>Servente</li>
                                                                            <li><span></span>Recepcionista</li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
<div class="espacoRodape"></div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>