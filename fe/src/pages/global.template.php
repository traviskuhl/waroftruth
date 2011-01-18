<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>War of Truth<?php echo (isset($metaTitle)?' | '.$metaTitle :''); ?></title>
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?3.2.0/build/cssfonts/fonts-min.css&3.2.0/build/cssreset/reset-min.css&3.2.0/build/cssgrids/grids-min.css">				
		{$cssEmbeds}			
		<script src="<?php echo URI; ?>assets/bolt/js/global.js"></script>    			
	</head>
	<body class="<?php echo (isset($bodyClass)?$bodyClass:''); ?>">
		<div id="doc">
			<div id="hd">
				<div class="cnt">
					<a class="logo" href="/">War of Truth</a>
					<p>you tell your side. they tell theirs. the interweb decides the truth.</p>
					
					<div class="user">
					<?php if ( Session::getLogged() ) { ?>
						<img src="<?php echo $_pic(b::_('_user')->profile->fbid); ?>" width="30" height="30">
						Hello <?php echo b::_('_user')->name; ?>
						<a href="{$url.logout}">Logout</a>					
					<?php } else { ?>
						<a class="fb-login" href="<?php echo b::url('login'); ?>">Login with Facebook</a>
					<?php } ?>
					</div>
					
				</div>
			</div>
			<div id="bd">
				<div class="cnt">{$_body}</div>
			</div>
			<div id="ft">
				&copy 2011 <a href="http://the.kuhl.co">the.kuhl.co</a>
				all rights reserved - 
				made by @<a href="http://twitter.com/traviskuhl">traviskuhl</a>
				
				<em>
					Follow <a href="http://twitter.com/waroftruth">@waroftruth</a> or <a href="http://www.facebook.com/pages/War-of-Truth/175004635868613">on facebook</a>
				</em>
			</div>
		</div>
		
		
		<script type="text/javascript">		
			BLT.init({$jsEmbeds}, {"Urls": { "base": "<?php echo URI; ?>", 'self': "<?php echo SELF ?>", 'login': "<?php echo Config::url('login'); ?>","logout":"<?php echo Config::url('logout'); ?>","ajax":"<?php echo URI; ?>ajax" }, "fb": false, "fbApiKey": "<?php echo Config::get('site/fb-key'); ?>","session": { "logged": <?php echo (Session::getLogged()?'true':'false'); ?>}});     
		</script>
							
		<div id="fb-root"></div>
		<div id="payload"></div>
		
		<?php if ( bDevMode === false ) { ?>
			<script type="text/javascript">
			var clicky = { log: function(){ return; }, goal: function(){ return; }};
			var clicky_site_id = 66374571;
			(function() {
			  var s = document.createElement('script');
			  s.type = 'text/javascript';
			  s.async = true;
			  s.src = ( document.location.protocol == 'https:' ? 'https://static.getclicky.com/js' : 'http://static.getclicky.com/js' );
			  ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
			})();
			</script>
			<a title="Google Analytics Alternative" href="http://getclicky.com/66374571"></a>
			<noscript><p><img alt="Clicky" width="1" height="1" src="http://in.getclicky.com/66374571ns.gif" /></p></noscript>		
		<?php } ?>
		
	</body>
</html>
