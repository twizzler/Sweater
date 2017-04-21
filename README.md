Sweater
===
Sweater is a program written in PHP designed to reverse engineer Club Penguin

### Requirements
<ul>
	<li> PHP 5.5+</li>
	<li> PDO w/ MySQL driver enabled</li>
	<li> Sockets</li>
	<li> PCNTL (optional)</li>
	<li> cURL (optional, used for updating crumbs)</li>
	<li> MySQL server</li>
	<li> Working Internet connection (optional, for updating crumbs)</li>
</ul>

### Instructions:
<ul>
	<li> Make sure you have an AS2 media server - once you have one, set it up</li>
	<li> Make sure you have the latest version of PHP installed</li>
	<li> Make sure you have a MySQL server running</li>
	<li> Create a database and import Install.sql</li>
	<li> Create a user account using INSERT</li>
	<li> Configure Server.conf</li>
	<li> Make sure you've upload the openglows (glowing.fla) in your client folder and added it to dependencies.json</li>
	<li> Execute Runner.php with a server ID from the configuration as an argument</li>
</ul>

###Usage:
<code>php Runner.php ServerID</code>
	
####Example:
<code>php Runner.php 1 --update-crumbs</code><br />
<code>php Runner.php 100<br />
