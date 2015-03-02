<?php

include_once("../library/master-page.php");
include_once("../library/validator.php");
include_once("../library/config/sendmail.php");
include_once("../library/config/database/tparametro.php");
include_once("../library/config/database/tnoticia.php");
include_once("../library/config/database/tnoticiaarquivo.php");

$oNoticia = new tnoticia();
if (!$oNoticia->LoadByPrimaryKey($_GET["id"])) {
    header("Location: " . $oNoticia->WebURL);
    exit();
}

//post
$bForm = true;
$msg = "";
if ($oNoticia->CheckKeyForm($_POST)) {
    //vars
    $txtNome = $_POST["txtNome"];
    $txtEmail = $_POST["txtEmail"];

    //valida��o
    $oValidator = new Validator();
    $oValidator->Add("Nome", $txtNome, true, null, "Digite o nome.");
    $oValidator->Add("Email", $txtEmail, true, "email", "Digite o e-mail corretamente.");
    if ($oValidator->Validate()) {
        //par�metros
        $arParam = tparametro::Load();


        //mensagem
        $Mensagem = "<h1>Ol� " . $txtNome . ",</h1><br />";
        $Mensagem .= "<p>Segue abaixo o link da not�cia <b>" . $oNoticia->Titulo . "</b>:</p>";
        $Mensagem .= "<p><a href='" . $oNoticia->GenerateURL() . "'>" . $oNoticia->GenerateURL() . "</a></p>";

        //envia e-mail
        $oMail = new SendMail();
        $oMail->AddAddress($txtEmail, $txtNome);
        $oMail->SetFrom($arParam["email-sistema"], $oNoticia->WebTitle);
        $oMail->Sender = $arParam["email-retorno"];
        $oMail->Subject = $oNoticia->WebTitle;
        $oMail->MsgHTML($oNoticia->TemplateEmail($Mensagem));
        $bSend = $oMail->Send();
        $bForm = false;
    } else {
        $msg = implode("\\r\\n", $oValidator->Message);
    }
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", $oNoticia->Titulo);
$oMasterPage->AddParameter("css", "noticias/detalhe");
$oMasterPage->AddParameter("pagina", "noticias");
$oMasterPage->AddParameter("semTitulo", true);
$oMasterPage->AddParameter("meta_titulo", $oNoticia->Titulo);
$oMasterPage->AddParameter("meta_url", $oNoticia->GenerateURL());
if ($oNoticia->Imagem) {
    $oMasterPage->AddParameter("meta_image", $oNoticia->Thumbnail($oNoticia->Imagem, 120, 120));
}
if (!$oNoticia->IsClear($oNoticia->Descricao)) $oMasterPage->AddParameter("meta_description", $oNoticia->CutText($oNoticia->Descricao, 120));
$oMasterPage->AddParameter("msg", $msg);
$oMasterPage->Open("PageContent");

?>


    <div class="col-md-12 noticia-detalhe ">
    <p class="data"><?= $oNoticia->DateFormat('d \d\e MONTH \d\e Y', $oNoticia->Data); /*?><?= date("d/m/Y", $oNoticia->DateShow($oNoticia->Data));*/ ?>
        <?= (($oNoticia->Hora != "" && $oNoticia->Hora != "00:00:00") ? "&nbsp;&nbsp; <i class=\"icon-clock\"></i>" . substr($oNoticia->Hora, 0, 5) : ""); ?></p>

    <h2 class="titulo-noticia"><?= utf8_encode($oNoticia->Titulo); ?></h2>
    <?php

    if ($oNoticia->Subtitulo) {
        ?>
        <h3><?php echo(utf8_encode($oNoticia->Subtitulo)); ?></h3>
    <?php
    } ?>

    <?php /*<p class="data">
            <?= date("d/m/Y", $oNoticia->DateShow($oNoticia->Data)); ?>
            <?= (($oNoticia->Hora != "" && $oNoticia->Hora != "00:00:00") ? " - " . substr($oNoticia->Hora, 0, 5) : ""); ?>
        </p>


        <div class="header-noticias">
            <div class="midias">
                <ul>
                    <li>
                        <div class="fb-like" data-send="false" data-layout="button_count" data-width="100"
                             data-show-faces="false"></div>
                    </li>
                    <li><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></li>
                    <li>
                        <div class="g-plusone" data-size="medium"></div>
                    </li>
                </ul>


            </div>
            <div class="funcoes">
                <a href="#" data-toggle="modal" data-target="#modalRSS">RSS</a>
                <a href="#" data-toggle="modal" data-target="#modalEmail">Enviar por e-mail</a>
                <a href="javascript:void(0);" class="print" onclick="imprimir();">Imprimir</a>
                <!--<a href="javascript:void(0);" class="rss" onclick="rss();">RSS</a>
                <a href="javascript:void(0);" class="email" onclick="enviarPorEmail();">Enviar por e-mail</a>
                <a href="javascript:void(0);" class="print" onclick="imprimir();">Imprimir</a> -->
            </div>


            <!-- Button trigger modal
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"></button>-->


        </div> */
    ?>
    <div class="header-noticias row">
        <div class=" col-md-6 col-xs-6 midias">
            <ul>
                <li>
                    <div class="fb-share-button" data-href="<?php echo $link; ?>" data-layout="button_count"></div>
                </li>
                <li>
                    <div class="g-plusone" data-size="medium"></div>
                </li>
                <li>
                    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                </li>
            </ul>
        </div>
        <div class="funcoes col-md-6  col-xs-6 ">

            <ul>
                <li>
                    <i class="icon-print"></i> <a href="javascript:void(0);" class="print" onclick="imprimir();">Imprimir</a>
                </li>
                <li>
                    <i class="icon-mail"></i> <a href="#" data-toggle="modal" data-target="#modalEmail">Enviar por
                        email</a></li>
                <li>
                    <i class="icon-rss"></i> <a href="#" data-toggle="modal" data-target="#modalRSS">RSS</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="clear"></div>
    <?php

    if ($oNoticia->Imagem) {
        ?>
        <img class="imgDestaque img-responsive" alt="<?= $oNoticia->Titulo; ?>" title="<?= $oNoticia->Titulo; ?>"
             src="<?= $oNoticia->Thumbnail($oNoticia->Imagem, 340 * 1.2, 280 * 1.2); ?>"/>
    <?php
    }

    if (!$oNoticia->IsClear($oNoticia->Descricao)) {
        ?>
        <div class="fckEditor">
            <?php echo($oNoticia->HTMLDecode(utf8_encode($oNoticia->Descricao))); ?>
            <?php /* <?= $oNoticia->HTMLDecode($oNoticia->Descricao); ?> -->*/ ?>
        </div>
    <?php
    }

    $GaleriaID = $oNoticia->GaleriaID;
    include("../common/galeria-de-fotos.php");

    $oNoticiaArquivo = new tnoticiaarquivo();
    if ($oNoticiaArquivo->LoadByNoticiaID($oNoticia->ID)) {
        ?>
        <div class="orcamentos no-upper">
            <h3>Arquivos</h3>
            <ul>
                <?php
                for ($c = 0; $c < $oNoticiaArquivo->NumRows; $c++) {
                    ?>
                    <li>
                        <a href="<?= $oNoticiaArquivo->DownloadURL($oNoticiaArquivo->Arquivo); ?>">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> <?= $oNoticiaArquivo->Titulo; ?> <span class="download-arquivo hidden-xs hidden-sm">Download do Arquivo</span>
                        </a>
                    </li>
                    <?php
                    $oNoticiaArquivo->MoveNext();
                }
                ?>
            </ul>
        </div>
    <?php
    }

    if ($oNoticia->GetYouTubeID($oNoticia->Video)) {
        ?>
        <div class="video">
            <iframe
                src="http://www.youtube.com/embed/<?= $oNoticia->GetYouTubeID($oNoticia->Video); ?>?wmode=transparent"
                width="700" height="390" frameborder="0" allowFullScreen></iframe>
        </div>
    <?php
    }

    if ($oNoticia->Audio) {
        ?>
        <div class="audio">
            <div id="audio"></div>
            <script language="javascript"
                    type="text/javascript">swfobject.embedSWF("imgs/noticias/audio.swf", "audio", "700", "40", "9.0", null, {path: "<?=substr($oNoticia->Audio, 1);?>"}, {
                    wmode: "transparent",
                    quality: "high"
                }, {name: "audio"});</script>
        </div>
    <?php
    }
    $link = $_SERVER['REQUEST_URI'];
    ?>
    <!--
    <div class="header">
        <div class="midias">


            <ul>
                <li>
                    <div class="fb-share-button" data-href="<?php echo $link; ?>" data-layout="button_count"></div>
                </li>
                <li><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></li>
                <li>
                    <div class="g-plusone" data-size="medium"></div>
                </li>
            </ul>
        </div>
        <div class="funcoes ">

            <div title="Imprimir" class="the-icons span3"><i class="icon-print"></i> <a href="javascript:void(0);"
                                                                                        class="print"
                                                                                        onclick="imprimir();">Imprimir</a>
            </div>
            <div title="Enviar por email" class="the-icons span3"><i class="icon-mail"></i> <a href="#"
                                                                                               data-toggle="modal"
                                                                                               data-target="#modalEmail">Enviar
                    por e-mail</a></div>
            <div title="RSS" class="the-icons span3"><i class="icon-rss"></i> <a href="#" data-toggle="modal"
                                                                                 data-target="#modalRSS">RSS</a></div>

        </div>
    </div>-->
    <div id="fb-root"></div>
    <script language="javascript" type="text/javascript">
        function rss() {
            $(".popRSS").popup({objectClose: ".fechar"});
        }

        function enviarPorEmail() {
            $(".popEmail").popup({objectClose: ".fechar"});
        }

        function imprimir() {
            window.open('<?=$oNoticia->GenerateURLImprimir();?>', 'imprimir', 'width=770, height=600, scrollbars=1, resizable=0, menubar=0, location=0, toolbar=0, status=0');
        }

        //facebook
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=109399142504420";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        //twitter
        !function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = "//platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, "script", "twitter-wjs");

        //plusone
        (function () {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    </script>


    </div><!-- fim container -->





    <!-- MODAIS -->

    <!-- Modal -->
    <div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Envie por Email</h4>
                </div>
                <div class="modal-body">
                    <div class="popEmail">
                        <div>
                            <a href="javascript:void(0);" class="fechar"><img src="imgs/geral/botoes/fechar.png"
                                                                              alt="Fechar"
                                                                              title="Fechar"/></a>

                            <h3>Enviar por E-mail</h3>
                            <?php
                            if ($bForm) {
                                ?>
                                <form action="" method="post" class="formAlert">
                                    <?= $oNoticia->GenerateKeyForm(); ?>
                                    <ul>
                                        <li>
                                            <label>
                                                Nome:
                                <span><input value="<?= $txtNome; ?>" type="text" name="txtNome" maxlength="150"
                                             class="{required:true}" title="Digite o nome."/></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                            <label>
                                                E-mail:
                                <span><input value="<?= $txtEmail; ?>" type="text" name="txtEmail" maxlength="150"
                                             class="{required:true, email:true}" title="Digite o e-mail corretamente."/></span>
                                            </label>
                                        </li>
                                        <li class="bot">
                                            <div><input type="image" src="imgs/fale-conosco/bot-enviar.png" alt="Enviar"
                                                        title="Enviar"/></div>
                                        </li>
                                    </ul>
                                </form>
                            <?php
                            }
                            else
                            {
                            if ($bSend)
                            {
                            ?>
                                <strong>Obrigado!</strong>
                                <p>Sua mensagem foi enviada com sucesso.</p>
                            <?php
                            }
                            else {
                                ?>
                                <strong>Desculpe!</strong>
                                <p>Problemas ao enviar sua mensagem, tente novamente mais tarde.</p>
                            <?php
                            }

                            ?>
                                <script language="javascript" type="text/javascript">$(enviarPorEmail);</script>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalRSS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">RSS</h4>
                </div>
                <div class="modal-body">
                    <div class="popRSS">


                        <h3>Assine nosso RSS</h3>
                        <p>O QUE É RSS?
                        O RSS (Really Simple Syndication) é uma forma prática de receber todas as notícias do Reseller
                        Web no mesmo momento em que elas são publicadas. Através de softwares que utilizam protocolo XML
                        chamados RSS feeders, ou Agregadores RSS, você pode adicionar as páginas do Reseller Web e de
                        seus sites preferidos em uma única tela e a cada notícia publicada, você recebe um aviso sem que
                        você precise navegar até o site onde a notícia foi gerada.</p>

                        <div class="noticias">
                            <h3>Notícias</h3>
                            <a href="<?= $oNoticia->WebURL; ?>noticias/rss.php"
                               target="_blank"><?= $oNoticia->WebURL; ?>
                                noticias/rss.php</a>
                        </div>
                        <p>
                            Como usar?
                            O primeiro passo para receber as notícias do Reseler Web em RSS é instalar um software
                            agregador. Selecionamos uma lista dos programas mais utilizados caso você ainda não tenha um
                            em
                            seu computador:
                        </p>

                        <p>
                            InstantaNews 1.1 (Freeware): Leitor de RSS integrado ao Microsoft Outlook
                            Leitor de Notícias 2.5 (Freeware): Adicione suas próprias fontes de notícias ou utilize as
                            fontes de notícia que são incorporadas automaticamente.
                            e-FastNews 1.2 (Freeware): Leitor RSS em português.
                            Active Web Reader 2.42 (Freeware): Simples de usar, mas é em inglês.
                            Pluck 2.0 Beta 1 (Freeware): Leitor de RSS gratuito que roda no Internet Explorer 6.0 ou
                            mais
                            recente.
                            RSSOwl (Freeware): Leitor de notícias RSS e RDF escrito em Java.
                            FeedReader 2.9 (opensource): Popular programa XML
                        </p>

                        <p>
                            Para ler o conteúdo de cada um dos canais, copie o endereço do canal desejado e cole em seu
                            programa RSS. Muitos programas reconhecem automaticamente os códigos XML das páginas
                            disponíveis
                            em RSS, bastando que você clique
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>



    <!-- Large modal
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal
    </button>-->





<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>