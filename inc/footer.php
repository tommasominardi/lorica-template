</section>
<div class="clearBoth"></div>

<footer>
	<?php
	foreach($GLOBALS['footer_rows'] as $row)
	{
		?><div class="row"><?php
		
			loricaIncludeModules($row);
		
		?></div><?php
	}
	?>
</footer>

<a href="javascript:kScrollTo(0);" id="goToTop">
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 10.8 10.8">
		<polygon fill="#f7f7f5" points="10.8,5.4 5.4,0 0,5.4 0.3,5.7 5.2,0.9 5.2,10.8 5.6,10.8 5.6,0.9 10.5,5.7 "/>
	</svg>
</a>

</body>
</html>