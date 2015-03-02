(function($){

	$.fn.moveScroll = function(options){
		
		var options = $.extend({}, $.fn.moveScroll.defaults, options);
		
		function newPos(ini, end, scroll, speed){
			
			var pos = null;
			
			ini = Number(ini);
			end = Number(end);
			speed = Number(speed);
			
			if(ini > end)
			{
				pos = (ini + (scroll * (-speed / 10)));
				pos = ((pos < end) ? end : pos);
			}
			else
			{
				pos = (ini + (scroll * (speed / 10)));
				pos = ((pos > end) ? end : pos);
			}
			
			return pos;
		}
		
		function newBackgroundAnimate(width, max, scroll, speed){
		
			var pos = null;
			
			width = Number(width);
			max = Number(max) - 1;
			scroll = Number(scroll);
			speed = Number(speed);
			
			if(scroll >= 0)
			{
				pos = -width * Math.round((max * Math.round(scroll * speed / 10)) / 100);
				pos = ((pos < max * -width) ? max * -width : pos);
			}
			
			return pos;
		}
		
		function newBackgroundImage(path, ext, count, scroll, speed){
		
			var pos = 1;
		
			count = Number(count);
			scroll = Number(scroll);
			speed = Number(speed);
			
			if(scroll >= 0)
			{
				pos = Math.round((count * Math.round(scroll * speed / 10)) / 100);
				pos = ((pos > count) ? count : pos);
				pos = ((pos < 1) ? 1 : pos);
			}
			
			return path + pos + "." + ext;
		}
		
		return this.each(function(){
			
			var o = $(this);
			var metadata = o.metadata();
			var parent = $((metadata.parent) ? metadata.parent : this);
			
			$(window).scroll(move).resize(move).load(move);
			
			parent.bind("inview", function(event, visible){
    			if(visible){
      				parent.addClass("inview");
    			}else{
      				parent.removeClass("inview");
    			}
  			});
  			
			function move(){
				
				var scroll = $(window).scrollTop() + options.scroll();
				if(scroll > 0){
					var a = {};
					var c = {};
					
					var height = newPos(metadata.heightIni, metadata.heightEnd, scroll, metadata.speed);
					var width = newPos(metadata.widthIni, metadata.widthEnd, scroll, metadata.speed);
					var top = newPos(metadata.topIni, metadata.topEnd, scroll, metadata.speed);
					var right = newPos(metadata.rightIni, metadata.rightEnd, scroll, metadata.speed);
					var bottom = newPos(metadata.bottomIni, metadata.bottomEnd, scroll, metadata.speed);
					var left = newPos(metadata.leftIni, metadata.leftEnd, scroll, metadata.speed);
					var marginTop = newPos(metadata.marginTopIni, metadata.marginTopEnd, scroll, metadata.speed);
					var marginRight = newPos(metadata.marginRightIni, metadata.marginRightEnd, scroll, metadata.speed);
					var marginBottom = newPos(metadata.marginBottomIni, metadata.marginBottomEnd, scroll, metadata.speed);
					var marginLeft = newPos(metadata.marginLeftIni, metadata.marginLeftEnd, scroll, metadata.speed);
					var backgroundX = newPos(metadata.backgroundXIni, metadata.backgroundXEnd, scroll, metadata.speed);
					var backgroundY = newPos(metadata.backgroundYIni, metadata.backgroundYEnd, scroll, metadata.speed);
					var backgroundAnimate = newBackgroundAnimate(parent.width(), metadata.backgroundAnimate, parent.data("inview_height_center"), metadata.speed);
					var backgroundImage = newBackgroundImage(metadata.backgroundImagePath, metadata.backgroundImageExt, metadata.backgroundImageCount, parent.data("inview_height_center"), metadata.speed);
					
					if(jQuery.isNumeric(height)) a.height = height;
					if(jQuery.isNumeric(width)) a.width = width;				
					if(jQuery.isNumeric(top)) a.top = top;
					if(jQuery.isNumeric(right)) a.right = right;
					if(jQuery.isNumeric(bottom)) a.bottom = bottom;
					if(jQuery.isNumeric(left)) a.left = left;
					if(jQuery.isNumeric(marginTop)) a.marginTop = marginTop;
					if(jQuery.isNumeric(marginRight)) a.marginRight = marginRight;
					if(jQuery.isNumeric(marginLeft)) a.marginLeft = marginLeft;
					if(jQuery.isNumeric(marginBottom)) a.marginBottom = marginBottom;
					if(jQuery.isNumeric(backgroundX)) c.backgroundPosition = backgroundX + "px " + ((metadata.backgroundXRefY) ? metadata.backgroundXRefY : " top");
					if(jQuery.isNumeric(backgroundY)) c.backgroundPosition = ((metadata.backgroundYRefX) ? metadata.backgroundYRefX : "center ") + backgroundY + "px";
					if(jQuery.isNumeric(backgroundAnimate)) c.backgroundPosition = backgroundAnimate + "px top";
					if(jQuery.isNumeric(metadata.backgroundImageCount)) c.backgroundImage = "url('" + backgroundImage + "')";
					
					if(parent.hasClass("inview")){
						o.css(c);
						o.stop().animate(a);
					}
				}
			};
		});
	};
	
	$.fn.moveScroll.defaults = {
		scroll: function(){ return 0; }
	};
})(jQuery);