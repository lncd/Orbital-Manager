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

		<div class="page-header">
			<h1>Cost calculator</h1>
		</div>
				
	</div>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script><script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
 
    $( "#amount_slider" ).slider({
        orientation: "horizontal",
        range: false,
        min: 50, //1000,
        max: 5000, //300000,
        value: 100,
        step: 10,
        slide: function( event, ui ) {
                $( "#amount" ).text( ui.value );
        },
        stop: function( event, ui ) {
                calculateMorgage();
        }
    });
 
    $( "#amount" ).text($( "#amount_slider" ).slider( "value" ));

	function calculateMorgage()
	{
		var amount   = $( "#amount_slider" ).slider( "value" );
		
		//Price per unit of space
		var rate     = amount * 7;
		
		//Calculation
		$( "#result" ).text(rate.toFixed(2));
	}
	
	calculateMorgage();

});
</script>
 
 
<div>
<div class="message">Space</div><div id="amount_slider"></div><div id="amount"></div>
<div class="clear"></div>
<div class="clear"></div> <div class="message">Cost</div><div id="result"></div> <div class="clear"></div>
</div>