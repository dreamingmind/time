/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    function initOutNowButton(){
        $('#OutNowButton').bind('click',function(e){
            e.preventDefault();
            var d = new Date();
            var monthstring = (parseInt(d.getMonth())+1).valueOf();
            var month = ('0'+monthstring).substr(-2);
            var day = ('0'+d.getDate()).substr(-2);
            var dstring = d.getFullYear()+'-'+month+'-'+day+' '+d.toLocaleTimeString();
            alert(d);
            $(this).parents('form').find('#TimeTimeOut').attr('value',dstring);
        })
    }
    function initAdjustSelect(){
        $('#OutTimeAdjust').bind('change', function(){
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
        })
    }
    initOutNowButton();
    initAdjustSelect();
})