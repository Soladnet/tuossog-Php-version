<!doctype html>
<html>
<head>
	<?php
	include ("head.php");
	?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<!-- <link rel="stylesheet" href="css/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" /> -->
<script type="text/javascript" src="scripts/jquery.fancybox.pack.js?v=2.1.4"></script>

</head>
<body>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".fancybox").fancybox({
				openEffect	: 'none',
				closeEffect	: 'none'
				
			});
		});
	</script>
	<div class="page-wrapper">
		<?php
		include ("nav.php");
		include ("nav-user.php");
		?>
		<div class="logo"><img src="images/gossout-logo-text-svg.svg" alt=""></div>

		<div class="content">
			<div class="posts">
				<h1>Sample Community</h1>
				<?php 
				include("post-box.php");
				?>
				<div class="timeline-filter">
					<ul>
						<li><span class="icon-16-chat"></span></li>
						<li class="active"><a href="">All</a></li>
						<li><a href=""><p>Friends</p> </a></li>
						<li><a href=""><p>Communities</p></a></li>
					</ul>
				</div>
				<div class="clear"></div>
				<?php 
				include("new-post.php");
				?>
				
			</div>
			
		<?php
			include("sample-community-aside.php");
		?>			
		</div>
		<?php
			include("footer.php");
		?>
	</div>

</body>
</html>