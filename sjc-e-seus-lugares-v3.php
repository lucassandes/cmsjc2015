<?php
$apikey2 = "AIzaSyCsrbmbGijIoCc62tjFnNdn6ngHp9Dn8oA";
$playlist_id2 = "PLey9M_cWIxnlDTD9M2FYIMdAI7XzvCa_q";
$max_results2 = 3;
$json_file32 = file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=' . $max_results2 . '&playlistId=' . $playlist_id2 . '&part=contentDetails&key=' . $apikey2);
//echo 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=' . $max_results2 . '&playlistId=' . $playlist_id2 . '&part=contentDetails&key=' . $apikey2;
//https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=3&playlistId=PLey9M_cWIxnlDTD9M2FYIMdAI7XzvCa_q&part=contentDetails&key=AIzaSyCsrbmbGijIoCc62tjFnNdn6ngHp9Dn8oA

//var_dump($json_file32);
$jfo32 = json_decode($json_file32, true);
$i = 0;
if (count($jfo32)):
    foreach ($jfo32['items'] as $val2) {

        $title = $val2['snippet']['title'];
        $id = $val2['snippet']['resourceId']['videoId'];
        $thumbnail_url = $val2['snippet']['thumbnails']['medium']['url'];
        $link = "http://www.youtube.com/watch?v=" . $id;
        ?>
        <div class="col-xs-4 ">
            <div class="container-box ">


                <a href="<?php echo $link; ?>" data-toggle="lightbox"
                   data-gallery="youtubevideos"
                   data-width="840">
                    <img src="<?php echo $thumbnail_url; ?>"
                         class="img-responsive "/>


                    <!--<div class="duracao pull-right"> 11:12</div> -->
                </a>


            </div>

        </div>
    <?php
    }
else:

    echo '<div class="alert alert-danger" role="alert"><strong>Ocorreu um erro</strong> na hora de exibir os v�deos. Por favor, tente novamente mais tarde ou <a href="https://www.youtube.com/playlist?list=PLey9M_cWIxnlDTD9M2FYIMdAI7XzvCa_q">veja os v�deos em nosso canal do youtube</a></div>';
endif;
?>
