var passo2 = {

	init: function(id){
		passo2.sort();
		
		new SWFUpload({
			upload_url: "upload.php",
			post_params: {"id": id},
			file_size_limit : "2 MB",
			file_types : "*.jpg; *.jpeg; *.gif",
			file_types_description : "Images",
			file_upload_limit : "0",
			file_queue_error_handler : passo2.fileQueueError,
			file_dialog_complete_handler : passo2.fileDialogComplete,
			upload_progress_handler : passo2.uploadProgress,
			upload_error_handler : passo2.uploadError,
			upload_success_handler : passo2.uploadSuccess,
			upload_complete_handler : passo2.uploadComplete,
			button_placeholder_id : "botao",
			button_width: 230,
			button_height: 45,
			button_text_top_padding: 10,
			button_text_left_padding: 10,
			button_text : '<span class="button">Selecione as Imagens (2 MB Max)</span>',
			button_text_style : '.button { font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; font-size: 14px; }',
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			flash_url : "../../library/plugins/jquery/swfupload/swfupload.swf",
			debug: false
		});
	},

	sort: function(){
		$(".item").Sortable({
			accept: "area",
			handle: ".carregando",
			opacity: 0.8,
			fx: 200,
			axis: "vertically",
			revert: true
		});
	},
	
	fileQueueError: function(file, errorCode, message){
		passo2.box(file).remove();
	},

	fileDialogComplete: function(numFilesSelected, numFilesQueued){
		if(numFilesQueued > 0){
			this.startUpload();
		}
	},
	
	uploadProgress: function(file, bytesLoaded){
		$("span", passo2.box(file)).text(Math.ceil((bytesLoaded / file.size) * 100) + "%");
	},
	
	uploadError: function(file, errorCode, message){
		passo2.box(file).remove();
	},
	
	uploadSuccess: function(file, serverData){
		if(serverData){
			var obj = $.parseJSON(serverData);
			$(".carregando", passo2.box(file)).attr("src", obj.img);
			$("input[type=hidden]", passo2.box(file)).val(obj.id);
			$("span", passo2.box(file)).remove();
			passo2.sort();
		}else{
			passo2.box(file).remove();
		}
	},
	
	uploadComplete: function(file){
		if(this.getStats().files_queued > 0){
			this.startUpload();
		}
	},
	
	box: function(file){
		var div = $("#item-" + file.id);
		if(div.html() == null){
			var template = '<div class="area" id="item-' + file.id + '">';
			template += '<input type="hidden" name="hidID[]" />';
			template += '<table width="100%">';
			template += '<tr>';
			template += '<td width="150" align="center"><img class="carregando" style="cursor:move;" src="../imgs/icones/carregando.gif" alt="" title="" /><br /><span>0%</span></td>';
			template += '<td><label>Legenda: <input type="text" size="60" maxlength="150" name="txtLegenda[]" /></label></td>';
			template += '<td width="110" align="right"><a href="javascript:void(0);" onclick="passo2.remove(\'' + file.id + '\');"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a></td>';
			template += '</tr>';
			template += '</table>';
			template += '</div>';
			div = $(template).prependTo(".item");
		}
		return div;
	},
	
	remove: function(id){
		if(conf()){
			$("#item-" + id).remove();
		}
	}
}