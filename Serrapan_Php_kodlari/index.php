<?php
require_once "init.php";

if(!$visitor)
{
	header("Location: login.php");
	exit();
}
include "header.php";

?>
<?php
include "footer.php";
?>