<div class="row-fluid">
	<div class="span12">
	
		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}admin">Administration</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}admin/database_status">Database Status</a></span>
			</li>
		</ul>
	
		<h1>Database Status</h1>
		
	</div>
</div>

<div class="row-fluid">
	<div class="span8">
	
		<h2>Current Connection</h2>
	
		<table class="table table-striped table-bordered">
			<tr><th scope="row">Hostname</th><td>{server_host}</td></tr>
			<tr><th scope="row">Version</th><td>{server_version}</td></tr>
			<tr><th scope="row">Uptime</th><td>{server_uptime_pretty}</td></tr>
			<tr><th scope="row">Server Local Time</th><td>{server_local_time_pretty}</td></tr>
			<tr><th scope="row">Global Lock Ratio</th><td>{server_lock_ratio}%</td></tr>
			<tr><th scope="row">Lock Queue</th><td>{server_lock_queue_total} ({server_lock_queue_read} read, {server_lock_queue_write} write)</td></tr>
			<tr><th scope="row">Active Clients</th><td>{server_active_clients_total} ({server_active_clients_read} read, {server_active_clients_write} write)</td></tr>
			<tr><th scope="row">Server Architecture</th><td>{server_memory_architecture} bit</td></tr>
			<tr><th scope="row">Memory (Resident)</th><td>{server_memory_resident} MB</td></tr>
			<tr><th scope="row">Memory (Virtual)</th><td>{server_memory_virtual} MB</td></tr>
			<tr><th scope="row">Memory (Mapped)</th><td>{server_memory_mapped} MB</td></tr>
			<tr><th scope="row">Connections (Current)</th><td>{server_connections_current}</td></tr>
			<tr><th scope="row">Connections (Available)</th><td>{server_connections_available}</td></tr>
		</table>
	
		<h2>Servers</h2>
	
		<table class="table table-striped table-bordered">
			<thead>
				<tr><th>ID</th><th>Name</th><th>State</th></tr>
			</thead>
			<tbody>
				{status_servers}
				<tr><td>{server_id}</td><td>{server_name}</td><td>{server_state}</td></tr>
				{/status_servers}
			</tbody>
		</table>
	</div>
	<div class="span4">
		<div class="well">
			<h2>What is this?</h2>
			<p>This page gives an overview of the state of the Orbital Core database servers which {orbital_manager_name} communicates with.</p>
			<p>This information may come in handy when diagnosing database problems. Please note this data does <i>not</i> relate to communications between {orbital_manager_name} and the Orbital Core instance.</p>
		</div>
	</div>
</div>