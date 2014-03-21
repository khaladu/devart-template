<?php
//this page shows menubar on right top
require_once "db/DataHandler.php";

?>
<div id="headerimage"><img id="headerimage" src=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/images/header/header.png"' ?>/></div>
<div id="welcome">
	<?php
	echo "Welcome ".$currentUser->Forename;
	?>
</div>
<div id="menubar">
	<ul>

		<?php

		if($currentUser->UserRole == ADMIN){
	//show create/delete editor reporter
	/*
	reporters
	editors
	logout
	*/
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/?req=logout">logout</a></li>';
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/">Home</a></li>';
}
else if($currentUser->UserRole == EDITOR){
	/*
	logout
	*/
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/?req=logout">logout</a></li>';
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/">Home</a></li>';
}
else if($currentUser->UserRole == REPORTER){
	//show list of news with option to edit
	/*
	logout
	*/	
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/?req=logout">Logout</a></li>';
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/?req=addnews">Create News</a></li>';
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/">Home</a></li>';


}
else if($currentUser->UserRole == READER){
	//show normal newspage
	//logout
	/*
	echo "<pre>";
	print_r($currentUser);
	echo "</pre>";
	*/
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/?req=logout">Logout</a></li>';
	echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/">Home</a></li>';
}


?>
</ul>
</div>