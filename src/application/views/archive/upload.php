<div class="row-fluid">
	<div class="span12">
		<h1>Core Ping</h1>
	</div>
</div>
<div class="row-fluid">
	<div class="span8">
		<form id="fileupload" action="{core_url}" method="POST" enctype="multipart/form-data">
    <input type="file" name="files[]" multiple>
</form>
<script>
$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $('<p/>').text(file.name).appendTo(document.body);
            });
        }
    });
});
</script>
	</div>
	<div class="span4">
		<div class="well">
			<h2>What is this?</h2>
			<p>The 'Core Ping' is {orbital_manager_name} ensuring that it can still communicate with the Orbital Core application, which is actually responsible for storing and managing data. You can generally ignore what the Core Ping tells you, although your system administrator may ask you for information to help them solve problems.</p>
		</div>
	</div>
</div>