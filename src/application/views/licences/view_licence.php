<div class="row">
	<div class="span12">

		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				Licences<span class="divider">/</span>
			</li>
			<li class="active">
				{licence_original_name}
			</li>
		</ul>

		<div class="page-header">
			<h1>{licence_original_name}</h1>
		</div>
		
		<p><a href="{licence_summary_uri}">{licence_summary_uri}</a></p>
		
		<h2>Summary</h2>
		{licence_summary}
	</div>
</div>

<div class="row">
	<div class="span6">
		<div class="well">
		{licence_allow}
		</div>
	</div>
	<div class="span6">
		<div class="well">
		{licence_forbid}
		</div>
	</div>
</div>