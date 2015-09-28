$(document).ready(function () {
	
	sum = new Summary('div.time');
	sum.newSummaryBlock();

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
			var lookups = this.lookupTable(values);
			this.keys.push({
				'name': key,
				'used': false, // needs a system to set this
				'values': values,
				'lookup': lookups
			});
			// add one last property that is the available (unused) values
			this.keys[this.keys.length -1].availableValues = this.available(this.keys[this.keys.length -1].values);
		}
	};
				
	this.keyLookup = this.lookupTable(this.keys);		
}
	

Summary.prototype = {
	
	/**
	 * Get the index of a value on a key
	 * 
	 * @param int|string key The key's index or value
	 * @param string value The value to find an index for
	 * @returns {Boolean|Number}
	 */
	valueLookup: function(key, value) {
		if (parseInt(key) != key) {
			var key = this.keyLookup[key];
		}
		return this.indexOf(this.keys[key].lookup[value]);
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
		var label = '<label>Select a subsummary filter.</label>';
		var options = j === 1 ? [] : ['<option value="">Select a sort key</option>'];
		for (var i = 0; i < j; i++) {
			options.push('<option value="'+keys[i]+'">'+keys[i]+'</option>');
		}
		if (j === 1) {
			options[0] = options[0].replace(/(<option )/, '$1selected="selected" ');
			label = label.replace(/>.*</, '>'+keys[0]+'<');
		}
		return label+'<select>'+options.join('')+'</select>';
	},
	
	newSummaryBlock: function () {
		// make and hold a block
		var block = $(sum.summaryblock);
		// modify it, adding the key select list with its behavior
		block.find('span.sortkey').html(this.sortSelectList(sum.keys));
		block.find('select').on('change', this.sortKeyChange.bind(this));
		// place in the dom
		$('div#report').prepend(block);

	},
	
	sortKeyChange: function(e){
		var choice = $(e.currentTarget).val();
		var index = this.keyLookup[choice];
		this.keys[index].used = true;
		$($(e.currentTarget).siblings('label')[0]).html(choice.toLocaleUpperCase());
		var values = this.keys[index].values;
		$(e.currentTarget).parents('header').find('span.sortkeyvalue').html(this.sortSelectList(values));
		$(e.currentTarget).parents('header').find('span.sortkeyvalue select').on('change', this.sortValueChange.bind(this));
	},
	
	sortValueChange: function(e){
		$($(e.currentTarget).siblings('label')[0]).html($(e.currentTarget).val());

	},
	
	lookupTable: function(subject) {
		var lookup = {};
		var j = subject.length;
		for (var i = 0; i < j; i++) {
			lookup[subject[i].name] = i;
		}
		return lookup;
	}
}

