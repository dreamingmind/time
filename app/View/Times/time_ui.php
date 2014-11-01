<div id="cmdm_time">
	<div id='cmdm_time_toggle'></div>
	<div id="cmdm_time_ui_wrap">
		<div id='cmdm_time_ui' src='http://localhost/a4_dondrake/time_ui.php'>
			<h1> This is the timekeeping interface </h1>
			<div><button id="Live">Click Me</button><button>Press Me</button></div>
		</div>
	</div>
<style type="text/css">
/*<![CDATA[*/
div#cmdm_time {position: fixed; top: 0px; left: 0px; z-index: 1000;}
div#cmdm_time_toggle {display: inline-block; width: 17px; height: 15px;  background-image: url('http://localhost/a4_dondrake/logomark.jpg'); vertical-align: top;}
div#cmdm_time_ui_wrap {display: inline-block; z-index: 1000;}
div#cmdm_time_ui {display: none; background-color: white;}
/*]]>*/
</style>
<script type="text/javascript">
//<![CDATA[
// definition phase
document.getElementById('cmdm_time_toggle').display = 'none';
function cmdm_time_toggle() {document.getElementById("cmdm_time_toggle").onclick = function(e){
		this.display = this.display == 'none' ? 'inline-block' : 'none'; 
		document.getElementById('cmdm_time_ui').style = 'display: '+this.display;	}}
// initialization phase
cmdm_time_toggle();
//]]>
</script>
</div>
