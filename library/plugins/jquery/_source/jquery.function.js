function conf(){
	return confirm("Deseja realmente remover esse registro ?");
}

function init(){
	
	//Formulário - Normal
	$.each($('.form'), function(){
		$(this).validate();
	});
	
	//Formulário - Alert
	$.each($('.formAlert'), function(){
		$(this).validate({
			showErrors: function(errorMap, errorList){
			},
			invalidHandler: function(form, validator){
				if(validator.errorList.length){
					var msg = '';
					for ( var i = 0; validator.errorList[i]; i++ ) {
						var error = validator.errorList[i];
						msg += error.message + "\r\n";
					}
					alert(msg);
				}
			}
		});
	});
	
	//Formulário - Mensagem
	$.each($('.formMensagem'), function(){
		$(this).validate({
			errorContainer:$("#divMensagem"),
			errorLabelContainer: $("ul", "#divMensagem"),
			wrapper: "li"
		});
	});
	
	//textfill
	$('.textfill').each(function(){
		var o = $(this);
		var meta = o.metadata();
		
		if(meta.font && meta.tag){
			o.textfill({maxFontPixels: meta.font, innerTag: meta.tag});
		}
	});

	//MetaData
	$('input, select, textarea').each(function(){
		var o = $(this);
		var meta = o.metadata();
		
		//mascara
		if(meta.mask){
			if(meta.maskInit){
				o.mask(meta.mask, {initMask:true});
			}else{
				o.mask(meta.mask);
			}
		}
		
		//focus
		if(meta.focus){
			o.focus();
		}
		
		//watermark
		if(meta.watermark){
			var cor = (o.css('color') ? o.css('color') : "#666666");			
			o.watermark(meta.watermark, cor);
		}
		
		//price
		if(meta.price){
			o.priceFormat({prefix:''});
		}
		
		//numeric
		if(meta.numeric){
			o.numeric();
		}
		
		//alphanumeric
		if(meta.alphanumeric){
			o.alphanumeric();
		}
		
		//alpha
		if(meta.alpha){
			o.alpha();
		}
		
		//limit
		if(meta.limit){
			if(meta.limitElement){
				o.limit(meta.limit, meta.limitElement);
			}else{
				o.limit(meta.limit);
			}
		}
		
		//colorPicker
		if(meta.colorPicker){
			$(meta.colorPicker).colorPicker({
				color: "#ffffff",
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("div", $(meta.colorPicker)).css("backgroundColor", "#" + hex);
					o.val("#" + hex);
				}
			});
		}
		
		//autocomplete
		if(meta.autocomplete){
			o.autocomplete(meta.autocomplete, {
				maxItemsToShow: 10,
				selectFirst: true,
				minChars: 2,
				onItemSelect: function(li){
					if(li){
						var value = ((!!li.extra) ? li.extra[0] : li.selectValue);
						$(meta.autocompleteItem).val(value);
					}
				}
			});
		}
	});
	
	//calendário
	$("a[class*=datePicker]").each(function(){
		$(this).datePicker({target: $(this).metadata().target});
	});
}

function slideArea(o){
	if($(o).hasClass("menos")){
		$(o).removeClass("menos");
		$(o).parent().next().hide();
	}else{
		$(o).addClass("menos");
		$(o).parent().next().show();
		$("input, select, textarea", $(o).parent().next()).eq(0).focus();
	}
}

function checkAll(o, c){
	var c = ((c == undefined) ? ".cbItem" : c);
	var holder = $(c, $(o).parent().parent().parent().parent()); 
	if(o.checked){
		holder.attr("checked", "checked");
	}else{
		holder.removeAttr("checked");
	}
}

function findSWF(movieName) {
	if (window.document[movieName]) {
  		return window.document[movieName];
  	}
  	if (navigator.appName.indexOf("Microsoft Internet")==-1){
	    if (document.embeds && document.embeds[movieName]){
      		return document.embeds[movieName];
		} 
  	}
  	else{
	    return document.getElementById(movieName);
  	}
}

function searchCEP(container){
	var value = $("#txtCEP, .cep", container).val();
	if(value){
		value = value.replace(/[^\d]*/gi, "");
		if(value.length >= 8){
			$("#txtEndereco, .endereco", container).val("Carregando...");
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep=" + value, function(){
				if(resultadoCEP["resultado"]){
					$("#txtTipoLogradouro, #ddlTipoLogradouro, .tipologradouro", container).val(unescape(resultadoCEP["tipo_logradouro"]));
					$("#txtEndereco, .endereco", container).val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
					$("#txtBairro, .bairro", container).val(unescape(resultadoCEP["bairro"]));
					$("#txtCidade, .cidade", container).val(unescape(resultadoCEP["cidade"]));
					$("#txtEstado, #ddlEstado, #txtUF, #ddlUF, .estado, .uf", container).val(unescape(resultadoCEP["uf"]));
					$("#txtPais, #ddlPais, .pais", container).val((($("#txtPais, #ddlPais, .pais", container).val("BR").length > 0) ? "BR" : "Brasil"));
					$("#txtNumero, .numero", container).focus();
				}else{
					$("#txtEndereco, .endereco", container).val("");
				}
			}); 
		}
	}
}

function number_only(myfield, e){
	var key;
	var keychar;
	var field = myfield;
	
	if (window.event)
	    key = window.event.keyCode;
	else if (e)
	    key = e.which;
	else
	    return true;
	               
	if ((key == null) || (key==37) || (key==39) || (key==8) || (key==46) || (key==27) ) {
	    if (((key==46) || (key==8))) {
	        if (field.value.indexOf('0') > 0) {
	            field.value = '1';
	            return false;
	        }
	    }
	    return true;
	}
	
	if ((key > 47 && key < 58) || (key > 95 && key < 106)) {
	    if ((key == 48 || key == 96) && field.value > 0) {
	        if (field.value > 998)
	            return false;
	            
	        field.value += '0';
	        return false;
	    }
	    else if ((key == 48 || key == 96) && field.value == '') {
	        return false;
	    }
	    
	    return true;
	   
	}else{
	    return false;
	}
}

function addFavorite(title, url){
    if (window.sidebar) window.sidebar.addPanel(title, url,"");
    else if(window.opera && window.print){
        var mbm = document.createElement('a');
        mbm.setAttribute('rel','sidebar');
        mbm.setAttribute('href',url);
        mbm.setAttribute('title',title);
        mbm.click();
    }
    else if(document.all){window.external.AddFavorite(url, title);}
}

function resize(width, height, id){
	width = parseInt(width);
	height = parseInt(height);
	id = ((id == undefined) ? "obj" : id);
	
	window.onresize = onResize;
	window.onshow = onResize;
	window.onload = onResize;
	window.onopen = onResize;
	
	function onResize(){
		var w = (window.innerWidth) ? window.innerWidth : (document.documentElement && document.documentElement.clientWidth) ? document.documentElement.clientWidth : document.body.offsetWidth;
		var h = (window.innerHeight) ? window.innerHeight : (document.documentElement && document.documentElement.clientHeight) ? document.documentElement.clientHeight : document.body.offsetHeight;
		
		if(width > 0 && !isNaN(width)){
			document.getElementById(id).style.width = ((w >= width) ? Math.max(0, 100) + "%" : width + "px");
		}
		if(height > 0 && !isNaN(height)){
			document.getElementById(id).style.height = ((h >= height) ? Math.max(0, 100) + "%" : height + "px");
		}
	}
}

function checkDefault(o){
	var o = $(o);
	var input = o.prev();
	if(input.val() == "1"){
		input.val("0");
		o.removeClass("sel");
	}else{
		input.val("1");
		o.addClass("sel");
	}
}

function increaseFont(container, max, tag){
	tag = ((typeof(tag) == "undefined") ? "*": tag);
	$(tag, container).each(function(){
		var f = Number($(this).css("font-size").replace("px", ""));
		if((f + 1) < max){
			$(this).css("font-size", (f + 1) + "px");
		}
	});
}

function decreaseFont(container, min, tag){
	tag = ((typeof(tag) == "undefined") ? "*": tag);
	$(tag, container).each(function(){
		var f = Number($(this).css("font-size").replace("px", ""));
		if((f - 1) > min){
			$(this).css("font-size", (f - 1) + "px");
		}
	});
}

function addDefault(holder){
	var obj = holder.clone();
	$(".add", holder).hide();
	$(".del", holder).show();
	$(".add", obj).show();
	$(".del", obj).hide();
	$(".remove", obj).remove();
	$("input, select, textarea", obj).val("");
	holder.after(obj);
	$("input, select, textarea", obj).eq(0).focus();
}

function delDefault(holder){
	if(confirm("Deseja realmente remover esse item ?")){
		holder.remove();
	}
}