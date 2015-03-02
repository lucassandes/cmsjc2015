var mask = {
	
	numeric: function(obj){
		var value = obj.value;
		value = value.replace(/\D/g, "");
		obj.value = value;
	},
	
	cpf: function(obj){
		var value = obj.value;
		value = value.replace(/\D/g, "");
	    value = value.replace(/(\d{3})(\d)/, "$1.$2");
	    value = value.replace(/(\d{3})(\d)/, "$1.$2");
	    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
	    obj.value = value;
	},
	
	cnpj: function(obj){
		var value = obj.value;
		value = value.replace(/\D/g, "");
	    value = value.replace(/(\d{2})(\d)/, "$1.$2");
	    value = value.replace(/(\d{3})(\d)/, "$1.$2");
	    value = value.replace(/(\d{3})(\d)/, "$1/$2");
	    value = value.replace(/(\d{4})(\d{1,2})$/, "$1-$2");
	    obj.value = value;
	},
	
	date: function(obj){
		var value = obj.value;
		value = value.replace(/\D/g, "");
		value = value.replace(/(\d{2})(\d)/, "$1/$2");
		value = value.replace(/(\d{2})(\d)/, "$1/$2");
	    obj.value = value;
	},
	
	phone: function(obj){
		var value = obj.value;
		value = value.replace(/\D/g, "");
	    value = value.replace(/(\d{2})(\d)/, "($1) $2");
	    value = value.replace(/(\d{4})(\d)/, "$1-$2");
	    obj.value = value;
	},
	
	cep: function(obj){
		var value = obj.value;
		value = value.replace(/\D/g, "");
    	value = value.replace(/(\d{5})(\d)/, "$1-$2");
    	obj.value = value;
	}
	
};