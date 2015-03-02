<?php

include_once("../library/master-page.php");
include_once("../library/config/database/ttimeline.php");
include_once("../library/config/database/ttimelinepresidente.php");  
     
$TimeLineID = $_GET['id'];     
     
$oTodasTimeline = new ttimeline();
$oTodasTimeline->LoadSQLAssembled();

$oTimeline = new ttimeline();
$oTimeline->LoadByPrimaryKey($TimeLineID);  

if(!$TimeLineID){
	$oTimeline->Titulo = "1797 / 1937";
	$oTimeline->Periodo = "01/01/1797 - 31/12/1937";
}   

$oTimelinePresidente = new ttimelinepresidente();
$oTimelinePresidente->LoadByTimelineID($TimeLineID);  

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Conheça a Câmara. Câmara Através dos Tempos");
$oMasterPage->AddParameter("titulo", "conheca-a-camara/camara-atraves-dos-tempos");
$oMasterPage->AddParameter("css", "conheca-a-camara/camara-atraves-dos-tempos");
$oMasterPage->AddParameter("Timeline", 1);
$oMasterPage->AddParameter("TimelineID", $TimeLineID);
$oMasterPage->Open("PageContent"); 

?>
	<div class="datas">
    	<div class="nav">   
            <a href="javascript:void(0);" <?php if($oTodasTimeline->NumRows > 5){?>onclick="$('#scroll').stop().scrollTo( '-=437', 500);"<?php } ?> class="botNav" title="Anterior"></a>
            <a href="javascript:void(0);" <?php if($oTodasTimeline->NumRows > 5){?>onclick="$('#scroll').stop().scrollTo( '+=437', 500);"<?php } ?> class="botNav proximo" title="Próximo"></a>
        	<div id="scroll">
                <ul>
                	<li><a href="conheca-a-camara/camara-atraves-dos-tempos.php?prev=<?=$TimeLineID?>" <?php if(!$TimeLineID){ ?>class="sel"<?php } ?>>1797 / 1937</a></li>
                    <?php for($c = 1; $c <= $oTodasTimeline->NumRows; $c++)
					{ 
						?>
                    	<li id="timeline_<?=$oTodasTimeline->ID?>"><a href="conheca-a-camara/camara-atraves-dos-tempos.php?id=<?=$oTodasTimeline->ID?>&prev=<?=$TimeLineID?>" <?php if($TimeLineID == $oTodasTimeline->ID){ ?>class="sel"<?php } ?>><?=$oTodasTimeline->Titulo?></a></li>
                    	<?php 
                    	
                    	$oTodasTimeline->MoveNext();
					} 
					?>
                </ul>
            </div>
        </div>
        
        <div class="selecionado">
        	Vereadores <span></span> <?=$oTimeline->Titulo?>
            <p><?=$oTimeline->Periodo?></p>
        </div>
    </div>

	<?php if(!$TimeLineID)
	{   
		?>  
		<div class="txtPagina01">
	        <ul>
	        	<li>
	            	<a href="javascript:void(0);" onclick="$(this).next().toggle();">De 1767 a 1822</a>
	                <div>
	                    <p>    
	                        <span>1767 a 1769</span><br />
	                        Vicente de Carvalho, Veríssimo Corrêa e Luiz Batista.
	                    </p>
						<p>
	                        <span>1770 a 1772</span><br />
	                        Inácio Silva Cardoso, Tomás Pinto e Ângelo Leme Nogueira.
	                    </p>
	                    <p>
	                        <span>1773 a 1775</span><br />
	                        Antônio Leme Nogueira, Luiz Almeida e Faustino Corrêa Alvarenga.
	                    </p>
	                    <p>
	                        <span>1776 a 1778</span><br />
	                        João Cardoso de Menezes, José de Freitas Trigo e Manoel José Leme.
	                    </p>
	                    <p>
	                        <span>1779 a 1781</span><br />
	                        Antônio Leme Nogueira, Antônio Garcia Oliveira e Luiz Almeida.
	                    </p>
	                    <p>
	                        <span>1782 a 1784</span><br />
	                        Antônio Garcia de Oliveira, José da Costa e Manoel José Leme.
	                    </p>
	                    <p>
	                        <span>1785 a 1787</span><br />
	                        José Antônio Nunes, Antônio Côrrea da Silva e Tomás Rodrigues Pereira.
	                    </p>
	                    <p>
	                        <span>1788 a 1791</span><br />
	                        Antonio José da Costa, Inácio da Silva Cardoso, Antônio José Leme, José Antônio Neves e Faustino Corrêa de Abreu.
	                    </p>
	                    <p>
	                        <span>1792 a 1794</span><br />
	                        Antônio das Neves, Simplício Pimentel, Manuel Araújo Fortes, Domingos Ribeiro Viana e Ângelo Nogueira Colaço.
	                    </p>
	                    <p>
	                        <span>1798 a 1800</span><br />
	                        Jorge Branco Ribeiro, Timóteo Miranda, Maximino de Oliveira Leite e João de Souza Faria.
	                    </p>
	                    <p>
	                        <span>1801 a 1803</span><br />
	                        José de Araújo Fontes, Manoel Rodrigues Chaves, João de Souza Faria e Antônio Dias Morgado.
	                    </p>
	                    <p>
	                        <span>1804 a 1806</span><br />
	                        Antônio José da Costa, João de Souza Faria, Antônio José Leme e Manoel José Leme.
	                    </p>
	                    <p>
	                        <span>1807 a 1809</span><br />
	                        Francisco de Araújo Ferraz, José Antônio Costa, Antônio José Leme e Simplício da Rocha Pimentel.
	                    </p>
	                    <p>
	                        <span>1810 a 1812</span><br />
	                        Félix da cosa Araújo, João José da Costa, Antônio Alves e José Martins da Costa.
	                    </p>
	                    <p>
	                        <span>1813 a 1815</span><br />
	                        Francisco Antônio de Souza, Félix da costa Araújo, Alexandre Viana e Joaquim Rodrigues do Prado.
	                    </p>
	                    <p>
	                        <span>1816 a 1818</span><br />
	                        Jacinto Mariano de Souza, Manoel Caetano de Barros, Manoel Batista de Araújo, Miguel Bicudo leme e José M. da Costa.
	                    </p>
	                    <p>
	                        <span>1819 a 1821</span><br />
	                        Francisco de Barros, Venâncio José Leme, José Cardoso de Menezes, João Batista de Barros e Manoel Rodrigues Chaves.
	                    </p>
	            </li>     
	            <li>
	            	<a href="javascript:void(0);" onclick="$(this).next().toggle();">De 1822 a 1828 (Mandato de um ano):</a>
	                <div>
	                    <p>
	                        <span>1822</span><br />
	                        Inácio Bicudo de Brito, Venâncio José Leme, José Cardoso de Menezes, João Vicente Ferreira e Manoel Rodrigues Chaves.
	                    </p>
	                    <p>
	                        <span>1823</span><br />
	                        Antônio Alves Bezerra, Miguel de Araújo Ferraz, Diogo de Araújo Ferraz e Manoel Gonçalves Guimarães.<br />
	                        * Em 31 de Janeiro de 1823 tomaram posse Joaquim Mariano de Oliveira, como alcaide, e Gregório Inácio Ferreira Nobre, como capitão-militar. Foi um período anormal, após o Grito do Ipiranga.
	                    </p>
	                    <p>
	                        <span>1824</span><br />
	                        José Martins Costa, Diogo de Araújo Ferraz, Miguel de Araújo Ferraz e Venâncio José Leme.
	                    </p>
	                    <p>
	                        <span>1825</span><br />
	                        Venâncio José Leme, José Cardoso de Menezes, Joaquim de Andrade e Manoel Joaquim Chaves.
	                    </p>
	                    <p>
	                        <span>1826</span><br />
	                        João de Souza Faria, João Ramos da Silva, Manoel Caetano de Barros e Manoel Alves Coicelos.
	                    </p>
	                    <p>
	                        <span>1827</span><br />
	                        João Ramos da Silva, Manoel Joaquim de Andrade, Manoel de Araújo Ferraz e José Joaquim Morais.
	                    </p>
	                    <p>
	                        <span>1828</span><br />
	                        Luiz José Gomes dos Santos, Antônio Pereira Goulart, José Martins Costa e Manoel Gonçalves Guimarães.
	                    </p>
	                    <p>
	                        <span>1829 a 1832</span><br />
	                        Manoel Caetano de Barros, Manoel Joaquim de Andrade, José Martins Costa, Luiz Gomes dos Santos e Venâncio José Leme.
	                    </p>
	                    <p>
	                        <span>1833 a 1836</span><br />
	                        José Antônio Barros, Bento Moreira da Mota, Eugênio José de Oliveira, José Cursino dos Santos, Antônio Joaquim da Silva, Francisco de Paula Diniz Galvão, Vitoriano José Leme e Bento Pires de Morais. * Em 1834 foi instituído o cargo de prefeito, sendo nomeado Manoel Joaquim Gonçalves de Andrade).
	                    </p>
	                    <p>
	                        <span>1837 a 1840</span><br />
	                        Adriano José de Araújo, Cláudio José Machado, Ângelo Gonçalves Agostín, Mariano José de Araújo, Joaquim José da Costa, Luiz Antônio da Silva e Jeremias Lopes de Siqueira.
	                    </p>
	                    <p>
	                        <span>1841 a 1844</span><br />
	                        Lourenço Rodrigues da Silva, Luiz José Gomes dos Santos, Vitoriano José da Costa, Miguel Nunes Bernardes, João José Ribeiro, Manoel Pereira da Mota e Manoel Gonçalves Guimarães.
	                    </p>
	                    <p>
	                        <span>1845 a 1848</span><br />
	                        Francisco de Paula Diniz Galvão, Jeremias Lopes de Siqueira, Manoel Ferreira da Mota, Joaquim José da Costa, Antônio Joaquim de Oliveira, Luiz Antônio da Silva e José da Costa Araújo.<br />
	                        Entre 1849 e 1856 não foram localizados documentos que comprovem a formação da Câmara.
	                    </p>
	                    <p>
	                        <span>1857 a 1860</span><br />
	                        Antônio Bernardino de Almeida Noqueira, Paulino Alves, Antônio Martins de Brito, João Bicudo de Brito, Américo José Machado, Cláudio Araújo Ferraz e José Costa Araújo.
	                    </p>
	                    <p>
	                        <span>1861 a 1864</span><br />
	                        João Honório Corrêa de Abreu, Manoel Joaquim de Andrade, Luiz Antônio da Silva Fidalgo, Joaquim José da Costa, Antônio Paulino Alves, Joaquim Cursino dos Santos e Joaquim Antônio Araújo Ferraz.
	                    </p>
	                    <p>
	                        <span>1865 a 1868</span><br />
	                        José Teodoro de Almeida Nogueira, José Ferreira das Neves, Cândido Leite Machado, Manoel Joaquim de Oliveira, Moisés Pereira Maia, Antônio de Barros da Silva e Francisco Antônio de Andrade.
	                    </p>
	                    <p>
	                        <span>1869 a 1872</span><br />
	                        Antônio de Castro Mendonça Furtado, Francisco Rafael da Silva Júnior, Francisco Antônio Mariano Leite, Francisco Silvério da Luz, Joaquim Cursino dos Santos, Antônio Bernardino de Almeida Nogueira, Joaquim Antônio de Oliveira Leme e José Luiz Moreira Salgado.
	                    </p>
	                    <p>
	                        <span>1873 a 1876</span><br />
	                        Francisco Rafael da Silva Júnior, Benedito Ribeiro da Costa Araújo, José Antônio Pacheco Netto, Joaquim Leite Machado, Antônio Gomes de Alvarenga, José dos Reis Ferraz, Francisco Borges Diniz Galvão, Domiciano César de Melo Fagundes e José Caetano de Mascarenhas Ferraz.
	                    </p>
	                    <p>
	                        <span>1877 a 1880</span><br />
	                        Francisco de Escobar, Bento Francisco Machado, José Leite Emídio de Sales, Francisco Pires de Brito, José Vieira de Souza, Joaquim FerreiraBraga, Francisco Antônio Mariano, Delfino Ferraz de Araújo e Antônio da Costa Mendonça Furtado.
	                    </p>
	                    <p>
	                        <span>1881 a 1882</span><br />
	                        Francisco de Escobar, Antônio Domingues de Vasconcelos, Benedito Antônio de Oliveira, José Ribeiro de Araújo, Fábio Lopes de Siqueira, Agostinho Rodrigues de Abreu, Bráulio Marrins Lopes de Brito, Francisco de Paula Galvão e Antônio Leite Emídio de Sales.
	                    </p>
	                    <p>
	                        <span>1883 a 1886</span><br />
	                        Antônio Vieira de Souza Neves, Francisco Antônio da Silva Ramos, José Maria Ribeiro da Silva, Antônio de Paula Madureira, Antônio Rosendo de Oliveira, Fernando de Oliveira, Francisco Antônio das Neves, Francisco Rafael da Silva Júnior e Francisco Roberto dos Santos.
	                    </p>
	                    <p>
	                        <span>1887 a 1890</span><br />
	                        Francisco Rafael da Silva Júnior, Francisco Alves Fagundes, Joaquim Ferreira Lima, Francisco Paes de Brito, João Augusto Gonçalves de Freitas, José Bueno Alvarenga, Luiz Augusto de Andrade, Alexandre Marcondes de Moura Machado e Antônio Pinto Bastos de Andrade.
	                    </p>
	                </div>
	            </li>
	            <li>
	            	<a href="javascript:void(0);" onclick="$(this).next().toggle();">1890/1891 Conselho de Intendência</a>
	                <div>
	                    <p>
	                        <span>1890</span><br />
	                        Com a Proclamação da República, em 10 de fevereiro de 1890 foi criado o Conselho de Intendência formado por: Cônego Francisco de Oliveira Lima, José Silvério dos Reis Neves e José Pacheto Netto. Em 8 de outubro de 1890 também passaram a fazer parte do Conselho de Intendência: Joaquim Antônio dos Santos Bispo, José Antônio de Barros, Cândido Leite Machado, Antônio Vieira de Souza Neves, Francisco Alves Fagundes e Bernardino Rezende de Andrade.
	                    </p>
	                    <p>
	                        <span>1891</span><br />
	                        Conselho de Intendência: Antônio Clemente de Moraes, Joaquim Ferreira Lima, Francisco Borges Diniz Galvão, Cassiano Ricardo (não é o poeta), Francisco Antônio Mariano Leite e Francisco Ferreira de Paula e Silva.
	                    </p>
	                </div>
	            </li>
	            <li>
	            	<a href="javascript:void(0);" onclick="$(this).next().toggle();">Presidentes da Câmara Municipal de São José dos Campos de 1767 a 1937</a>
	                <div>
	                    <p>
	                        <span>1767 a 1769</span><br />
	                        Vicente de Carvalho
	                    </p>
	                    <p>
	                        <span>1770 a 1772</span><br />
	                        Inácio Silva Cardoso
	                    </p>
	                    <p>
	                        <span>1773 a 1775</span><br />
	                        Antonio Leme Nogueira
	                    </p>
	                    <p>
	                        <span>1776 a 1778</span><br />
	                        João Cardoso de Menezes
	                    </p>
	                    <p>
	                        <span>1779 a 1781</span><br />
	                        Antonio Leme Nogueira
	                    </p>
	                    <p>
	                        <span>1782 a 1784</span><br />
	                        Antonio Garcia de Oliveira
	                    </p>
	                    <p>
	                        <span>1785 a 1787</span><br />
	                        José Antonio Nunes
	                    </p>
	                    <p>
	                        <span>1788 a 1791</span><br />
	                        Antonio José da Costa
	                    </p>
	                    <p>
	                        <span>1792 a 1794</span><br />
	                        Antonio das Neves
	                    </p>
	                    <p>
	                        <span>1795 a 1797</span><br />
	                        Timóteo Miranda Pereira
	                    </p>
	                    <p>
	                        <span>1798 a 1800</span><br />
	                        Jorge Branco Ribeiro
	                    </p>
	                    <p>
	                        <span>1801 a 1803</span><br />
	                        José de Araújo Pontes
	                    </p>
	                    <p>
	                        <span>1804 a 1806</span><br />
	                        Antonio José da Costa
	                    </p>
	                    <p>
	                        <span>1807 a 1809</span><br />
	                        Francisco de Araújo Ferraz
	                    </p>
	                    <p>
	                        <span>1810 a 1812</span><br />
	                        Felix da Costa Araújo
	                    </p>
	                    <p>
	                        <span>1813 a 1815</span><br />
	                        Francisco Antonio de Souza
	                    </p>
	                    <p>
	                        <span>1816 a 1818</span><br />
	                        Jacinto Mariano de Souza
	                    </p>
	                    <p>
	                        <span>1819 a 1821</span><br />
	                        Francisco Antonio de Souza
	                    </p>
	                    <p>
	                        <span>1822</span><br />
	                        Inácio Bicudo de Brito
	                    </p>
	                    <p>
	                        <span>1823</span><br />
	                        Antonio Alves Bezerra
	                    </p>
	                    <p>
	                        <span>1824</span><br />
	                        José Martins Costa
	                    </p>
	                    <p>
	                        <span>1825</span><br />
	                        Venâncio José Neme
	                    </p>
	                    <p>
	                        <span>1826</span><br />
	                        João de Souza Faria
	                    </p>
	                    <p>
	                        <span>1827</span><br />
	                        João Ramos da Silva
	                    </p>
	                    <p>
	                        <span>1828</span><br />
	                        Luiz José Gomes dos Santos
	                    </p>
	                    <p>
	                        <span>1829 a 1832</span><br />
	                        Manoel Caetano dos Santos
	                    </p>
	                    <p>
	                        <span>1883 a 1836</span><br />
	                        José Antonio de Barros
	                    </p>
	                    <p>
	                        <span>1837 a 1840</span><br />
	                        Mariano José de Araújo
	                    </p>
	                    <p>
	                        <span>1841 a 1844</span><br />
	                        Lourenço Rodrigues da Silva
	                    </p>
	                    <p>
	                        <span>1845 a 1848</span><br />
	                        Francisco de Paula Diniz Galvão
	                    </p>
	                    <p>
	                        <span>1849 a 1856</span><br />
	                        Sem citação
	                    </p>
	                    <p>
	                        <span>1857 a 1860</span><br />
	                        Antonio Bernardino de Almeida Nogueira
	                    </p>
	                    <p>
	                        <span>1861 a 1863</span><br />
	                        José Honório Correia de Abreu
	                    </p>
	                    <p>
	                        <span>1864</span><br />
	                        Marciano Leite Machado
	                    </p>
	                    <p>
	                        <span>1865</span><br />
	                        Cândido Leite Machado
	                    </p>
	                    <p>
	                        <span>1866</span><br />
	                        José Teodoro Almeida Nogueira
	                    </p>
	                    <p>
	                        <span>1867</span><br />
	                        José Ferreira Neves
	                    </p>
	                    <p>
	                        <span>1868 e 1869</span><br />
	                        José Teodoro Almeida Nogueira
	                    </p>
	                    <p>
	                        <span>1870 e 1871</span><br />
	                        Francisco Rafael da Silva Júnior
	                    </p>
	                    <p>
	                        <span>1872</span><br />
	                        José Caetano Mascarenhas Ferraz
	                    </p>
	                    <p>
	                        <span>1873 e 1877</span><br />
	                        Francisco Rafael da Silva Júnior
	                    </p>
	                    <p>
	                        <span>1878 e 1879</span><br />
	                        Antônio de Castro Mendonça Furtado
	                    </p>
	                    <p>
	                        <span>1880 a 1882</span><br />
	                        Francisco Escobar
	                    </p>
	                    <p>
	                        <span>1883 e 1884</span><br />
	                        Antônio Vieira de Souza Neves
	                    </p>
	                    <p>
	                        <span>1885</span><br />
	                        José Antônio Pacheco Netto
	                    </p>
	                    <p>
	                        <span>1886</span><br />
	                        Antônio Rosendo de Oliveira
	                    </p>
	                    <p>
	                        <span>1887 a 1889</span><br />
	                        Francisco Rafael da Silva Júnior
	                    </p>
	                    <p>
	                        <span>1890 e 1891</span><br />
	                        Francisco Alves Fagundes
	                    </p>
	                    <p>
	                        <span>1892 a 1895</span><br />
	                        Antônio Clemente de Moraes
	                    </p>
	                    <p>
	                        <span>1896</span><br />
	                        Cláudio Pinto Machado
	                    </p>
	                    <p>
	                        <span>1897 e 1898</span><br />
	                        Benedito Fernandes César Leite
	                    </p>
	                    <p>
	                        <span>1899 a 1901</span><br />
	                        Bertolino Leite Machado
	                    </p>
	                    <p>
	                        <span>1902 a 1904</span><br />
	                        Cláudio Pinto Machado
	                    </p>
	                    <p>
	                        <span>1905 a 1916</span><br />
	                        Cel José Monteiro Ferreira (11 anos)
	                    </p>
	                    <p>
	                        <span>1917</span><br />
	                        Cel João Alves da Silva Cursino
	                    </p>
	                    <p>
	                        <span>1918</span><br />
	                        Felisbino Pinto da Cunha
	                    </p>
	                    <p>
	                        <span>1919 a 1921</span><br />
	                        Dr. Nelson Silveira D'Ávila
	                    </p>
	                    <p>
	                        <span>1922</span><br />
	                        José Ricardo Leite
	                    </p>
	                    <p>
	                        <span>1923 a 1930</span><br />
	                        Dr. Nelson Silveira D'Ávila
	                    </p>
	                    <p>
	                        <span>1932 a 1933</span><br />
	                        Período da Ditadura - Câmaras Municipais foram fechadas
	                    </p>
	                    <p>
	                        <span>1934 a 1937</span><br />
	                        Arnaldo dos Santos Cerdeira 
	                    </p>
	                </div>
	            </li>     
	        </ul>
	    </div>
		<?php	
		
	} else
	{
		?>
	    
	    <?php if($oTimeline->Vereadores != "&lt;p&gt;&amp;#160;&lt;/p&gt;" || !$oTimeline->Vereadores)
	    {
	    	?>	    
		    <div class="box">
	    		<?=$oTimeline->HTMLDecode($oTimeline->Vereadores)?>
		    </div>  
	    	<?php
	    }
	    ?>
	
		<?php if($oTimeline->Observacao != "&lt;p&gt;&amp;#160;&lt;/p&gt;" || !$oTimeline->Observacao)
	    {
	    	?>	    
	    	<p><?=$oTimeline->HTMLDecode($oTimeline->Observacao)?></p>
	    	<?php
	    }
	    ?>
	
	    
	    <?php if($oTimeline->Suplentes != "&lt;p&gt;&amp;#160;&lt;/p&gt;" || !$oTimeline->Suplentes)
	    {
	    	?>	    
		    <div class="box">
		    	<h2>Suplentes que assumiram a vereança</h2>
		        <?=$oTimeline->HTMLDecode($oTimeline->Suplentes)?>
		        <div class="clear"></div>
		    </div>  
	    	<?php
	    }
	    ?>
	
		<h3>Presidentes da Câmara desta legislatura</h3>
	    <ul class="presidentes">
	    	<?php for($c = 1; $c <= $oTimelinePresidente->NumRows; $c++){ ?>
	    	<li>
	        	<img src="<?=$oTimelinePresidente->Thumbnail($oTimelinePresidente->Imagem, 103, 135, "", true, true);?>" alt="<?=$oTimelinePresidente->Nome?>" title="<?=$oTimelinePresidente->Nome?>" />
	            <strong><?=$oTimelinePresidente->Periodo?></strong><br />
	            <?=$oTimelinePresidente->Nome?>
	        </li>
	        <?php $oTimelinePresidente->MoveNext(); } ?>
	    </ul> 
		<?php	
	}
	?>

<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>