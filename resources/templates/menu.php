<header>
	<hr style="margin-bottom: 1px; margin-top: 50px;">
	<nav class="navbar navbar-default main_nav" >
		<div class="container-fluid">
			<div class="navbar-header">
				<a type="button" class="navbar-toggle collapsed" href="#collapse1"
					data-toggle="collapse" data-target="#main_menu"
					aria-expanded="false">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</a>
			</div>
			<div class="collapse navbar-collapse" id="main_menu">
				<ul class="nav navbar-nav" >
					<li><a id="mainMenu_main" class="menu_link" href="<?php echo $baseURL;?>" title="Home Page">Home</a></li>
					<li><a id="mainMenu_events" class="menu_link" href="<?php echo $baseURL;?>events/" title="View Upcoming Events">Events</a></li>
					<li><a id="mainMenu_menu" class="menu_link" href="<?php echo $baseURL;?>menu/" title="See our drink menu!">Menu</a></li>
					<li><a id="mainMenu_book" class="menu_link" href="<?php echo $baseURL;?>book/" title="See how you can book a party">Book A Party</a></li>
					<li><a id="mainMenu_location" class="menu_link" href="<?php echo $baseURL;?>location/" title="Come Visit Us!">Location</a></li>
					<li><a id="mainMenu_photos" class="menu_link" href="<?php echo $baseURL;?>photos/" title="See photos taken at the Linger">Photos</a></li>

				</ul>
			</div>
		</div>
	</nav>
	<hr class="title_line">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="margin-bottom: 10px">
				<div class="fb-like" data-href="https://www.facebook.com/thelingermartinibar/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
				<style>.ig-b- { display: inline-block; }
					.ig-b- img { visibility: hidden; }
					.ig-b-:hover { background-position: 0 -60px; } .ig-b-:active { background-position: 0 -120px; }
					.ig-b-v-24 { width: 137px; height: 24px; background: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24.png) no-repeat 0 0; }
					@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
						.ig-b-v-24 { background-image: url(//badges.instagram.com/static/images/ig-badge-view-sprite-24@2x.png); background-size: 160px 178px; } }</style>
				<a href="https://www.instagram.com/linger_martini_bar/?ref=badge" class="ig-b- ig-b-v-24"><img src="//badges.instagram.com/static/images/ig-badge-view-24.png" alt="Instagram" /></a>
			</div>
		</div>
	</div>
</header>


<script>

	function setMainMenuActiveLink(activeMenuElementId){
		const activeLinkColor = "#d9ca76";
		setColorByElementId(activeMenuElementId, activeLinkColor);
	}

</script>

<body>

