<?php
/**
 * Created by PhpStorm.
 * User: lvmsandes
 * Date: 12/05/2015
 * Time: 09:07
 */
?>


<?php

$apikey = "AIzaSyCsrbmbGijIoCc62tjFnNdn6ngHp9Dn8oA";
$playlist_id = "PLey9M_cWIxnncEBZcO5flLXumZY2zDq03";
$max_results = 2;
//$query = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=$search&maxResults=100&videoCategoryId=$category&safesearch=strict&part=contentDetails&key=$apikey";
$json_file3 = file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=' . $max_results . '&playlistId=' . $playlist_id . '&part=contentDetails&key=' . $apikey);
//https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=PLey9M_cWIxnncEBZcO5flLXumZY2zDq03&part=contentDetails&key=AIzaSyCsrbmbGijIoCc62tjFnNdn6ngHp9Dn8oA
$jfo3 = json_decode($json_file3, true);
$i = 0;
if (count($jfo3)):
   foreach ($jfo3['items'] as $val) {

        $title = $val['snippet']['title'];
        $id = $val['snippet']['resourceId']['videoId'];
        $thumbnail_url = $val['snippet']['thumbnails']['medium']['url'];
        $link = "http://www.youtube.com/watch?v=" . $id;
        ?>
        <div class="col-xs-6 ">

            <?php
            if ($i == 0) {
                echo '<div class="container-box " style="margin-left:-15px;  padding-right: 0; ">';
                $i++;
            } else {
                echo ' <div class="container-box " style="margin-left:0px; margin-right: -15px; ">';
            }
            ?>

            <a href="<?php echo $link; ?>" data-toggle="lightbox"
               data-gallery="youtubevideos"
               data-width="840">
                <img src="<?php echo $thumbnail_url; ?>"
                     class="img-responsive center-block"/>
                        <span class="assista-agora hidden-xs"> <span class="glyphicon glyphicon-play"
                                                                     aria-hidden="true"></span> &nbsp;Assista agora</span>

                <!--<div class="duracao pull-right"> 11:12</div> -->
            </a>

            <a href="<?php echo $link; ?>" data-toggle="lightbox"
               data-gallery="youtubevideos"
               data-width="840"><h3><?php echo $title; ?></h3>
            </a>
        </div>

        </div>
    <?php
    }
else:

echo '<div class="alert alert-danger" role="alert"><strong>Ocorreu um erro</strong> na hora de exibir os vídeos. Por favor, tente novamente mais tarde</div>';
endif;
?>
