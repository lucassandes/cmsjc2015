<div class="container-box tv-camara-widget">
    <div class="row">
        <div id="youtubevideos"></div>
        <p class="text-right" style="margin-right: 15px;">Veja todos os vídeos em nosso
            <a href="https://www.youtube.com/user/camarasjc" target="_blank">
                canal do YouTube</a></p>
    </div>

</div>


<!-- YOUTUBE -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#youtubevideos').youTubeChannel({
            userName: 'camarasjc',
            showPlayer: true,
            playerWidth: "600",
            playerHeight: "400",
            channel: "uploads",
            hideAuthor: true,
            numberToDisplay: 3,
            linksInNewWindow: false
        });
    });

</script>
