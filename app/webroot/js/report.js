$(document).ready(function () {

	var report_members = 'div.time';
	
	report = new ReportMaker(report_members);
	$(window).data('summary', report);
	$('#newsummary').on('click', function(){
		$('section#report > section.records').prepend(report.newSummaryBlock.call(report))
	});
//	$('#newsummary').on('click', report.newSummaryBlock.bind(report, 'section#report > section.records'));

	// make the project level summary block
	// it needs limited features
	$('div#content').append(report.newSummaryBlock.call(report));
//	report.newSummaryBlock.call(report, 'div#content', true);
	var masterblock = report.getSummary('section.subsummary');
	masterblock.node.attr('id', 'report');
	masterblock.header().html('<span class="title">Report</span><span class="summaryvalue"></span>');
	masterblock.node.attr('data-breakpoint', 'report');

	var members = $(report.target);
	members.each(function () {
		$(this).data('access', new ReportMember(this));
	});

	// move the members into the report and total them
	masterblock.details().html($(report_members).detach());

	masterblock.total();
	$('#report > section.records').prepend(report.newSummaryBlock.call(report));

//	report.newSummaryBlock.call(report, '#report > section.records');

});

ReportBlock = function (node, selectors) {
	this.node = $(node);
	if (typeof(selectors) == 'object') {
		var property;
		for (property in selectors) {
			this.selector[property] = selectors[property];
		}
	}
};
ReportBlock.prototype = {
	/**
	 * Get the node block header
	 * @returns {$|jQuery}
	 */
	header: function(){
		return $(this.node.children(this.selector.header)[0]);
	},
	/**
	 * Get a named span from the member header
	 * @param string name span class, typically a column name
	 * @returns {$|jQuery}
	 */
	headingNode: function(name) {
		return $(this.header().children('.'+name)[0]);
	},
	/**
	 * Get or set and get the contents of a named header span
	 * @param string name span class, typically a column name
	 * @param {string|innerhtml} content Optional content to put in the header span
	 * @returns {string|innerhtml}
	 */
	headingValue: function(name, content) {
		if (typeof(content) === 'undefined') {
			return this.headingNode(name).html();
		}
		return this.headingNode(name).html(content);
	},
	details: function() {
		return this.node.children(this.selector.detail);
	},
	/**
	 * Get a named node from the member's details
	 * @param string name span class, typically a column name
	 * @returns {$|jQuery}
	 */
	detailNode: function (name) {
		return $(this.details().children('.' + name)[0]);
	},
	/**
	 * Get or set and get the contents of a named detail element
	 * @param string name element class, typically a column name
	 * @param {string|innerhtml} content Optional content to put in the detail element
	 * @returns {string|innerhtml}
	 */
	detailValue: function (name, content) {
		if (!typeof (content) === 'undefined') {
			this.detailNode(name).html(content);
		}
		return this.detailNode(name).html();
	},
	parent: function () {
		return this.node.parent().parent();
	}
};

ReportMaker = function (target) {
	// the selector to get the records to be summarized
	this.target = target;
	// prepare list of possible subsummary breaks
	this.keys = [];

	// each key entry will be an object describing that key and its possible values
	var keyExemplars = $(target);
	if (keyExemplars.length > 0) {
		var candidates = $(keyExemplars[0]).children('header').children('span');
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
			this.keys[this.keys.length - 1].availableValues = this.available(this.keys[this.keys.length - 1].values);
		}
	}
	;

	this.keyLookup = this.lookupTable(this.keys);
	this.setMemberDrag();
}
ReportMaker.prototype = {
	constructor: ReportMaker,
	/**
	 * Make the set of possible values for a given key
	 * 
	 * Keys are the possible subsummary breaks like 'project' or 'user'. 
	 * The values for each are all the distinct values currently on the page. 
	 * 
	 * @param string key
	 * @returns {ReportMaker.initSummaryValues.result|Array}
	 */
	initSummaryValues: function (key) {
		var rawValues = $(this.target).children('header.keys').children('span[class="' + key + '"]');
		var result = [];
		var exists = {};
		var j = rawValues.length;
		for (var i = 0; i < j; i++) {
			var value = $(rawValues[i]).html();
			if (typeof (exists[value]) === 'undefined') {
				exists[value] = true;
				result.push({
					'name': value,
					'used': false // needs a system to set this
				});
			}
		}
		return result;
	},
	/**
	 * Calculate the total for a node based on it's children
	 * 
	 * @param element parentnode
	 * @returns void
	 */
	total: function () {
		$('section#report').data('access').total();
	},
	/**
	 * Set drag for report member records
	 * 
	 * @returns void
	 */
	setMemberDrag: function () {
		$(this.target).draggable();
	},
	
	setDropBehavior: function (node) {
		// this configures a drop point (the 'details' of a summary block)
		node.droppable({
			drop: function (event, ui) {
				ui.draggable.css('position', 'realtive').css('left', '0px').css('top', '0px');
				$(this).append(ui.draggable);
				$(window).data('summary').total();
			}
		});
		$("section.records").droppable("option", "tolerance", "pointer");
		$("section.records").droppable("option", "greedy", true);
	},
	
	initDragDrop: function(node) {
		// this sets up dragging and if necessary 
		// a drop point for a single node
		node.draggable();
		var Block = node.data('access');
		if (Block instanceof SummaryBlock) {
			this.setDropBehavior(Block.details());
		}
	},
	/**
	 * Get the index of a value on a key
	 * 
	 * @param int|string key The key's index or value
	 * @param string value The value to find an index for
	 * @returns {Boolean|Number}
	 */
	valueLookup: function (key, value) {
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
	 * @returns {ReportMaker.prototype.available.result|Array}
	 */
	available: function (set) {
		var result = [];
		var limit = set.length;
		for (var i = 0; i < limit; i++) {
			if (!set[i].used) {
				result.push(set[i].name);
			}
		}
		return result;
	},
	'summaryblock': "<section class=\"subsummary\" data-seconds=\"0\"><header><span class=\"sortkey\"></span><span class=\"sortkeyvalue\"></span><span class=\"summaryvalue\"></span></header><section class=\"records droppable\"><!-- records or subsummary sections to summarize --></section></section>",
	/**
	 * Make a select list from the currently available keys or values on a key
	 * 
	 * If there is only one available option, make it the selection and 
	 * don't have an empty/prompt choice. 
	 * 
	 * @param array set 
	 * @returns {String}
	 */
	sortSelectList: function (set) {
		var keys = this.available(set);
		var j = keys.length;
		var label = '<label>Select a subsummary filter.</label>';
//		var options = j === 1 ? [] : ['<option value="">Select a sort key</option>'];
		var options = ['<option value="">Select a sort key</option>'];
		for (var i = 0; i < j; i++) {
			options.push('<option value="' + keys[i] + '">' + keys[i] + '</option>');
		}
//		if (j === 1) {
//			options[0] = options[0].replace(/(<option )/, '$1selected="selected" ');
//			label = label.replace(/>.*</, '>' + keys[0] + '<');
//		}
		return label + '<select>' + options.join('') + '</select>';
	},
	/**
	 * Make a color number within 30 values of white
	 * 
	 * @returns Int
	 */
	rnd: function () {
		return parseInt(256 - (30 * Math.random()));
	},
	/**
	 * Make a new summary block prepending it to the main report area
	 * 
	 * @returns void
	 */
	newSummaryBlock: function (wrapper, append, selectors) {
		// make and hold a block of random color
		var block = $(this.summaryblock);
		block.css('background-color', 'rgb(' + this.rnd() + ', ' + this.rnd() + ', ' + this.rnd() + ')');
		// modify it, adding the key select list with its behavior
		block.find('span.sortkey').html(this.sortSelectList(this.keys));
		block.find('select').on('change', this.sortKeyChange.bind(this));
		// intitialize the buttons
		block.find('button').prop('disabled', true);
		// attach the blocks access tool
		block.data('access', new SummaryBlock(block, selectors));
		this.initDragDrop(block);
		
		return block;
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
	sortKeyChange: function (e) {
		var choice = $(e.currentTarget).val();
		var index = this.keyLookup[choice];
//		this.keys[index].used = true;
		var values = this.keys[index].values;
		var summaryBlock = this.getSummary(e.currentTarget);
		var parent_breakpoint = $(summaryBlock.parent()).attr('data-breakpoint');
		var parents = $(summaryBlock.selector.node+'[data-breakpoint="'+parent_breakpoint+'"]');
		$(summaryBlock.node).remove();
		
		var j = parents.length;
		var r = values.length;
		// the set of parent nodes that will contain this new breakpoint nest
		for (var i = 0; i < j; i++) {
			var Parent = $(parents[i]).data('access');
			// the breakpoints inside a single parent
			for (var s = 0; s < r; s++) {
				var block = this.newSummaryBlock();
				var new_breakpoint = values[s];
				var block_access = block.data('access');
				block.attr('data-breakpoint', choice);
				block_access.headingValue('sortkey', values[s].name + '&nbsp;');
				Parent.details().prepend(block);
				var members = Parent.details().children(this.target);
				var y = members.length;
				var members_moved = false;
				// move the appropriate members from the parent to the breakpoint
				for (var x = 0; x < y; x++) {
					if (this.getMember(members[x]).headingNode(choice).html() === values[s].name) {
						block_access.details().append($(members[x]).detach());
						members_moved = true
					}
				}
				// if the breakpoint recieved no members, remove it
				if (!members_moved) {
					block.detach();
				} // done with members for a single breakpoint

			} // done populating a doing the flavors of 'choice' for a single parent
			
		} // done distrubuting the choice into all parents
		
		// flag choice done, do css adjustment, recalc the page
		this.keys[index].used = true;
		
		var report_css = $('style#report-css');
		if (this.available(this.keys).length === 0) {
			report_css.append(this.target + ' header {display: none;}');
		} else {
			report_css.append('section[data-breakpoint="' + choice + '"] .' + choice + ' {display: none;}');
		}
		
		this.total();

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
	lookupTable: function (subject) {
		var lookup = {};
		var j = subject.length;
		for (var i = 0; i < j; i++) {
			lookup[subject[i].name] = i;
		}
		return lookup;
	},
	getMember: function (node) {
		if ($(node)[0].tagName == 'DIV' && $(node).attr('id').match(/time-\d+/)) {
			return $(node).data('access');
		}
		return $(node).parents(this.target).data('access');
	},
	getSummary: function (node) {
		if ($(node)[0].tagName == 'SECTION' && $(node).attr('class').match(/subsummary/)) {
			return $(node).data('access');
		}
		return $(node).parents('section.subsummary').data('access');
	}
};

/**
 * An object that manages access to individual subsummary blocks in a report
 * 
 * @param $|jQuery|selector node
 * @returns {ReportMember}
 */
SummaryBlock = function (node, selectors) {
	this.selector = {
		node: 'section.subsummary',
		header: 'header',
		detail: 'section.records'
	}
	ReportBlock.call(this, node, selectors);
};
SummaryBlock.prototype = Object.create(ReportBlock.prototype, {
	constructor: {
		value: SummaryBlock,
	},
	total: { 
		value: function () {
			var children = this.details().children();
			var type = '';
			var total = 0;
			var j = children.length;
			for (var i = 0; i < j; i++) {
//				type = $(children[i]).attr('class').match(/time/) ? 'member' : 'summaryblock';
				total += parseInt($(children[i]).data('access').total());
			}
	//		total += children.each(function(){this.total()});
			this.node.attr('data-seconds', total);
			var hours = total / 3600;
			this.headingValue('summaryvalue', hours.toFixed(2));
			return total;
		}
	}
});

/**
 * An object that manages access to individual member records in a report
 * 
 * @param $|jQuery|selector node
 * @returns {ReportMember}
 */
ReportMember = function (node, selectors) {
	this.selector = {
		node: 'div.time',
		header: 'header',
		detail: 'detail'
	}
	ReportBlock.call(this, node, selectors);
};
ReportMember.prototype = Object.create(ReportBlock.prototype, {
	constructor: {
		value: ReportMember,
	},
	total: {value: function () {
			return this.node.attr('data-seconds');
		}
	}
});
