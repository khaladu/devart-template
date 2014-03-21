<?php
/*
define("ADMIN",1);
define("EDITOR", 2);
define("REPORTER", 3);
define("READER", 4);
*/


if($currentUser->UserRole == ADMIN){
	$userCreatedMessage = "";
	if(isset($_POST['createuser'])){

		$forename = $_POST['forename'];
		$surname = $_POST['surname'];
		$userid = $_POST['userid'];
		$password = $_POST['password'];
		$arrRoles = array();
		if(isset($_POST['administrator'])){
			$arrRoles[] = ADMIN;
		}
		if(isset($_POST['editor'])){
			$arrRoles[] = EDITOR;
		}
		if(isset($_POST['reporter'])){
			$arrRoles[] = REPORTER;
		}
		if(isset($_POST['reader'])){
			$arrRoles[] = READER; 
		}
		if(User::CreateUser($forename, $surname, $userid, $password, $arrRoles)){
			$userCreatedMessage = "User created!";
		}
	}
	
	//show create editor and reporter form
	?>
	<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>
	
	<script type="text/javascript">
		function create_user(){
			var showalert = false;
			var alertmessage = "";
			if(document.getElementById("forename").value == ""){
				showalert=true;
				alertmessage="Please enter forename";
			}
			else if(document.getElementById("surname").value == ""){
				showalert=true;
				alertmessage="Please enter surname";	
			}

			if(document.getElementById("userid").value == ""){
				showalert = true;
				alertmessage = "Please enter userid";
			}
			else{
				x=document.getElementById("userid").value;
				var atpos=x.indexOf("@");
				var dotpos=x.lastIndexOf(".");
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
				{
					showalert = true;
					alertmessage = "Please enter valid email address as userid";
				}
				else if(x.length > 18){
					showalert = true;
					alertmessage = "Userid is too long";
				}
			}

			if(document.getElementById("password").value == ""){
				showalert = true;
				alertmessage = "Please enter password";
			}

			if(document.getElementById("admincheck").checked == false && document.getElementById("editorcheck").checked == false && document.getElementById("reportercheck").checked == false && document.getElementById("readercheck").checked == false){
				showalert = true;
				alertmessage = "User should have at least one role checked";
			}

			if(showalert == true){
				alert(alertmessage);
			}
			else{
				var pass = document.getElementById("password").value;
				document.getElementById("password").value = CryptoJS.SHA1(pass);
				document.getElementById("create_user_frm").submit();
			}
		}

	</script>

	<form id="create_user_frm" action=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/"'; ?> method="post">
		<div id="create_user_form">
			<?php echo '<div id="user_created_message">'.$userCreatedMessage.'</div>';?>
			<h4 style="margin-left:20px;">Enter user details</h4>
			<div class="label">Forename: </div><div class="forminput"><input type="text" name="forename" id="forename" /></div><br>
			<div class="label">Surname: </div><div class="forminput"><input type="text" name="surname" id="surname" /></div><br>
			<div class="label">UserID: </div><div class="forminput"><input type="text" name="userid" id="userid" /></div><br>
			<div class="label">Password: </div><div class="forminput"><input type="password" name="password" id="password" /></div><br>
			<div class="label">Role</div><br>
			<div class="label" style="margin-left:40px">Administrator</div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="administrator" id="admincheck" value="1"><br>
			<div class="label" style="margin-left:40px">Editor</div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="editor" id="editorcheck" value="1"><br>
			<div class="label" style="margin-left:40px">Reporter</div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="reporter" id="reportercheck" value="1"><br>
			<div class="label" style="margin-left:40px">Reader</div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="reader" id="readercheck" value="1"><br>
			<input type="hidden" name="createuser" value="1"/>
			<div class="button" style="margin-left:63%;margin-bottom:10px;margin-top:10px;"><input type="button" name="create_user_btn" value="Create User" onclick="create_user()"/> </div>
		</div>
	</form>

	<?php
}
else if($currentUser->UserRole == EDITOR){
	//show table of news
	$content = Content::GetContentListForEditor();
	foreach ($content as $key => $news) {
		echo '<div class="newslist">';
		echo '<h3 class="newstitle"><a href="http://'.$_SERVER['HTTP_HOST']."/~unn_w12038150/?topic=".$news['topic_ID'].'">'.$news['topic_title'].'</a></h3><p>';
		echo '<div class="shortnews">'.implode(' ', array_slice(explode(' ', $news['content']), 0, 40)).' ... ';
		echo '<a href="http://'.$_SERVER['HTTP_HOST']."/~unn_w12038150/?topic=".$news['topic_ID'].'" style="float:right">Read more</a>';
		echo '</div>';
		$phpdate = strtotime( $news['created_date'] );
		$date = date( 'D M Y', $phpdate );
		echo '<div class="newsdate">Date posted:'.$date.'</div>';
		if($news['approved'] == 0){
			$status = "Pending for approval";
		}
		else{
			$status = "published";
		}
		echo '<div class="news_status">Status: '.$status.'</div>';
		echo '<div class="news_created_by">Posted by: '.$news['forename'].' '.$news['surname'].'</div>';
		echo '</div>';
	} 
}
else if($currentUser->UserRole == REPORTER){
	//show list of news
	echo "<h2>New you reported</h2>";
	$content = Content::GetContentListByReporterID($currentUser->UserID);
	if($content == NO_TOPICS_FOUND){
		echo "<h4>No Topics found!</h4>";
	}
	else{
		/*
		echo "<pre>";
		print_r($content);
		echo "</pre>";
		*/
		//topics.topic_ID,topic_title,content,created_date,approved
		foreach ($content as $key => $news) {
			echo '<div class="newslist">';
			echo '<h3 class="newstitle"><a href="'.$_SERVER['REQUEST_URI']."?topic=".$news['topic_ID'].'">'.$news['topic_title'].'</a></h3><p>';
			echo '<div class="shortnews">'.implode(' ', array_slice(explode(' ', $news['content']), 0, 40)).'...';
			echo '<a href="'.$_SERVER['REQUEST_URI']."?topic=".$news['topic_ID'].'" style="float:right">Read more</a>';
			echo '</div>';
			$phpdate = strtotime( $news['created_date'] );
			$date = date( 'D M Y', $phpdate );
			echo '<div class="newsdate">Date posted:'.$date.'</div>';
			if($news['approved'] == 0){
				$status = "Pending for approval";
			}
			else{
				$status = "published";
			}
			echo '<div class="news_status">Status: '.$status.'</div>';
			echo '</div>';
		}
	}
}
else if($currentUser->UserRole == READER){

	?>
	<div id="searchform">
		<script type="text/javascript">
			function search_news(){
				if(document.getElementById("searchstring").value == ""){
					alert("Please enter keyword/keywords (move your mouse over the text box for tips)");
				}
				else{
					document.getElementById("searchfrm").submit();
				}
			}
		</script>
		<form id="searchfrm" action=<?php echo '"'.$_SERVER['REQUEST_URI'].'"' ?> method="post">
			<div title="You can search by entering a single word or two words seperated by ',' e.g. pizza,newcastle or pizaa. The two words entered will be searched together." class="forminput" style="margin-left:68%;margin-top:5px;"><input type="text" id="searchstring" name="searchstring"></div>
			<input type="hidden" name="search" value="1"/>
			<div class="button" style="float:right;margin-top:5px;margin-right:0px;"><input style="height:25px;" type="button" name="search" value="Search" onclick="search_news()" /></div>
		</form>
	</div>
	<?php

	$content = Content::GetContentList();
	if($content == NO_TOPICS_FOUND){
		echo "<h4>No content found!</h4>";
	}
	else{
		/*
		echo "<pre>";
		print_r($content);
		echo "</pre>";
		*/

		foreach ($content as $key => $news) {
			echo '<div class="newslist">';
			echo '<h3 class="newstitle"><a href="'.$_SERVER['REQUEST_URI']."?topic=".$news['topic_ID'].'">'.$news['topic_title'].'</a></h3><p>';
			echo '<div class="shortnews">'.implode(' ', array_slice(explode(' ', $news['content']), 0, 40)).'...';
			echo '<a href="'.$_SERVER['REQUEST_URI']."?topic=".$news['topic_ID'].'" style="float:right">Read more</a>';
			echo '</div>';
			echo '</div>';
		}
	}
}

?>