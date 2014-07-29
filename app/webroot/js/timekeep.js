/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    bindHandlers();
})
	/**
	 * Sweep the page for bindings indicated by HTML attribute hooks
	 * 
	 * Class any DOM element with event handlers.
	 * Place a 'bind' attribute in the element in need of binding.
	 * bind="focus.revealPic blur.hidePic" would bind two methods
	 * to the object; the method named revealPic would be the focus handler
	 * and hidePic would be the blur handler. All bound handlers
	 * receive the event object as an argument
	 * 
	 * @param {string} target a selector to limit the scope of action
	 * @returns The specified elements will be bound to handlers
	 */
	function bindHandlers(target) {
		if (typeof(target) == 'undefined') {
			var target = '*';
		}
		$(target + '[bind*="."]').each(function(){
			var bindings = $(this).attr('bind').split(' ');
			for (i = 0; i < bindings.length; i++) {
				var handler = bindings[i].split('.');
				if (typeof(window[handler[1]]) === 'function') {
					// handler[0] is the event type
	
					// handler[1] is the handler name
					$(this).off(handler[0]).on(handler[0], window[handler[1]]);
				}
			}
		});
	}

	function OutNow(e){
            e.preventDefault();
            var d = new Date();
            var monthstring = (parseInt(d.getMonth())+1).valueOf();
            var month = ('0'+monthstring).substr(-2);
            var day = ('0'+d.getDate()).substr(-2);
            var dstring = d.getFullYear()+'-'+month+'-'+day+' '+d.toLocaleTimeString();
            alert(d);
            $(this).parents('form').find('#TimeTimeOut').attr('value',dstring);
    }
	
    function AdjustSelect(e){
            //Get curr datetime
            var d = new Date();
            //set variable for users adjustment selection
            var adj = parseInt($(this).val());
            //Adjust per parameters
            var dadj = d.setMinutes(d.getMinutes()+ adj);
            //Set new value to d
            
            //Reformat for output
            var monthstring = (parseInt(d.getMonth())+1).valueOf();
            var month = ('0'+monthstring).substr(-2);
            var day = ('0'+d.getDate()).substr(-2);
            var dstring = d.getFullYear()+'-'+month+'-'+day+' '+d.toLocaleTimeString();
//            alert(dadj);
            $(this).parents('form').find('#TimeTimeOut').attr('value',dstring);
    }
	
	function timeStop(e){
		e.preventDefault();
	}
	
	function timePause(e){
		e.preventDefault();
	}
	
	function timeBack(e){
		e.preventDefault();
	}
