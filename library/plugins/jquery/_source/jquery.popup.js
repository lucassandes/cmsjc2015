(function($){

	$.fn.popup = function(settings){

		//settings
		settings = jQuery.extend({
			fade: false,
			overlayBgColor: "#000000",
			overlayOpacity:	0.8,
			top: false,
			objectClose: null,
			objectHide: false,
			width: false,
			height: false,
			close: true
		}, settings);
		
		//objects
		var o = this;
		var overlay = null;
		
		//init
		function init(){
			setInterface();
			setHide();
			show();
		}
		
		//setInterface
		function setInterface(){
			
			//overlay
			overlay = (($.find("#jquery-popup-overlay") != "") ? $("#jquery-popup-overlay") : $("<div id=\"jquery-popup-overlay\"></div>").appendTo("body"));
			overlay.css({
				backgroundColor: settings.overlayBgColor,
				opacity: settings.overlayOpacity,
				top: 0,
				left: 0,
				position: "fixed",
				zIndex: "200",
				width: "100%",
				height: "100%",
				display: "none"
			});
			
			//box
			o.appendTo("body");
			o.css({
				position: "absolute",
				zIndex: "300",
				marginLeft: -(((settings.width) ? settings.width : o.width()) / 2),
				marginTop: -(((settings.height) ? settings.height : o.height()) / 2) + ((document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop),
				left: "50%",
				top: "50%",
				display: "none"
			});
			
			if(settings.top){
				o.css({
					marginTop: settings.top,
					top: 0
				});
			}
		}
		
		//setHide
		function setHide(){
			
			if(settings.close){
				
				//overlay
				overlay.click(hide);
				
				//keydown
				$(document).keydown(keydown);
				
			}else{
				
				//overlay
				overlay.unbind("click");
				
				//keydown
				$(document).unbind("keydown");
			}
			
			//objectClose
			if(settings.objectClose){
				$(settings.objectClose, o).unbind("click").click(hide);
			}
		}
		
		function keydown(e){
			var code = ((e.keyCode) ? e.keyCode : e.which);
			if(code == 27){
				$(document).unbind("keydown", keydown);
				hide();
			}
		}
		
		//show
		function show(){
			if(settings.objectHide) $("embed, object, select").css("visibility", "hidden");
			
			//fade
			if(settings.fade){
				overlay.fadeIn();
				o.fadeIn();
			}else{
				overlay.show();
				o.show();
			}
		}
		
		//hide
		function hide(){
			o.popupClose(settings);
		}
		
		init();
	};
	
	$.fn.popupClose = function(settings){
		
		//settings
		settings = jQuery.extend({
			fade: false,
			objectHide: true
		}, settings);
		
		//objects
		var o = this;
		var overlay = (($.find("#jquery-popup-overlay") != "") ? $("#jquery-popup-overlay") : $("<div id=\"jquery-popup-overlay\"></div>").appendTo("body"));
		
		//hide
		function hide(){
			if(settings.objectHide) $("embed, object, select").css("visibility", "visible");
			
			//fade
			if(settings.fade){
				overlay.fadeOut();
				o.fadeOut();
			}else{
				overlay.hide();
				o.hide();
			}
		}
		
		hide();
	};

})(jQuery);