<form class="invite" method="post" action="<?php echo SELF; ?>">
<input type="hidden" name="do" value="submit">

<fieldset>
	<legend>Invite the Other Side</legend>

	<?php		
		if ( $war->invite != false ) {
			echo "
				<p><strong>Invite sent to {$war->invite->to} ".$war->ago("invite_ts").".</strong> Sending another invite will override the last invite sent.</p>
			";
		}	
	?>	
	
	<ul>
		<li>
			<label>Email Address</label>
			<input type="text" name="to">
		</li>
		<li>
			<label>Message</label>
			<textarea name="msg"></textarea>
		</li>
		<li>
			<button type="submit">Send</button>
		</li>
	</ul>
</fieldset>
</form>