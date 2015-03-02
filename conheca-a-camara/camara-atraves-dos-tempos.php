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
$oMasterPage->Init("../master.php", "Conhe�a a C�mara. C�mara Atrav�s dos Tempos");
$oMasterPage->AddParameter("titulo", "conheca-a-camara/camara-atraves-dos-tempos");
$oMasterPage->AddParameter("css", "conheca-a-camara/camara-atraves-dos-tempos");
$oMasterPage->AddParameter("Timeline", 1);
$oMasterPage->AddParameter("TimelineID", $TimeLineID);
$oMasterPage->Open("PageContent"); 

?>
	<div class="datas">
    	<div class="nav">   
            <a href="javascript:void(0);" <?php if($oTodasTimeline->NumRows > 5){?>onclick="$('#scroll').stop().scrollTo( '-=437', 500);"<?php } ?> class="botNav" title="Anterior"></a>
            <a href="javascript:void(0);" <?php if($oTodasTimeline->NumRows > 5){?>onclick="$('#scroll').stop().scrollTo( '+=437', 500);"<?php } ?> class="botNav proximo" title="Pr�ximo"></a>
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
	                        Vicente de Carvalho, Ver�ssimo Corr�a e Luiz Batista.
	                    </p>
						<p>
	                        <span>1770 a 1772</span><br />
	                        In�cio Silva Cardoso, Tom�s Pinto e �ngelo Leme Nogueira.
	                    </p>
	                    <p>
	                        <span>1773 a 1775</span><br />
	                        Ant�nio Leme Nogueira, Luiz Almeida e Faustino Corr�a Alvarenga.
	                    </p>
	                    <p>
	                        <span>1776 a 1778</span><br />
	                        Jo�o Cardoso de Menezes, Jos� de Freitas Trigo e Manoel Jos� Leme.
	                    </p>
	                    <p>
	                        <span>1779 a 1781</span><br />
	                        Ant�nio Leme Nogueira, Ant�nio Garcia Oliveira e Luiz Almeida.
	                    </p>
	                    <p>
	                        <span>1782 a 1784</span><br />
	                        Ant�nio Garcia de Oliveira, Jos� da Costa e Manoel Jos� Leme.
	                    </p>
	                    <p>
	                        <span>1785 a 1787</span><br />
	                        Jos� Ant�nio Nunes, Ant�nio C�rrea da Silva e Tom�s Rodrigues Pereira.
	                    </p>
	                    <p>
	                        <span>1788 a 1791</span><br />
	                        Antonio Jos� da Costa, In�cio da Silva Cardoso, Ant�nio Jos� Leme, Jos� Ant�nio Neves e Faustino Corr�a de Abreu.
	                    </p>
	                    <p>
	                        <span>1792 a 1794</span><br />
	                        Ant�nio das Neves, Simpl�cio Pimentel, Manuel Ara�jo Fortes, Domingos Ribeiro Viana e �ngelo Nogueira Cola�o.
	                    </p>
	                    <p>
	                        <span>1798 a 1800</span><br />
	                        Jorge Branco Ribeiro, Tim�teo Miranda, Maximino de Oliveira Leite e Jo�o de Souza Faria.
	                    </p>
	                    <p>
	                        <span>1801 a 1803</span><br />
	                        Jos� de Ara�jo Fontes, Manoel Rodrigues Chaves, Jo�o de Souza Faria e Ant�nio Dias Morgado.
	                    </p>
	                    <p>
	                        <span>1804 a 1806</span><br />
	                        Ant�nio Jos� da Costa, Jo�o de Souza Faria, Ant�nio Jos� Leme e Manoel Jos� Leme.
	                    </p>
	                    <p>
	                        <span>1807 a 1809</span><br />
	                        Francisco de Ara�jo Ferraz, Jos� Ant�nio Costa, Ant�nio Jos� Leme e Simpl�cio da Rocha Pimentel.
	                    </p>
	                    <p>
	                        <span>1810 a 1812</span><br />
	                        F�lix da cosa Ara�jo, Jo�o Jos� da Costa, Ant�nio Alves e Jos� Martins da Costa.
	                    </p>
	                    <p>
	                        <span>1813 a 1815</span><br />
	                        Francisco Ant�nio de Souza, F�lix da costa Ara�jo, Alexandre Viana e Joaquim Rodrigues do Prado.
	                    </p>
	                    <p>
	                        <span>1816 a 1818</span><br />
	                        Jacinto Mariano de Souza, Manoel Caetano de Barros, Manoel Batista de Ara�jo, Miguel Bicudo leme e Jos� M. da Costa.
	                    </p>
	                    <p>
	                        <span>1819 a 1821</span><br />
	                        Francisco de Barros, Ven�ncio Jos� Leme, Jos� Cardoso de Menezes, Jo�o Batista de Barros e Manoel Rodrigues Chaves.
	                    </p>
	            </li>     
	            <li>
	            	<a href="javascript:void(0);" onclick="$(this).next().toggle();">De 1822 a 1828 (Mandato de um ano):</a>
	                <div>
	                    <p>
	                        <span>1822</span><br />
	                        In�cio Bicudo de Brito, Ven�ncio Jos� Leme, Jos� Cardoso de Menezes, Jo�o Vicente Ferreira e Manoel Rodrigues Chaves.
	                    </p>
	                    <p>
	                        <span>1823</span><br />
	                        Ant�nio Alves Bezerra, Miguel de Ara�jo Ferraz, Diogo de Ara�jo Ferraz e Manoel Gon�alves Guimar�es.<br />
	                        * Em 31 de Janeiro de 1823 tomaram posse Joaquim Mariano de Oliveira, como alcaide, e Greg�rio In�cio Ferreira Nobre, como capit�o-militar. Foi um per�odo anormal, ap�s o Grito do Ipiranga.
	                    </p>
	                    <p>
	                        <span>1824</span><br />
	                        Jos� Martins Costa, Diogo de Ara�jo Ferraz, Miguel de Ara�jo Ferraz e Ven�ncio Jos� Leme.
	                    </p>
	                    <p>
	                        <span>1825</span><br />
	                        Ven�ncio Jos� Leme, Jos� Cardoso de Menezes, Joaquim de Andrade e Manoel Joaquim Chaves.
	                    </p>
	                    <p>
	                        <span>1826</span><br />
	                        Jo�o de Souza Faria, Jo�o Ramos da Silva, Manoel Caetano de Barros e Manoel Alves Coicelos.
	                    </p>
	                    <p>
	                        <span>1827</span><br />
	                        Jo�o Ramos da Silva, Manoel Joaquim de Andrade, Manoel de Ara�jo Ferraz e Jos� Joaquim Morais.
	                    </p>
	                    <p>
	                        <span>1828</span><br />
	                        Luiz Jos� Gomes dos Santos, Ant�nio Pereira Goulart, Jos� Martins Costa e Manoel Gon�alves Guimar�es.
	                    </p>
	                    <p>
	                        <span>1829 a 1832</span><br />
	                        Manoel Caetano de Barros, Manoel Joaquim de Andrade, Jos� Martins Costa, Luiz Gomes dos Santos e Ven�ncio Jos� Leme.
	                    </p>
	                    <p>
	                        <span>1833 a 1836</span><br />
	                        Jos� Ant�nio Barros, Bento Moreira da Mota, Eug�nio Jos� de Oliveira, Jos� Cursino dos Santos, Ant�nio Joaquim da Silva, Francisco de Paula Diniz Galv�o, Vitoriano Jos� Leme e Bento Pires de Morais. * Em 1834 foi institu�do o cargo de prefeito, sendo nomeado Manoel Joaquim Gon�alves de Andrade).
	                    </p>
	                    <p>
	                        <span>1837 a 1840</span><br />
	                        Adriano Jos� de Ara�jo, Cl�udio Jos� Machado, �ngelo Gon�alves Agost�n, Mariano Jos� de Ara�jo, Joaquim Jos� da Costa, Luiz Ant�nio da Silva e Jeremias Lopes de Siqueira.
	                    </p>
	                    <p>
	                        <span>1841 a 1844</span><br />
	                        Louren�o Rodrigues da Silva, Luiz Jos� Gomes dos Santos, Vitoriano Jos� da Costa, Miguel Nunes Bernardes, Jo�o Jos� Ribeiro, Manoel Pereira da Mota e Manoel Gon�alves Guimar�es.
	                    </p>
	                    <p>
	                        <span>1845 a 1848</span><br />
	                        Francisco de Paula Diniz Galv�o, Jeremias Lopes de Siqueira, Manoel Ferreira da Mota, Joaquim Jos� da Costa, Ant�nio Joaquim de Oliveira, Luiz Ant�nio da Silva e Jos� da Costa Ara�jo.<br />
	                        Entre 1849 e 1856 n�o foram localizados documentos que comprovem a forma��o da C�mara.
	                    </p>
	                    <p>
	                        <span>1857 a 1860</span><br />
	                        Ant�nio Bernardino de Almeida Noqueira, Paulino Alves, Ant�nio Martins de Brito, Jo�o Bicudo de Brito, Am�rico Jos� Machado, Cl�udio Ara�jo Ferraz e Jos� Costa Ara�jo.
	                    </p>
	                    <p>
	                        <span>1861 a 1864</span><br />
	                        Jo�o Hon�rio Corr�a de Abreu, Manoel Joaquim de Andrade, Luiz Ant�nio da Silva Fidalgo, Joaquim Jos� da Costa, Ant�nio Paulino Alves, Joaquim Cursino dos Santos e Joaquim Ant�nio Ara�jo Ferraz.
	                    </p>
	                    <p>
	                        <span>1865 a 1868</span><br />
	                        Jos� Teodoro de Almeida Nogueira, Jos� Ferreira das Neves, C�ndido Leite Machado, Manoel Joaquim de Oliveira, Mois�s Pereira Maia, Ant�nio de Barros da Silva e Francisco Ant�nio de Andrade.
	                    </p>
	                    <p>
	                        <span>1869 a 1872</span><br />
	                        Ant�nio de Castro Mendon�a Furtado, Francisco Rafael da Silva J�nior, Francisco Ant�nio Mariano Leite, Francisco Silv�rio da Luz, Joaquim Cursino dos Santos, Ant�nio Bernardino de Almeida Nogueira, Joaquim Ant�nio de Oliveira Leme e Jos� Luiz Moreira Salgado.
	                    </p>
	                    <p>
	                        <span>1873 a 1876</span><br />
	                        Francisco Rafael da Silva J�nior, Benedito Ribeiro da Costa Ara�jo, Jos� Ant�nio Pacheco Netto, Joaquim Leite Machado, Ant�nio Gomes de Alvarenga, Jos� dos Reis Ferraz, Francisco Borges Diniz Galv�o, Domiciano C�sar de Melo Fagundes e Jos� Caetano de Mascarenhas Ferraz.
	                    </p>
	                    <p>
	                        <span>1877 a 1880</span><br />
	                        Francisco de Escobar, Bento Francisco Machado, Jos� Leite Em�dio de Sales, Francisco Pires de Brito, Jos� Vieira de Souza, Joaquim FerreiraBraga, Francisco Ant�nio Mariano, Delfino Ferraz de Ara�jo e Ant�nio da Costa Mendon�a Furtado.
	                    </p>
	                    <p>
	                        <span>1881 a 1882</span><br />
	                        Francisco de Escobar, Ant�nio Domingues de Vasconcelos, Benedito Ant�nio de Oliveira, Jos� Ribeiro de Ara�jo, F�bio Lopes de Siqueira, Agostinho Rodrigues de Abreu, Br�ulio Marrins Lopes de Brito, Francisco de Paula Galv�o e Ant�nio Leite Em�dio de Sales.
	                    </p>
	                    <p>
	                        <span>1883 a 1886</span><br />
	                        Ant�nio Vieira de Souza Neves, Francisco Ant�nio da Silva Ramos, Jos� Maria Ribeiro da Silva, Ant�nio de Paula Madureira, Ant�nio Rosendo de Oliveira, Fernando de Oliveira, Francisco Ant�nio das Neves, Francisco Rafael da Silva J�nior e Francisco Roberto dos Santos.
	                    </p>
	                    <p>
	                        <span>1887 a 1890</span><br />
	                        Francisco Rafael da Silva J�nior, Francisco Alves Fagundes, Joaquim Ferreira Lima, Francisco Paes de Brito, Jo�o Augusto Gon�alves de Freitas, Jos� Bueno Alvarenga, Luiz Augusto de Andrade, Alexandre Marcondes de Moura Machado e Ant�nio Pinto Bastos de Andrade.
	                    </p>
	                </div>
	            </li>
	            <li>
	            	<a href="javascript:void(0);" onclick="$(this).next().toggle();">1890/1891 Conselho de Intend�ncia</a>
	                <div>
	                    <p>
	                        <span>1890</span><br />
	                        Com a Proclama��o da Rep�blica, em 10 de fevereiro de 1890 foi criado o Conselho de Intend�ncia formado por: C�nego Francisco de Oliveira Lima, Jos� Silv�rio dos Reis Neves e Jos� Pacheto Netto. Em 8 de outubro de 1890 tamb�m passaram a fazer parte do Conselho de Intend�ncia: Joaquim Ant�nio dos Santos Bispo, Jos� Ant�nio de Barros, C�ndido Leite Machado, Ant�nio Vieira de Souza Neves, Francisco Alves Fagundes e Bernardino Rezende de Andrade.
	                    </p>
	                    <p>
	                        <span>1891</span><br />
	                        Conselho de Intend�ncia: Ant�nio Clemente de Moraes, Joaquim Ferreira Lima, Francisco Borges Diniz Galv�o, Cassiano Ricardo (n�o � o poeta), Francisco Ant�nio Mariano Leite e Francisco Ferreira de Paula e Silva.
	                    </p>
	                </div>
	            </li>
	            <li>
	            	<a href="javascript:void(0);" onclick="$(this).next().toggle();">Presidentes da C�mara Municipal de S�o Jos� dos Campos de 1767 a 1937</a>
	                <div>
	                    <p>
	                        <span>1767 a 1769</span><br />
	                        Vicente de Carvalho
	                    </p>
	                    <p>
	                        <span>1770 a 1772</span><br />
	                        In�cio Silva Cardoso
	                    </p>
	                    <p>
	                        <span>1773 a 1775</span><br />
	                        Antonio Leme Nogueira
	                    </p>
	                    <p>
	                        <span>1776 a 1778</span><br />
	                        Jo�o Cardoso de Menezes
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
	                        Jos� Antonio Nunes
	                    </p>
	                    <p>
	                        <span>1788 a 1791</span><br />
	                        Antonio Jos� da Costa
	                    </p>
	                    <p>
	                        <span>1792 a 1794</span><br />
	                        Antonio das Neves
	                    </p>
	                    <p>
	                        <span>1795 a 1797</span><br />
	                        Tim�teo Miranda Pereira
	                    </p>
	                    <p>
	                        <span>1798 a 1800</span><br />
	                        Jorge Branco Ribeiro
	                    </p>
	                    <p>
	                        <span>1801 a 1803</span><br />
	                        Jos� de Ara�jo Pontes
	                    </p>
	                    <p>
	                        <span>1804 a 1806</span><br />
	                        Antonio Jos� da Costa
	                    </p>
	                    <p>
	                        <span>1807 a 1809</span><br />
	                        Francisco de Ara�jo Ferraz
	                    </p>
	                    <p>
	                        <span>1810 a 1812</span><br />
	                        Felix da Costa Ara�jo
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
	                        In�cio Bicudo de Brito
	                    </p>
	                    <p>
	                        <span>1823</span><br />
	                        Antonio Alves Bezerra
	                    </p>
	                    <p>
	                        <span>1824</span><br />
	                        Jos� Martins Costa
	                    </p>
	                    <p>
	                        <span>1825</span><br />
	                        Ven�ncio Jos� Neme
	                    </p>
	                    <p>
	                        <span>1826</span><br />
	                        Jo�o de Souza Faria
	                    </p>
	                    <p>
	                        <span>1827</span><br />
	                        Jo�o Ramos da Silva
	                    </p>
	                    <p>
	                        <span>1828</span><br />
	                        Luiz Jos� Gomes dos Santos
	                    </p>
	                    <p>
	                        <span>1829 a 1832</span><br />
	                        Manoel Caetano dos Santos
	                    </p>
	                    <p>
	                        <span>1883 a 1836</span><br />
	                        Jos� Antonio de Barros
	                    </p>
	                    <p>
	                        <span>1837 a 1840</span><br />
	                        Mariano Jos� de Ara�jo
	                    </p>
	                    <p>
	                        <span>1841 a 1844</span><br />
	                        Louren�o Rodrigues da Silva
	                    </p>
	                    <p>
	                        <span>1845 a 1848</span><br />
	                        Francisco de Paula Diniz Galv�o
	                    </p>
	                    <p>
	                        <span>1849 a 1856</span><br />
	                        Sem cita��o
	                    </p>
	                    <p>
	                        <span>1857 a 1860</span><br />
	                        Antonio Bernardino de Almeida Nogueira
	                    </p>
	                    <p>
	                        <span>1861 a 1863</span><br />
	                        Jos� Hon�rio Correia de Abreu
	                    </p>
	                    <p>
	                        <span>1864</span><br />
	                        Marciano Leite Machado
	                    </p>
	                    <p>
	                        <span>1865</span><br />
	                        C�ndido Leite Machado
	                    </p>
	                    <p>
	                        <span>1866</span><br />
	                        Jos� Teodoro Almeida Nogueira
	                    </p>
	                    <p>
	                        <span>1867</span><br />
	                        Jos� Ferreira Neves
	                    </p>
	                    <p>
	                        <span>1868 e 1869</span><br />
	                        Jos� Teodoro Almeida Nogueira
	                    </p>
	                    <p>
	                        <span>1870 e 1871</span><br />
	                        Francisco Rafael da Silva J�nior
	                    </p>
	                    <p>
	                        <span>1872</span><br />
	                        Jos� Caetano Mascarenhas Ferraz
	                    </p>
	                    <p>
	                        <span>1873 e 1877</span><br />
	                        Francisco Rafael da Silva J�nior
	                    </p>
	                    <p>
	                        <span>1878 e 1879</span><br />
	                        Ant�nio de Castro Mendon�a Furtado
	                    </p>
	                    <p>
	                        <span>1880 a 1882</span><br />
	                        Francisco Escobar
	                    </p>
	                    <p>
	                        <span>1883 e 1884</span><br />
	                        Ant�nio Vieira de Souza Neves
	                    </p>
	                    <p>
	                        <span>1885</span><br />
	                        Jos� Ant�nio Pacheco Netto
	                    </p>
	                    <p>
	                        <span>1886</span><br />
	                        Ant�nio Rosendo de Oliveira
	                    </p>
	                    <p>
	                        <span>1887 a 1889</span><br />
	                        Francisco Rafael da Silva J�nior
	                    </p>
	                    <p>
	                        <span>1890 e 1891</span><br />
	                        Francisco Alves Fagundes
	                    </p>
	                    <p>
	                        <span>1892 a 1895</span><br />
	                        Ant�nio Clemente de Moraes
	                    </p>
	                    <p>
	                        <span>1896</span><br />
	                        Cl�udio Pinto Machado
	                    </p>
	                    <p>
	                        <span>1897 e 1898</span><br />
	                        Benedito Fernandes C�sar Leite
	                    </p>
	                    <p>
	                        <span>1899 a 1901</span><br />
	                        Bertolino Leite Machado
	                    </p>
	                    <p>
	                        <span>1902 a 1904</span><br />
	                        Cl�udio Pinto Machado
	                    </p>
	                    <p>
	                        <span>1905 a 1916</span><br />
	                        Cel Jos� Monteiro Ferreira (11 anos)
	                    </p>
	                    <p>
	                        <span>1917</span><br />
	                        Cel Jo�o Alves da Silva Cursino
	                    </p>
	                    <p>
	                        <span>1918</span><br />
	                        Felisbino Pinto da Cunha
	                    </p>
	                    <p>
	                        <span>1919 a 1921</span><br />
	                        Dr. Nelson Silveira D'�vila
	                    </p>
	                    <p>
	                        <span>1922</span><br />
	                        Jos� Ricardo Leite
	                    </p>
	                    <p>
	                        <span>1923 a 1930</span><br />
	                        Dr. Nelson Silveira D'�vila
	                    </p>
	                    <p>
	                        <span>1932 a 1933</span><br />
	                        Per�odo da Ditadura - C�maras Municipais foram fechadas
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
		    	<h2>Suplentes que assumiram a verean�a</h2>
		        <?=$oTimeline->HTMLDecode($oTimeline->Suplentes)?>
		        <div class="clear"></div>
		    </div>  
	    	<?php
	    }
	    ?>
	
		<h3>Presidentes da C�mara desta legislatura</h3>
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