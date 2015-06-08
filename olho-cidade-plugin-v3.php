<?php
/**
 * Created by PhpStorm.
 * User: lvmsandes
 * Date: 12/05/2015
 * Time: 09:07
 */

$cont = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/PLey9M_cWIxnncEBZcO5flLXumZY2zDq03/?v=2&alt=json&feature=plcp'));

//$cont = file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=PLey9M_cWIxnncEBZcO5flLXumZY2zDq03&key=AIzaSyCsrbmbGijIoCc62tjFnNdn6ngHp9Dn8oA');
?>


<?

$apikey = “YOURKEY”;
$per_page = 6;
$search = “your search term”;
$category = “2”; //autos

$query = “https://www.googleapis.com/youtube/v3/search?part=snippet&q=$search&maxResults=$per_page&videoCategoryId=$category&safesearch=strict&key=$apikey”;

$json_file3 = file_get_contents(“$query”);

$jfo3 = json_decode($json_file3,true);

foreach($jfo3[‘items’] as $val) {

$title = $val[‘snippet’][‘title’];
$description = $val[‘snippet’][‘description’];
$id = $val[‘id’][‘videoId’];
$thumbnail_url = $val[‘snippet’][‘thumbnails’][‘default’][‘url’];

echo <<<EOF

<p><img width = “250” src = “$thumbnail_url” align = “right”></a>
<a href =”video-viewer.php?v=$id”>$title<BR>
$description</p><br clear=”all”><HR>

EOF;

?>

https://developers.google.com/youtube/v3/guides/implementation
https://developers.google.com/youtube/2.0/deprecation_faq



<?php  //var_dump($cont); ?>
<?php $feed = $cont->feed->entry; ?>
<?php $i = 0;  ?>
<?php if (count($feed)): foreach ($feed as $item): // youtube start ?>
<div class="col-xs-6 ">

    <?php if ($i == 0) { ?>
    <div class="container-box " style="margin-left:-15px;  padding-right: 0; ">
        <?php
        }
        else {
        ?>

        <div class="container-box " style="margin-left:0px; margin-right: -15px; ">
            <?php } ?>
            <a href="<?php echo $item->link[0]->{'href'}; ?>" data-toggle="lightbox" data-gallery="youtubevideos"
               data-width="840">
                <img src="<?php echo $item->{'media$group'}->{'media$thumbnail'}[1]->{'url'}; ?>"
                     class="img-responsive center-block"/>
                <span class="assista-agora hidden-xs"> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> &nbsp;Assista agora</span>
                <div class="duracao pull-right"> <?php echo gmdate("i:s",  $item->{'media$group'}->{'yt$duration'}->{'seconds'}); ?></div>
            </a>

            <a href="<?php echo $item->link[0]->{'href'}; ?>" data-toggle="lightbox" data-gallery="youtubevideos"
                   data-width="840"><h3><?php echo  $item->title->{'$t'}  ?></h3>
            </a>

            <!--<a href="de-olho-na-cidade/" class="veja-mais-videos pull-right ">Veja mais vídeos</a>-->
            <?php
                    /* conversao manual
                    $init =  $item->{'media$group'}->{'yt$duration'}->{'seconds'};
                    $hours = floor($init / 3600);
                    $minutes = floor(($init / 60) % 60);
                    $seconds = $init % 60;

                    echo "$hours:$minutes:$seconds";
            */
            ?>



            <?php //echo $item->link[0]->{'href'}; ?>
        </div>

    </div>

    <?php
    if ($i == 1) break;
    $i++;
    ?>


    <?php endforeach;
    endif; // youtube end
    ?>
