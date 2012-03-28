<?
require_once 'twitteroauth/twitteroauth.php';
setlocale(LC_ALL, "nl_NL");
date_default_timezone_set("Europe/Amsterdam");

extract($_POST);

require_once 'credentials.php';
// or...
//  define("CONSUMER_KEY", "XXXXXXXXXXX");
//  define("CONSUMER_SECRET", "XXXXXXXXXXXXX");
//  define("OAUTH_TOKEN", "XXXXXXXXXXXX");
//  define("OAUTH_SECRET", "XXXXXXXXXXXXX");

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);

if (isset($txt) && strlen($txt)>20) { //minimaal 20 tekens
	//update tweet 
	$content = $connection->get('account/verify_credentials');
	$content = $connection->post('statuses/update', array('status'=>$txt)); //date(DATE_RFC822))
	$result = gmstrftime("%e %B %H:%M ",time()+3600) . " - $txt";
} else {
	//get status
	$content = $connection->get('statuses/user_timeline');
	$result = $content[0];
	$date = strtotime($result->created_at);
	$result = gmstrftime("%e %B %H:%M ",$date+3600) . " - {$result->text}";
}
?>

<!DOCTYPE html> 
<html> 
	<head> 
	<title>dmpstr.nl #033</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="apple-touch-icon" href="dumpster.png"/>
	<link rel="stylesheet" href="styles.css" />
</head> 
<body> 

<h1><img src="dumpster32.png">&nbsp;<a href="?">dmpstr.nl #033</a></h1>
<p><a href="http://twitter.com/dumpsterdive033"><?echo $result?> (<font color="#0f0"><u>meer...</u></font>)</a></p>
<form name="form" method="post">
<?if (!isset($txt)) {?>
<textarea name="txt" onkeydown="count.innerText=this.value.length; if (this.value.length>139) this.value=this.value.substr(0,139)"></textarea><br/><br/>
<div style="float:right" id="count"></div>
<a href="javascript:form.submit()" class="button">Versturen</a>
<?} else {?>
<font color="#0f0">Thanks!</font>
<?}?>
</form>
</body>
</html>

