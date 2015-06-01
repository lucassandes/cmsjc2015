var playListURL = 'http://gdata.youtube.com/feeds/api/playlists/PLey9M_cWIxnl4QppWqPmUITXzH_ECajoG?v=2&alt=json&callback=?';
var videoURL= 'http://www.youtube.com/watch?v=';
$.getJSON(playListURL, function(data) {
    var list_data="";
    var i = 0;
    $.each(data.feed.entry, function(i, item) {
        var feedTitle = item.title.$t;
        var feedURL = item.link[1].href;
        var fragments = feedURL.split("/");
        var videoID = fragments[fragments.length - 2];
        var url = videoURL + videoID;
        var thumb = "http://img.youtube.com/vi/"+ videoID +"/mqdefault.jpg";
        list_data += '<div class="col-xs-6 " >';

        if(i==0) {
            list_data +='    <div class="container-box" style="margin-left:-15px;  padding-right: 0;">';
        }
        else {
            list_data +='    <div class="container-box" style="margin-left:15px; margin-right: -15px;  ">';
        }

        list_data +='       <img src="'+ thumb +'" alt="'+ feedTitle+'" class="img-responsive center-block"/>';
        list_data +='       <h3>'+ feedTitle +'</h3>';
        list_data +='   </div>';
        list_data +='</div>';


        if(i==1){
            return false;
        }
        i++;



    });
    $(list_data).appendTo(".de-olho-na-cidade-feed");
});