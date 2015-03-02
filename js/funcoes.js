function timeline(){
	var base = $('#scroll').bxSlider({
	    displaySlideQty: 5,
	    moveSlideQty: 5
	});
}

var transparencia = {
    exibirComissao: function(o){
    	var comissao = $(o).val();
        var pregao = $('.li-pregao');
        var outros = $('.tomada-de-preco');
        
    	if(comissao == 1){
    	   pregao.show();
    	   outros.hide();	   
    	}	 
        else if(comissao == 2){
    	   pregao.hide();
    	   outros.show();		       
        }
        else{
    	   pregao.hide();
    	   outros.hide();        
        }
    },
    carregarCargos: function(o){
    	var vinculo = $(o).val();
    	$.get('common/cargos.php', { vinculo : vinculo }, function(data) {
      		$('#ddlCargo').html(data).prepend("<option value='' selected='selected'>Selecione...</option>");
    	}); 
        
        if(vinculo == "comissao")
        { 
            $('.planoCarreira').hide();
            $('.sextaParte').hide();
        }
        else
        {
            $('.planoCarreira').show();
            $('.sextaParte').show();
        }	 
    }
}