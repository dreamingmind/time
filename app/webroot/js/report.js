$(document).ready(function () {
	
	sum = new Summary('div.time');
//	sum.newSummaryBlock();
	var block = $(sum.summaryblock);
	block.find('span.sortkey').html(sum.sortSelectList(sum.keys));
	block.find('select').on('change', function(){
		var index = sum.indexOf(sum.keys, $(this).val());
		var values = sum.keys[index].values;
		block.find('span.sortkeyvalue').html(sum.sortSelectList(values));
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
	
	/**
	 * Make the set of possible values for a given key
	 * 
	 * Keys are the possible subsummary breaks like 'project' or 'user'. 
	 * The values for each are all the distinct values currently on the page. 
	 * 
	 * @param string key
	 * @returns {Summary.initSummaryValues.result|Array}
	 */
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
	
	// the selector to get the records to be summarized
	this.target = target;
	
	// prepare list of possible subsummary breaks
	this.keys = [];
	// each key entry will be an object describing that key and its possible values
	var keyExemplars = $(target);
	if (keyExemplars.length > 0) {
		var candidates = $(keyExemplars[0]).children('aside.keys').children('span');
		var j = candidates.length;
		for (var i = 0; i < j; i++) {
			var key = $(candidates[i]).attr('class');
			var values = this.initSummaryValues(key);
			this.keys.push({
				'name': key,
				'used': false, // needs a system to set this
				'values': values
			});
			this.keys[this.keys.length -1].availableValues = this.available(this.keys[this.keys.length -1].values);
		}
	};
				
				
}
	

Summary.prototype = {
	
	/**
	 * get the index of a key or key's value
	 * 
	 * @param {type} set
	 * @param {type} value
	 * @returns {Boolean|Number}
	 */
	indexOf: function(set, value) {
		var limit = set.length;
		for(var i = 0; i < limit; i++) {
			if (set[i].name == value) {
				return i;
			}
		}
		return false;
	},
	
	/**
	 * Get the index for a the key that = value
	 * 
	 * @param string value The key to find an idex for
	 * @returns {Boolean|Number}
	 */
	keyIndex: function(value) {
		return this.indexOf(this.keys, value);
	},
	
	/**
	 * Get the index of a value on a key
	 * 
	 * @param int|string key The key's index or value
	 * @param string value The value to find an index for
	 * @returns {Boolean|Number}
	 */
	valueIndex: function(key, value) {
		if (parseInt(key) != key) {
			var key = this.keyIndex(key);
		}
		return this.indexOf(this.keys[key].values);
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
	
	/**
	 * Make a select list from the currently available keys or values on a key
	 * 
	 * If there is only one available option, make it the selection and 
	 * don't have an empty/prompt choice. 
	 * 
	 * @param array set 
	 * @returns {String}
	 */
	sortSelectList: function(set) {
		var keys = this.available(set);
		var j = keys.length;
		var label = '<label> </label>';
		var options = j === 1 ? [] : ['<option value="">Select a sort key</option>'];
		for (var i = 0; i < j; i++) {
			options.push('<option value="'+keys[i]+'">'+keys[i]+'</option>');
		}
		if (j === 1) {
			options[0] = options[0].replace(/(<option )/, '$1selected="selected" ');
			label.replace(/ /, keys[0]);
		}
		return label+'<select>'+options.join('')+'</select>';
	},
	
	newSummaryBlock: function () {
		// make and hold a block
		var block = $(sum.summaryblock);
		// modify it, adding the key select list with its behavior
		block.find('span.sortkey').html(this.sortSelectList(sum.keys));
		block.find('select').on('change', this.sortKeyChange);
		// place in the dom
		$('div#report').append(block);

	},
	
	sortKeyChange: function(e){
		var choice = $(e.currentTarget).val();
		var index = this.keyIndex(choice);
		$(e.currentTarget).sibling('label').html(choice);
		var values = this.keys[index].values;
		block.find('span.sortkeyvalue').html(this.sortSelectList(values));
	},
	
	sortValueChange: function(e){
		var keyIndex = this.keyIndex($(e.currentTarget).sibling('span.sortkey').val());
		
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

