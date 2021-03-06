<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li class="active">
		<a href="{base_url}me">My Profile</a></span>
	</li>
</ul>

<div class="page-header">
	<h1>{user_name} <small>{institution}</small></h1>
</div>	

<h2>User Timeline</h2>

<?php

if (count($timeline) > 0)
{
	echo '<ul class="timeline" id="userTimeline">';

	foreach ($timeline as $item)
	{
		echo '<li id="tl_' . $item->id . '"><div class="tl_content tl_vis_' . $item->visibility . '"><p><b>' . $item->text . '</b>';
		if ($item->payload !== NULL)
		{
			echo '<br>' . $item->payload;
		}
		echo '</p><small>' . $item->timestamp_human . '</small></div></li>';
	}	



	echo '</ul>';
}
else
{
	echo 'There isn\'t any activity to show for ' . $user_name . '.';
}

if (ENVIRONMENT === 'development')
{
	?>
	
	<h2>Access Token</h2>
	<?php
		echo '<p>Access Token: <code>' . $this->session->userdata('access_token') . '</code></p>'; 
		echo '<p>Base 64 Encoded: <code>' . base64_encode($this->session->userdata('access_token')) . '</code></p>';
}
?>
		
<script type="text/javascript" src="{base_url}js/jquery.scrollTo.min.js"></script>
<script type="text/javascript">
	$('#userTimeline').scrollTo($('#tl_now'));
</script>
