$(document).ready(function () {
	
	sum = new Summary('div.time');
	sum.newSummaryBlock();
	$('#newsummary').on('click', sum.newSummaryBlock.bind(sum));

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
	
	this.setDragDrop();
}
	

Summary.prototype = {
	
	/**
	 * Calculate the total for a node based on it's children
	 * 
	 * @param element parentnode
	 * @returns void
	 */
	total: function(parentnode) {
		var values = $(parentnode).children('*');
		var total = 0;
		var j = values.length;
		for (var i = 0; i < j; i++) {
			total += parseInt($(values[i]).attr('data-seconds'));
		}
		$(parentnode).parent('*').attr('data-seconds', total)
		var decimal = (parseInt(100 * (total / 3600))) / 100;
		$(parentnode).siblings('header').children('span.summaryvalue').html(decimal);
		this.setDragDrop();
	},
	
	/**
	 * Set drag and drop behaviors on appropriate elements
	 * 
	 * establish the drop behavior fo the elements
	 * 
	 * @returns void
	 */
	setDragDrop: function() {
		$( "div.time" ).draggable();
		$( "section.subsummary" ).draggable();
		$( "section.records" ).droppable({
		  drop: function( event, ui ) {
//			  var origin = ui.draggable.parent().parent();
			  ui.draggable.css('position', 'realtive').css('left', '0px').css('top', '0px');
			  $(this).append(ui.draggable);
			  sum.total(this);
//			  $(this).css('background-color', 'rgb('+this.rnd()+', '+this.rnd()+', '+this.rnd()+')');
//			  if (origin.attr('class') == 'subsummary') {
//				  sum.total(origin);
//			  }
		  }
		});
		$( "section.records" ).droppable("option", "tolerance", "pointer" );
	},
	
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
	
	/**
	 * Get the sort keys or values that are available as subsummary breakpoints
	 * 
	 * This tool is not well understood yet. Concept is this: given two 
	 * sort keys (name, project) and two values on each ('jill, jimm) and 
	 * (gardening, galavanting). At the start of a report all keys and values 
	 * are available. In the report:
	 *	prj:Gardening			sum
	 *		name:Jill			sum
	 *		name:Jimm			sum
	 *	prj:Galavanting			sum
	 *		name:Jill			sum
	 *		name:Jimm			sum
	 *	Each block would have a key select and a value select and those lists 
	 *	would contain the choices that are logically unused at that point.
	 *	`available` would track usage and return the choices. But it's not 
	 *	clear what logic would accomplish this. Right now, `available` is 
	 *	tracked on each key and value. But since these can show up multiple 
	 *	times in a reports, some logical cascade must be tracked multiple times.
	 * 
	 * @param {type} set
	 * @returns {Summary.prototype.available.result|Array}
	 */
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
	
	'summaryblock': "<section class=\"subsummary\" data-seconds=\"0\"><header><span class=\"sortkey\"></span><span class=\"sortkeyvalue\"></span><button class=\"load\">Load</button><button class=\"unload\">Unoad</button><span class=\"summaryvalue\"></span></header><section class=\"records droppable\"><!-- records or subsummary sections to summarize --></section></section>",
	
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
	
	/**
	 * Make a color number within 30 values of white
	 * 
	 * @returns Int
	 */
	rnd: function() {
		return parseInt(256 - (30 * Math.random()));
	},
	
	/**
	 * Make a new summary block prepending it to the main report area
	 * 
	 * @returns void
	 */
	newSummaryBlock: function () {
		// make and hold a block of random color
		var block = $(sum.summaryblock);
		block.css('background-color', 'rgb('+this.rnd()+', '+this.rnd()+', '+this.rnd()+')');
		// modify it, adding the key select list with its behavior
		block.find('span.sortkey').html(this.sortSelectList(sum.keys));
		block.find('select').on('change', this.sortKeyChange.bind(this));
		// intitialize the buttons
		block.find('button').prop('disabled', true);
		block.find('button.load').on('change', this.loadMembers.bind(this));
		block.find('button.unload').on('change', this.unloadMembers.bind(this));
		// place in the dom
		$('div#report').prepend(block);
		this.setDragDrop();
	},
	
	/**
	 * Set the 'Load' button behavior
	 * 
	 * Load button is part of a subsummary block. It collects 
	 * members into the block from the blocks parent based on 
	 * the sort input settings in the block.
	 * 
	 * @param event e
	 * @returns void
	 */
	loadMembers: function(e) {
		var self = $(e.currentTarget);
		if (self.prop('disabled') === true) {
			return;
		}
		var sortFilters = self.siblings('span').find('select');
		var parent = self.parent('section.subsummary').parent;
		var members = parent.children(this.target);
		
	},
	
	/**
	 * Set the 'Unload' button behavior
	 * 
	 * The unload button moves subsummary block members out of the 
	 * block and up to the blocks parent (assumed for now. is this good?)
	 * 
	 * @param event e
	 * @returns void
	 */
	unloadMembers: function(e) {
		
	},
		
	/**
	 * Set the 'change' behavior for the sort-key select list
	 * 
	 * The sort key list names the breakpoint categories that are 
	 * available for the current record in the report
	 * 
	 * @param event e
	 * @returns void
	 */
	sortKeyChange: function(e){
		var choice = $(e.currentTarget).val();
		var index = this.keyLookup[choice];
//		this.keys[index].used = true;
		$($(e.currentTarget).siblings('label')[0]).html(choice.toLocaleUpperCase());
		var values = this.keys[index].values;
		$(e.currentTarget).parents('header').find('span.sortkeyvalue').html(this.sortSelectList(values));
		$(e.currentTarget).parents('header').find('span.sortkeyvalue select').on('change', this.sortValueChange.bind(this));
	},
	
	/**
	 * Set the 'change behavior for the sort-key value select list
	 * 
	 * The sort key value list is the possible values for a single sort key. 
	 * 
	 * @param event e
	 * @returns void
	 */
	sortValueChange: function(e){
		$($(e.currentTarget).siblings('label')[0]).html($(e.currentTarget).val());
		var sortkey = $(e.currentTarget).parents('header').children('span.sortkey').children('select').val();
		var keyindex = this.lookupTable(sortkey);
		var valueindex = this.valueLookup(sortkey, $(e.currentTarget).val());
		this.keys[keyindex].values[valueindex].used = true;
		if (this.keys[keyindex].available.lenth == 0) {
			this.keys[keyindex].used = true;
		}
	},
	
	/**
	 * Given a sort-key name (a string) find its index number
	 * 
	 * There are many places where we know the name of a sort-key 
	 * but access to data on these keys is stored in an array, so we 
	 * always need the index, not the name. This lookup translates. 
	 * 
	 * @param string subject
	 * @returns int
	 */
	lookupTable: function(subject) {
		var lookup = {};
		var j = subject.length;
		for (var i = 0; i < j; i++) {
			lookup[subject[i].name] = i;
		}
		return lookup;
//	},
//	
//	member: {
////		construct: function(member) {
////			this.node = $(member);
////		}
//	},
//	
//	summaryblock: {
//		
	}
}

