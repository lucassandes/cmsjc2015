(function($) {
	$.fn.datePicker = function(settings) {
		
		//settings
		settings = jQuery.extend({
			dayOfWeek: new Array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"),
			monthOfYear: new Array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"),
			txtOf: "de",
			txtToday: "Hoje",
			current: null,
			format: "d/m/Y",
			target: null,
			position: "r",
			fixed: false,
			eventName: "click",
			dateRange: null
		}, settings);
		
		//analisa data
		function parseDate(date, format){
			if (date.constructor == Date) {
				return new Date(date);
			}
			var parts = date.split(/\W+/);
			var against = format.split(/\W+/), d, m, y, h, min, now = new Date();
			for (var i = 0; i < parts.length; i++) {
				switch (against[i]) {
					case 'd':
					case 'e':
						d = parseInt(parts[i],10);
						break;
					case 'm':
						m = parseInt(parts[i], 10)-1;
						break;
					case 'Y':
					case 'y':
						y = parseInt(parts[i], 10);
						y += y > 100 ? 0 : (y < 29 ? 2000 : 1900);
						break;
					case 'H':
					case 'I':
					case 'k':
					case 'l':
						h = parseInt(parts[i], 10);
						break;
					case 'P':
					case 'p':
						if (/pm/i.test(parts[i]) && h < 12) {
							h += 12;
						} else if (/am/i.test(parts[i]) && h >= 12) {
							h -= 12;
						}
						break;
					case 'M':
						min = parseInt(parts[i], 10);
						break;
				}
			}
			return new Date(
				y === undefined ? now.getFullYear() : y,
				m === undefined ? now.getMonth() : m,
				d === undefined ? now.getDate() : d,
				h === undefined ? now.getHours() : h,
				min === undefined ? now.getMinutes() : min,
				0
			);
		};
		
		//analisa número
		function intval(v){
			v = parseInt(v);
			return isNaN(v) ? 0 : v;
		}
		
		//pega a posição
		function getPos(e){
			var l = 0;
			var t  = 0;
			var w = intval(jQuery.css(e,'width'));
			var h = intval(jQuery.css(e,'height'));
			var wb = e.offsetWidth;
			var hb = e.offsetHeight;
			while (e.offsetParent){
				l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
				t += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
				e = e.offsetParent;
			}
			l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
			t  += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
			return {x:l, y:t, w:w, h:h, wb:wb, hb:hb};
		};
		
		//formata a data
		function formatDate(date, format){
			var m = date.getMonth();
			var d = date.getDate();
			var y = date.getFullYear();
			var w = date.getDay();
			var s = {};
			var hr = date.getHours();
			var pm = (hr >= 12);
			var ir = (pm) ? (hr - 12) : hr;
			if (ir == 0) {
				ir = 12;
			}
			var min = date.getMinutes();
			var sec = date.getSeconds();
			var parts = format.split(''), part;
			for ( var i = 0; i < parts.length; i++ ) {
				part = parts[i];
				switch (parts[i]) {
					case 'a':
						part = date.getDayName();
						break;
					case 'A':
						part = date.getDayName(true);
						break;
					case 'b':
						part = date.getMonthName();
						break;
					case 'B':
						part = date.getMonthName(true);
						break;
					case 'C':
						part = 1 + Math.floor(y / 100);
						break;
					case 'd':
						part = (d < 10) ? ("0" + d) : d;
						break;
					case 'e':
						part = d;
						break;
					case 'H':
						part = (hr < 10) ? ("0" + hr) : hr;
						break;
					case 'I':
						part = (ir < 10) ? ("0" + ir) : ir;
						break;
					case 'k':
						part = hr;
						break;
					case 'l':
						part = ir;
						break;
					case 'm':
						part = (m < 9) ? ("0" + (1+m)) : (1+m);
						break;
					case 'M':
						part = (min < 10) ? ("0" + min) : min;
						break;
					case 'p':
					case 'P':
						part = pm ? "PM" : "AM";
						break;
					case 's':
						part = Math.floor(date.getTime() / 1000);
						break;
					case 'S':
						part = (sec < 10) ? ("0" + sec) : sec;
						break;
					case 'u':
						part = w + 1;
						break;
					case 'w':
						part = w;
						break;
					case 'y':
						part = ('' + y).substr(2, 2);
						break;
					case 'Y':
						part = y;
						break;
				}
				parts[i] = part;
			}
			return parts.join('');
		};
		
		//verifica object dentro do outro
		function isChildOf(parentEl, el, container) {
			if (parentEl == el) {
				return true;
			}
			if (parentEl.contains) {
				return parentEl.contains(el);
			}
			if ( parentEl.compareDocumentPosition ) {
				return !!(parentEl.compareDocumentPosition(el) & 16);
			}
			var prEl = el.parentNode;
			while(prEl && prEl != container) {
				if (prEl == parentEl)
					return true;
				prEl = prEl.parentNode;
			}
			return false;
		};
		
		//posiciona
		function position(calendar, ref){
			var pos = getPos(ref);
			var top = 0;
			var left = 0;
			var margem = 5;
			switch(settings.position)
			{
				case "t":
					top = (pos.y - calendar.height() - margem);
					left = pos.x;
					break;
				case "b":
					top = (pos.y + pos.h + margem);
					left = pos.x;
					break;
				case "l":
					top = pos.y;
					left = (pos.x - calendar.width() - margem);
					break;
				case "r":
					top = pos.y;
					left = (pos.x + pos.w + margem);
					break;
			}
			calendar.css({top: top, left: left, position: "absolute"});
		};
				
		//verifica período da data
		function checkDate(date, settings){
			var format = settings.format;
			var dateRange = settings.dateRange;
			if(!dateRange)
			{
				return true;
			} 
			
			var v1 = ((dateRange[0]) ? parseDate(((typeof dateRange[0] == "string") ? dateRange[0] : $(dateRange[0]).val()), format) : null); 
			var v2 = ((dateRange[1]) ? parseDate(((typeof dateRange[1] == "string") ? dateRange[1] : $(dateRange[1]).val()), format) : null);
			if((isNaN(v1) && isNaN(v2)) || (v1 == null && v2 == null))
			{
				return true;
			}
			
			if(v1 && !v2)
			{
				return (v1 <= date);
			}
			else if(!v1 && v2)
			{
				return (v2 >= date);
			}
			else
			{
				return (v1 <= date && v2 >= date);
			}
		};
		
		//retorno
		return this.each(function(){
			
			//verifica data
			if (!settings.current){
				settings.current = new Date();
			}else{
				settings.current = parseDate(settings.current, settings.format);
			}
			
			var jQueryMatchedObj = this;
			var target = $(((settings.target) ? settings.target : jQueryMatchedObj));
			var div = null;
			var date = new Date(settings.current);
			
			//atualziar data
			function refreshDate(){
				var val = target.val();
				if(!val){
					return false;
				}
				
				var newDate = parseDate(val, settings.format);
				if(newDate != date && !isNaN(newDate)){
					date = new Date(newDate);
					settings.current = new Date(newDate);
					create();
				}
			}
			
			//mostra
			function show(){
				if(!settings.fixed){
					position(div, jQueryMatchedObj);
					$(document).bind("mousedown", {cal: div, trigger: this}, hide);
				}
				refreshDate();
				div.show();
			}
			
			//esconde
			function hide(ev){
				if(!settings.fixed){
					if ((typeof ev == "undefined") || (ev.target != ev.data.trigger && !isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0)))) {
						div.hide();
						$(document).unbind("mousedown", hide);
					}
				}
			}
			
			//mês anteriror		
			function previous(){
				date.setMonth(date.getMonth() - 1);
				create();
			}
			
			//próximo mes
			function next(){
				date.setMonth(date.getMonth() + 1);
				create();
			}
			
			//seleciona o dia
			function setDay(){
				$(".sel", div).removeClass("sel");
				$(this).addClass("sel");
				date.setDate($(this).html());
				target.val(formatDate(date, settings.format));
				hide();
			}
			
			//selecione o dia de hoje
			function setToday(){
				if(new Date() != date){
					date = new Date();
					settings.current = new Date();
					create();
				}
			}
			
			//cria o calendário
			function create(){
				
				//data
				date.setDate(1);
				var weekday = date.getDay();
				var day = date.getDate();
				var month = date.getMonth();
				var year = date.getFullYear();
				
				//base
				if(!div){
					div = $('<div class="datepicker"></div>').hide();
					div.appendTo(((settings.fixed) ? $(jQueryMatchedObj) : $("body")));
				}
				div.html("");
				var table = $('<table></table>').appendTo(div);
				var thead = $('<thead></thead>').appendTo(table);
				var tbody = $('<tbody></tbody>').appendTo(table);
				
				//mês
				var thead_tr = $('<tr></tr>').appendTo(thead);
				var thead_tr_td = $('<td colspan="7"></td>').appendTo(thead_tr);
				var thead_tr_td_table = $('<table></table>').appendTo(thead_tr_td);
				var thead_tr_td_table_tr = $('<tr></tr>').appendTo(thead_tr_td_table);
				var thead_tr_td_table_td_anterior = $('<td class="anterior"></td>').appendTo(thead_tr_td_table_tr);
				var thead_tr_td_table_td_anterior_a = $('<a href="javascript:void(0);"></a>').appendTo(thead_tr_td_table_td_anterior).click(previous);;
				var thead_tr_td_table_td_mes = $('<td>' + settings.monthOfYear[month] + ' ' + settings.txtOf + ' ' + year + '</td>').appendTo(thead_tr_td_table_tr);
				var thead_tr_td_table_td_proximo = $('<td class="proximo"></td>').appendTo(thead_tr_td_table_tr);
				var thead_tr_td_table_td_proximo_a = $('<a href="javascript:void(0);"></a>').appendTo(thead_tr_td_table_td_proximo).click(next);
				
				//semana
				var tbody_tr_semana = $('<tr class="semana"></tr>').appendTo(tbody);
				for(var i = 0; i < settings.dayOfWeek.length; i++){
					$('<td>' + settings.dayOfWeek[i] + '</td>').appendTo(tbody_tr_semana);
				}
				
				//colunas em branco
				var tbody_tr = $('<tr></tr>').appendTo(tbody);
				for(var i = 0; i < weekday; i++){
					$('<td>&nbsp;</td>').appendTo(tbody_tr);
				}
				
				//dias
				var dateCalendar = new Date();
				dateCalendar.setDate(1);
				dateCalendar.setMonth(date.getMonth());
				dateCalendar.setFullYear(date.getFullYear());
				var daysOfMonth = 31;
				for(var i = 0; i < daysOfMonth; i++){
					var dayCalendar = dateCalendar.getDate();
					var monthCalendar = dateCalendar.getMonth();
					var yearCalendar = dateCalendar.getFullYear();
					var weekdayCalendar = dateCalendar.getDay();
					var tbody_tr_td = null;
					var tbody_tr_td_a = null;
					if(dayCalendar > i){
						if(weekdayCalendar == 0){
							tbody_tr = $('<tr></tr>').appendTo(tbody);
						}
						if(weekdayCalendar != daysOfMonth){
							tbody_tr_td = $('<td></td>').appendTo(tbody_tr);
							if(checkDate(dateCalendar, settings)){
								tbody_tr_td_a = $('<a href="javascript:void(0);">' + dayCalendar + '</a>').appendTo(tbody_tr_td).click(setDay);
								if(dayCalendar == settings.current.getDate()
								&& monthCalendar == settings.current.getMonth()
								&& yearCalendar == settings.current.getFullYear()){
									tbody_tr_td_a.removeClass("sel").addClass("sel");
								}
							}else{
								tbody_tr_td_span = $('<span>' + dayCalendar + '</span>').appendTo(tbody_tr_td);
							}
						}
					}
					dateCalendar.setDate(dayCalendar + 1);
				}
				
				//footer
				var tfoot = $('<tfoot></tfoot>').appendTo(table);
				var tfoot_tr = $('<tr></tr>').appendTo(tfoot);
				var tfoot_tr_td = $('<td colspan="7"></td>').appendTo(tfoot_tr);
				var tfoot_tr_td_a = $('<a href="javascript:void(0);">' + settings.txtToday + '</a>').appendTo(tfoot_tr_td).click(setToday);
			}
			
			create();
			div.hide();
			
			//ao clicar abre o calendário caso não for fixo
			if(!settings.fixed){
				$(jQueryMatchedObj).bind(settings.eventName, show);
			}else{
				show();
			}
			
		});
	};
})(jQuery);