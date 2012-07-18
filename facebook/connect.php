<? 
$config = array(
	'server' 	=> 'localhost',
	'username' 	=> 'root',
	'password' 	=> '',
	'database' 	=> 'social_facebook'
);

$conn = mysql_connect($config['server'],$config['username'],$config['password']) or
	die("Can not connect");
$db = mysql_select_db($config['database']) or
	die("Can not select".$config['database']);
?>
