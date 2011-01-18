
<form method="post" action="<?php echo b::url('index'); ?>" class="submit">
<input type="hidden" name="do" value="submit">

	<div>
		<h2>Start an Argument</h2>
		<p>Describe the argument... Give us your side... Invite others to add their side... And the war is on!</p> 
	</div>
	
	<fieldset>
		<?php if ( isset($msg) ) { echo "<div class='error'>{$msg}</div> <script type='text/javascript'> B.add('l',function(){ B.Obj.$('form.submit li').simulate('click'); }); </script>"; } ?>
		<ul>
			<li>
				<label>The Argument</label>
				<textarea name="f[argument]"><?php echo p('f.argument'); ?></textarea>
			</li>
			<li>
				<label>Your Side</label>
				<textarea name="f[side]"><?php echo p('f.side'); ?></textarea>
			</li>		
			<li class="button">
				<button type="submit">Go To War</button>
			</li>
		</ul>
	</fieldset>
	
</form>


<div class="yui3-g">
	<div class="yui3-u-2-3">
		
		<h3>Recent Arguments</h3>
		<ul class="recent">
			<?php
				foreach ( $wars as $item ) {
					echo "
						<li>
							<img width='25' height='25' src='".$_pic($item->user->profile->fbid)."'>
							<blockquote>
								<em class='user'>{$item->user->name}</em>
								<h4><a href='".b::url('war',array('slug'=>$item->slug))."'>{$item->text}</a></h4>
								<cite>".$item->ago('added')."</cite>
							</blockquote>
						</li>
					";
				}
			?>
		</ul>
		
	</div>
	<div class="yui3-u-1-3">
	
		<h3>Recent Activity</h3>
		<ul class="stream">
			<?php
				foreach ( $stream as $item ) {
					echo "
						<li>
							<a href='{$item['link']}'>
								<img src='".$_pic($item['pic'])."' width='35' height='35'>
								<div>
									{$item['text']}
									<em>".b::ago($item['ts'])."</em>
								</div>
							</a>
						</li>
					";				
				}
			?>		
		</ul>
		
	</div>
</div>