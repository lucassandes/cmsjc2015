var cropImage = {
	
	o: null,
	URL: null,
	image: null,
	imageURL: null,
	imageSource: null,
	imageWidth: null,
	imageHeight: null,
	width: null,
	height: null,
	x1: null,
	y1: null,
	x2: null,
	y2: null,
	aspectRatio: null,
	minWidth: null,
	minHeight: null,
	maxWidth: null,
	maxHeight: null,
	ias: null,
		
	init: function(o,
				   URL,
				   image,
				   imageURL,
				   imageSource,
				   imageWidth,
				   imageHeight,
				   width,
				   height,
				   x1,
				   y1,
				   x2,
				   y2,
				   aspectRatio,
				   minWidth,
				   minHeight,
				   maxWidth,
				   maxHeight)
	{
		cropImage.o = o;
		cropImage.URL = URL;
		cropImage.image = image;
		cropImage.imageURL = imageURL;
		cropImage.imageSource = imageSource;
		cropImage.imageWidth = imageWidth;
		cropImage.imageHeight = imageHeight;
		cropImage.width = width;
		cropImage.height = height;
		cropImage.x1 = x1;
		cropImage.y1 = y1;
		cropImage.x2 = x2;
		cropImage.y2 = y2;
		cropImage.aspectRatio = aspectRatio;
		cropImage.minWidth = minWidth;
		cropImage.minHeight = minHeight;
		cropImage.maxWidth = maxWidth;
		cropImage.maxHeight = maxHeight;
		
		var w, h;
		w = ((parseInt(imageWidth) < 100) ? 100 : parseInt(imageWidth)) + 40;
		w = ((w < 990) ? w : 990);
		h = ((parseInt(imageHeight) < 40) ? 40 : parseInt(imageHeight)) + 100;
		h = ((h < 600) ? h : 600);

		$(".recortar-imagem").remove();
		var pop = $('<div class="recortar-imagem"><div class="imagem"></div><div class="recortar"></div></div>').css({width: w + "px", height: h + "px"});
		var img = $("<img />").attr("src", imageURL).appendTo($(".imagem", pop));
		var a = $('<a href="javascript:void(0);"><img title="Recortar" alt="Recortar" src="' + URL + 'imgs/botoes/recortar.png" /></a>').appendTo($(".recortar", pop)).click(cropImage.cut);
		
		var options = {
			instance: true,
			handles: true,
			parent: pop,
			x1: x1,
			y1: y1,
			x2: x2,
			y2: y2,
			aspectRatio: aspectRatio,
			minWidth: minWidth,
			minHeight: minHeight,
			maxWidth: maxWidth,
			maxHeight: maxHeight
		};
		
		pop.popup();
		cropImage.ias = img.imgAreaSelect(options);
	},
	
	cut: function(){
		
		var selection = cropImage.ias.getSelection();
		
		var parans = {
			image: cropImage.image,
			imageSource: cropImage.imageSource,
			width: cropImage.width,
			height: cropImage.height,
			newWidth: selection.width,
			newHeight: selection.height,
			x1: selection.x1,
			y1: selection.y1,
			x2: selection.x2,
			y2: selection.y2
		};
		
		$.post(cropImage.URL + "recortar-imagem/recortar.php", parans);
		
		var holder = $(cropImage.o);
		var item = $('<a href="javascript:void(0);"></a>').html(holder.html()).click(function(){
			cropImage.init(
				cropImage.o,
				cropImage.URL,
				cropImage.image,
				cropImage.imageURL,
				cropImage.imageSource,
				cropImage.imageWidth,
				cropImage.imageHeight,
				cropImage.width,
				cropImage.height,
				selection.x1,
				selection.y1,
				selection.x2,
				selection.y2,
				cropImage.aspectRatio,
				cropImage.minWidth,
				cropImage.minHeight,
				cropImage.maxWidth,
				cropImage.maxHeight
			);
		});
		holder.after(item).remove();
		
		$(".recortar-imagem").popupClose();
	}
};