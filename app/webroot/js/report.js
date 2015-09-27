$(document).ready(function () {
	
	var target = 'div.time';
	var members = [];
	var exemplars = $(target);
	
	if (exemplars.length > 0) {
		var candidates = $(exemplars[0]).children('aside.keys').children('span');
		var j = candidates.length;
		for (var i = 0; i < j; i++) {
			members.push($(candidates[i]).attr('class'));
		}
	}
	var x = 'x';
	
});

var Summary = {
	
	MasterKeys : function (target) {
		var exemplars = $(target);
		var rawMembers = $(target + ' aside.keys > span').attr('class');
	},
	SortKey: function (name, used) {
		this.name = name;
		this.used = typeof(used) === 'undefined' ? false : used;
	},
	SortKeyValue: function (name, used) {
		this.name = name;
		this.used = typeof(used) === 'undefined' ? false : used;
	}

}

