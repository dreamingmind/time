$(document).ready(function () {
	
	sum = new Summary('div.time');
	var block = $(sum.summaryblock);
	block.find('span.sortkey').html(sum.sortChoices(sum.keys));
	block.find('select').on('change', function(){
		var index = sum.indexOf(sum.keys, $(this).val());
		var values = sum.keys[index].values;
		block.find('span.sortkeyvalue').html(sum.sortChoices(values));
	});
	
	$('div#report').append(block);
	
//	alert(sum.available(sum.keys));
	
//	var target = 'div.time';
//	var members = [];
//	var exemplars = $(target);
//	
//	if (exemplars.length > 0) {
//		var candidates = $(exemplars[0]).children('aside.keys').children('span');
//		var j = candidates.length;
//		for (var i = 0; i < j; i++) {
//			members.push($(candidates[i]).attr('class'));
//		}
//	}
	var x = 'x';
	
});

Summary = function(target) {
	
	this.initSummaryValues = function(key) {
		var rawValues = $(this.target).children('aside.keys').children('span[class="'+key+'"]');
		var result = [];
		var exists = {};
		var j = rawValues.length;
		for(var i = 0; i < j; i++) {
			var value = $(rawValues[i]).html();
			if (typeof(exists[value]) === 'undefined') {
				exists[value] = true;
				result.push({
					'name': value,
					'used': false // needs a system to set this
				});
			}
		}
		return result;
	}
	
	this.target = target;
	this.keys = [];
	
	var keyExemplars = $(target);
	// make array of sortkeys
	if (keyExemplars.length > 0) {
		var candidates = $(keyExemplars[0]).children('aside.keys').children('span');
		var j = candidates.length;
		for (var i = 0; i < j; i++) {
			var key = $(candidates[i]).attr('class');
			var values = this.initSummaryValues(key);
			this.keys.push({
				'name': key,
				'used': false, // needs a system to set this
				'values': values // needs system to set values
			});
			this.keys[this.keys.length -1].availableValues = this.available(this.keys[this.keys.length -1].values);
		}
	};
				
				
}
	

Summary.prototype = {
	
	indexOf: function(set, value) {
		var limit = set.length;
		for(var i = 0; i < limit; i++) {
			if (set[i].name == value) {
				return i;
			}
		}
		return false;
	},
	
	available: function(set) {
		var result = [];
		var limit = set.length;
		for(var i = 0; i < limit; i++) {
			if (!set[i].used) {
				result.push(set[i].name);
			}
		}
		return result;
	},
	
	'summaryblock': "<section class=\"subsummary\"><header><span class=\"sortkey\"></span><span class=\"sortkeyvalue\"></span><span class=\"summaryvalue\"></span></header><section class=\"records\"><!-- records or subsummary sections to summarize --></section></section>",
	
	sortChoices: function(set) {
		var keys = this.available(set);
		var j = keys.length;
		var options = '<option value="">Select a sort key</option>';
		for (var i = 0; i < j; i++) {
			options += '<option value="'+keys[i]+'">'+keys[i]+'</option>';
		}
		return '<select>'+options+'</select>';
	}
	
//	<select id="TimeTimeOutMeridian" name="data[Time][time_out][meridian]">
//<option value="am">am</option>
//<option selected="selected" value="pm">pm</option>
//</select>
//
//	SortKeys : function (target) {
//		this.keys = {};
//		var exemplars = $(target);
//		var rawMembers = $(target + ' aside.keys > span').attr('class');
//	},
//	SortKey: function (name, used) {
//		this.name = name;
//		this.used = typeof(used) === 'undefined' ? false : used;
//	},
//	SortKeyValue: function (name, used) {
//		this.name = name;
//		this.used = typeof(used) === 'undefined' ? false : used;
//	}

}

