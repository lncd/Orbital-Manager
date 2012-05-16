<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li class="active">
		<a href="{base_url}about">About</a></span>
	</li>
</ul>

<div class="page-header">
	<h1><?php echo lang('about_title'); ?></h1>
</div>

<?php echo auto_typography(lang('about_main_text')); ?>

<hr>

<div class="row">

	<div class="span4">
		<h2><?php echo lang('about_trio1_title'); ?></h2>
		<?php echo auto_typography(lang('about_trio1_text')); ?>
	</div>
	
	<div class="span4">
		<h2><?php echo lang('about_trio2_title'); ?></h2>
		<?php echo auto_typography(lang('about_trio2_text')); ?>
	</div>
	
	<div class="span4">
		<h2><?php echo lang('about_trio3_title'); ?></h2>
		<?php echo auto_typography(lang('about_trio3_text')); ?>
	</div>

</div>