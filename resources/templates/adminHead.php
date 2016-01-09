<?php $defaultTitle="Linger Admin"?>

<!doctype html>
<html ng-app="app">
<script type="text/javascript">var baseURL = "<?php echo $baseURL;?>";</script>
<title><?php if(isset($title)){echo $title;}else{echo $defaultTitle;}?></title>

<?php include_once $serverPath.'resources/templates/header.php';?>
<link rel="stylesheet" href="<?php echo $baseURL;?>resources/adminLayout.css"/>	


<?php include_once $serverPath.'resources/templates/adminMenu.php';?>

<script> 	
var baseURL = "<?php echo $baseURL;?>";
</script>