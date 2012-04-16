<div class="row">
	<div class="span12">
		<h1>Core Ping</h1>
	</div>
</div>
<div class="row">
	<div class="span8">
		<table class="table table-striped table-bordered">
			<tr><th scope="row">Response</th><td>{ping_response_message}</td></tr>
			<tr><th scope="row">Response Time</th><td>{ping_response_time}s</tr>
			<tr><th scope="row">Institution</th><td>{ping_response_orbital_institution}</td></tr>
			<tr><th scope="row">Core Version</th><td>{ping_response_orbital_version}</td></tr>
			<tr><th scope="row">Request Time</th><td>{ping_response_orbital_timestamp_pretty} ({ping_response_orbital_timestamp})</td></tr>
		</table>
	</div>
	<div class="span4">
		<div class="well">
			<h2>What is this?</h2>
			<p>The 'Core Ping' is {orbital_manager_name} ensuring that it can still communicate with the Orbital Core application, which is actually responsible for storing and managing data. You can generally ignore what the Core Ping tells you, although your system administrator may ask you for information to help them solve problems.</p>
		</div>
	</div>
</div>