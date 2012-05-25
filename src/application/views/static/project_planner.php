<div class="row">
	<div class="span12">

		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li class="active">
				Project Planner
			</li>
		</ul>				
	</div>
</div>

<div class="page-header">
	<h1>Cost calculator</h1>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script><script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
 
    $( "#amount_slider" ).slider({
        orientation: "horizontal",
        range: false,
        min: 100,
        max: 5000,
        value: 100,
        step: 100,
        slide: function( event, ui ) {
                $( "#amount" ).text( ui.value + "GB");
        },
        stop: function( event, ui ) {
                calculateMorgage();
        }
    });
 
    $( "#amount" ).text($( "#amount_slider" ).slider( "value" ) + "GB");
 
    $( "#time_slider" ).slider({
		orientation: "horizontal",
		range: false,
		min: 1,
		max: 60,
		value: 15,
		slide: function( event, ui ) {
			$( "#time" ).text( ui.value + " Months");
		},
		stop: function( event, ui ) {
			calculateMorgage();
		}
	});

	$( "#time" ).text($( "#time_slider" ).slider( "value" ) + " Months");

	function calculateMorgage() {

		var amount   = $( "#amount_slider" ).slider( "value" );
		var time     = $( "#time_slider" ).slider( "value" );

		var rate     = 0.11 * amount * time;

		$( "#result" ).text('Approx. £' + rate.toFixed());
	}

	calculateMorgage();
 
});
</script>
 
<link rel="stylesheet" href="/wp-content/themes/recipress/jquery-ui-1.8.16.custom.css"/>
<style type="text/css">
#amount_slider, #interest_slider, #time_slider { width: 200px; margin-top: 20px; float: left; }
#amount, #interest, #time, #result { margin-left: 20px; margin-top: 20px; float: left; }
#result { font-weight: bold; } .message { float: left; margin-top: 20px; font-family:Arial; width: 100px; }
.clear { clear: both; }
</style>
 
<div>
<div class="message">Space</div><div id="amount_slider"></div><div id="amount"></div>
<div class="clear"></div> <div class="message">Time</div><div id="time_slider"></div><div id="time"></div>
<div class="clear"></div> <div class="message">Cost</div><div id="result"></div> <div class="clear"></div>
</div>

<br>
*These figures are based on a rate of 11p per Gigabyte per month
<hr>
<div class="page-header">
	<h1>DMP Online</h1>
</div>

DMP Online is a tool to help you write your research bids and project plans
<br><br>
<a href="http://dmp.lncd.org/">DMP Online</a>