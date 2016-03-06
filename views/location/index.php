<?php
	$title = "Linger Menu";	
	include_once  '../../config/config.php';
	include_once $serverPath.'resources/templates/head.php';
	
?>

<div class="container-fluid">
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="row">
			<div class="col-md-6">
				<h2 class="primary-color">Come Visit Us</h2>
				<h3>
					<a class="link primary-color-on-hover underline" href="http://maps.apple.com/?q=4142 167th St Oak Forest, Illinois">4142 167th St Oak Forest, Illinois</a>
				</h3>
				<img style="margin-top: 10px" alt="" src="<?php echo $baseURL;?>resources/photos/location.jpg">
				
			</div>
			<div class="col-md-6">
				<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"width="100%" height="440" 
					src="https://maps.google.com/maps?hl=en&q=4142 167th St Oak Forest, Illinois&ie=UTF8&t=roadmap&z=10&iwloc=B&output=embed">
				</iframe>
			
			</div>
		
		
		</div>
	
</div>

</div>



</div>

							
							
<?php include_once $serverPath.'resources/templates/footer.php'; ?>