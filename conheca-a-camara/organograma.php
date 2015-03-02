<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Conhe�a a C�mara - Organograma");
$oMasterPage->AddParameter("css", "conheca-a-camara/organograma");
$oMasterPage->AddParameter("pagina", "conheca-a-camara");
$oMasterPage->AddParameter("titulo", "conheca-a-camara/organograma");
$oMasterPage->Open("PageContent");

?>
<ul class="listagem">
	<li><span></span>Presid�ncia</li>
    <li class="outraCategoria">
    	<ul>
        	<li><span></span>Secret�rio Geral</li>
            <li><span></span>Assessor Jur�dico</li>
            <li class="outraCategoria">
            	<ul>
                	<li><span></span>Secret�rio de Administra��o</li>
                    <li><span></span>Secret�rio de Expediente</li>
                    <li class="outraCategoria">
                    	<ul>
                        	<li><span></span>Diretor de Comunica��o Social</li>
                            <li><span></span>Diretor de Expediente</li>
                            <li><span></span>Diretor de Finan�as</li>
                            <li><span></span>Diretor de Manuten��o Patrimonial</li>
                            <li><span></span>Diretor de T�cnico Legislativo</li>
                            <li class="outraCategoria">
                            	<ul>
                                	<li><span></span>Chefe Div. Administra��o</li>
                                    <li><span></span>Chefe Div. Adm. Pessoal</li>
                                    <li><span></span>Chefe Div. Arq. Protocolo</li>
                                    <li><span></span>Chefe Div. Atas Anais e Docum.</li>
                                    <li><span></span>Chefe Div. Cerimonial</li>
                                    <li><span></span>Chefe Div. Contabilidade</li>
                                    <li><span></span>Chefe Div. Exped. Corresp.</li>
                                    <li><span></span>Chefe Div. Legislativa</li>
                                    <li><span></span>Chefe Div. Patrim�nio</li>
                                    <li><span></span>Chefe Div. Rec. Materiais</li>
                                    <li><span></span>Chefe Div. Serv. Internos</li>
                                    <li><span></span>Chefe Div. Tesouraria</li>
                                    <li><span></span>Assessor Econ�mico</li>
                                    <li><span></span>Assessor Chefe Inform�tica</li>
                                    <li><span></span>Assessor Rela��es Comunit�rias</li>
                                    <li><span></span>Administrador de Rede</li>
                                    <li><span></span>Consultor Chefe Assessoria de Imprensa</li>
                                    <li><span></span>Consultor Jur�dico</li>
                                    <li class="outraCategoria">
                                    	<ul>
                                        	<li><span></span>Supervisor Administra��o</li>
                                            <li><span></span>Supervisor Empenho</li>
                                            <li><span></span>Supervisor Expediente</li>
                                            <li><span></span>Supervisor Patrim�nio</li>
                                            <li><span></span>Supervisor de Pessoal</li>
                                            <li><span></span>Consultor Assuntos Imprensa</li>
                                            <li class="outraCategoria">
                                            	<ul>
                                                	<li><span></span>Supervisor Contr. Tr�fego</li>
                                                    <li><span></span>Supervisor Som e Manut. Geral</li>
                                                    <li><span></span>Supervisor Telefonia</li>
                                                    <li><span></span>Supervisor Transportes</li>
                                                    <li><span></span>Supervisor Vigil�ncia</li>
                                                    <li><span></span>Assessor de Inform�tica</li>
                                                    <li><span></span>Assist. Legislativo</li>
                                                    <li><span></span>Fot�grafo</li>
                                                    <li class="outraCategoria">
                                                    	<ul>
                                                        	<li><span></span>Telefonista</li>
                                                            <li><span></span>Datil�grafo</li>
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