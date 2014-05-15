<?php
ini_set('display_errors', '1');
error_reporting(-1);

date_default_timezone_set('UTC');
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=yes">
	
	<title>battery drainer</title>
	<script>document.write('<base href="' + document.location + '" />');</script>
	<script src="lib/moment.js/moment.js"></script>
	
	<script src="lib/jquery/jquery.min.js"></script>
	<script src="lib/underscore.js/underscore.js"></script>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/index.css" media="only screen and (min-device-width: 100px)" />
</head>

<body>
	<div class='stats'>
		<div class="threads">
			<span class='label'>threads</span>
			<span class='value'>0</span>
		</div>
		
		<div class='time'>
			<span class='label'>time</span>
			<span class='value'></span>
		</div>
		
		<div class='message'>
			<span class='label'>msg</span>
			<span class='value'></span>
		</div>
	</div>
	
	<div class='testbed'>
		<div class='label-cpu_01'>
		</div>
		<div class='label-net_01'>
		</div>
		<div class='forms'>
		</div>
	</div>
	
	<script type="text/javascript">
		cpu_01 = function (opts) {
			var dtStart = new Date();
			var idx = 0;
			var eq = Math.random();
			while(1) {
				idx++;
				if (idx%100==0) {
					var dt = new Date();
					var timeDiff = dt.getTime() - dtStart.getTime();
					
					if((timeDiff)>opts['scheduledFor']) {
						break;
					}
					
					$('div.stats div.time>span.value').html(moment().format('h:mm:ss'));
				}
					
				eq = eq*100/12.44+Math.sqrt(eq+2);
				
				if(eq>100000){
					eq = eq /(Math.random()*100);
				}
				
				$('div.testbed div.label-cpu_01').html(Math.round(eq));
			}
		}
		
		net_01 = function (opts) {
			var context = $('div.testbed div.label-net_01');
			var cnt = Number(context.html());
			
			for(var i=0; i<opts['requests']; i++) {
				if(cnt<opts['max']) {
					cnt+=1;
					context.html(cnt);
				
					$.ajax({url: "AJAX.php?r="+Math.random(), context: context })
					.done(function() {
						var cnt = Number(this.html());
						cnt-=1;
						$( this ).html( cnt );
					});
				}
			}
		}
		
		rebench = function (opts) {
			cpu_01({'scheduledFor':500,});
			net_01({'requests':15, 'max': 250});
			
			setTimeout(function(){
				rebench();
			}, 550);
		}
		
		$().ready(function() {
			$('div.stats div.threads>span.value').html('0');
			
			setTimeout(function(){
				rebench();
			}, 500);
		});
	</script>
</body>
</html>

