<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; account settings &#9616;</h1>
	
<?php

	// connect to the server and open db2
       	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
		or die (header('Location:skins/error.php'));
	mysql_select_db('db2', $conn)
		or die (header('Location:skins/error.php'));

	// pull out information on the logged in user
	$myQuery = "SELECT * FROM Customer WHERE username='"
		 . $_SESSION['username'] . "';";
	$row = mysql_query($myQuery, $conn)
		or die (header('Location:skins/error.php'));
	$user = mysql_fetch_row($row);

	// if the user entered an incorrect password, send them back with an error
	if ($user[1] != $_POST['password']) {
		header('Location: accountsettings_form.php?pw=false');
		die();
	}

	// update the user's password
	$myQuery = "UPDATE Customer SET password = '" . $_POST['newpassword']
		 . "' WHERE username = '" . $_SESSION['username'] . "';";
	mysql_query($myQuery, $conn)
		or die (header('Location:skins/error.php'));

	// update the user's information
	$myQuery = "UPDATE Customer SET pin='" . $_POST['pin']
		 . "', firstname='" . $_POST['firstname'] . "', lastname='"
		 . $_POST['lastname'] . "', email='" . $_POST['email']
		 . "', birthday='" . $_POST['year'] . "-" . $_POST['month'] . "-"
		 . $_POST['day'] . "', gender='" . $_POST['gender']
		 . "' WHERE username = '" . $_SESSION['username'] . "';";
	mysql_query($myQuery, $conn)
		or die (header('Location:skins/error.php'));

	// close the connection
	mysql_close($conn);

	// display a success message
	echo '<p>Your account information has been updated.</p>';

?>


<?php
	include_once('footer.php');
?>