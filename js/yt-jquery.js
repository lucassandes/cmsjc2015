/**
 *  Plugin which renders the YouTube channel videos list to the page
 *  @author:  H. Yankov (hristo.yankov at gmail dot com)
 *  @version: 1.0.0 (Nov/27/2009)
 *    http://yankov.us
 *
 *  Modified by Dan Hounshell (Jan/2010) to work for favorites or
 *  uploads feeds and simplified output
 *
 *  Modified by Dan Hounshell (Feb/2012) to show player for first video
 *  and change player to show feed item clicked. Cleaned up code a bit.
 */

(function($) {
    $.fn.youTubeChannel = function(options) {

        var videoDiv = $(this);

        $.fn.youTubeChannel.defaults = {
            userName: "camarasjc",
            channel: "uploads", //options are favorites or uploads
            loadingText: "Carregando...",
            showPlayer: false,
            playerWidth: "500",
            playerHeight: "355",
            numberToDisplay: 3,
            linksInNewWindow: true,
            hideAuthor: true
        }

        var __opts = $.extend({}, $.fn.youTubeChannel.defaults, options);

        return this.each(function() {
            if (__opts.userName != null) {
                if (__opts.showPlayer) {
                    videoDiv.append("<div id='ytPlayer'></div>");
                }
                videoDiv.append("<div id=\"channel_div\" ></div>");
                $("#channel_div").hide();

                var preLoaderHTML = $("<p id=\"yt_loader\" class=\"loader\">" + __opts.loadingText + "</p>");
                videoDiv.append(preLoaderHTML);

                // TODO: Error handling!
                $.ajax({
                    // url: "http://gdata.youtube.com/feeds/base/users/"+__opts.userName + "/"+__opts.channel+"?alt=json",
                    url:"http://gdata.youtube.com/feeds/api/users/camarasjc/uploads?v=2&alt=json",
                    cache: true,
                    dataType: 'jsonp',
                    success: jQueryYouTubeChannelReceiveData
                });
            }
        });

        function jQueryYouTubeChannelReceiveData(data) {

            var cnt = 0;

            $.each(data.feed.entry, function(i, e) {
                if (cnt < __opts.numberToDisplay) {
                    var parts = e.id.$t.split(':');
                    var videoId = parts[parts.length-1];

                    var out = '<div class="video col-md-2 col-xs-4"><a rel="' +
                        videoId + '" class="ytLink" ';
                    if (!__opts.showPlayer) {
                        out = out + 'href="http://www.youtube.com/v/' + videoId + '&hl=en_US&fs=1" ';
                    }
                    out = out + '><img src="http://i.ytimg.com/vi/' +
                    videoId + '/mqdefault.jpg" class="img-responsive" /></a><br /><h5 rel="' +
                    videoId + '" class="ytLink hidden">' + e.title.$t + '</h5><h6 class="hidden">' + e.media$group.media$description.$t + '</h6>';
                    if (!__opts.hideAuthor) {
                        out = out + 'Author: ' + e.author[0].name.$t + '';
                    }
                    out = out + '</div>';
                    $("#channel_div").append(out);



                    if (cnt == 0 && __opts.showPlayer){
                      //  console.log('Titulo: ' + e.title.$t);
                       // console.log('Descricao: ' +e.media$group.media$description.$t);
                        //updateYouTubePlayer("#ytPlayer", videoId,  e.title.$t,  e.media$group.media$description.$t );

                        updateYouTubePlayer("#ytPlayer", videoId,  e.title.$t,  e.media$group.media$description.$t );

                    }

                    cnt = cnt + 1;
                }

            });



            // Open in new tab?
            if (!__opts.showPlayer && __opts.linksInNewWindow) {
                $("#channel_div").find("li > a").attr("target", "_self");
            }

            // Remove the preloader and show the content
            $("#yt_loader").remove();

            $("#channel_div").show();


            if (__opts.showPlayer) {
                $("a.ytLink").each(function(){
                    $(this).css("cursor", "pointer");
                    $(this).click(function(){



                        ytVid = $(this).attr("rel");
                         ytTitle = $(this).parent().children('h5').text();
                         ytDescritpion = $(this).parent().children('h6').text();

                        updateYouTubePlayer("#ytPlayer", ytVid, ytTitle, ytDescritpion );

                    });
                });
            }

        };

        function updateYouTubePlayer(div, vidId, vidTitle, vidDescription) {

            var code = "<div class=\"col-md-6  video-highlight \" >";
            code = code + ' <div class="embed-responsive embed-responsive-16by9" style="height:100%">';
            code =  code +"<iframe class=\"embed-responsive-item\" src='//www.youtube.com/embed/" + vidId + "'";
            code = code + 'frameborder="0"  allowfullscreen></iframe>';
            code = code +" </div></div>";

            code = code + "<div id=\"videos-recentes\" class=\"col-md-6 right-content\" >";
            code = code + "<h3>"+vidTitle+"</h3>";
            code = code + "<p>"+vidDescription+"</p> "
            code = code + " <h4>Últimos vídeos da TV Câmara</h4></div>";
            console.log(code);


            $(div).html(code);

        };


    };



})(jQuery);