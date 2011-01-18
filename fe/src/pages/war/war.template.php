<div class="yui3-g block">
	<div class="yui3-u-1-5 hd">
		<em>The Argument: </em>
	</div>
	<div class="yui3-u-4-5">
		<h1><?php echo $war->text; ?></h1>			
		<cite class="main">
			<img width="30" height="30" src="<?php echo $_pic($war->user->profile->fbid); ?>">
			<em>started by <?php echo $war->user->name; ?>
			<?php echo $war->ago('added'); ?></em>
		</cite>		
	</div>
</div>

<div class="yui3-g block">
	<div class="yui3-u-1-5 hd">
		<em>The Sides:</em>
	</div>
	<div class="yui3-u-4-5">
		
		<ul class="dual">
			<?php
		
				foreach ( $sides as $item ) {
				
					echo "
						<li>
							<cite><img src='".$_pic($item->user->profile->fbid)."' width='25' height='25'></cite>
							<blockquote>
								<div class='user'>{$item->user->name}</div>
								{$item->text}
								<em>".$item->ago('added')."</em>	
							</blockquote>
						</li>
					";				
				}
				
				// if there's only one
				if ( $sides->total == 1 ) {
					echo "	
						<li class='empty'>
							<div>
		
					";
					
						// user
						if ( Session::getLogged() AND $war->user->id == $_user->id ) {
							echo "
								<em>No Opposing Side</em>
								<a id='invite-side' rel='panel' data-xhr='pages/+href' href='".b::url('invite',array('war'=>$war->id))."'>Invite Your Opponent</a>
							";							
						}
						
						// invite looks good
						else if ( $war->invite !== false AND p('invite') AND p('invite') == $war->invite->id ) {
							echo "
								<form class='submit' method='post' action='".b::url('index')."'>
								<input type='hidden' name='invite' value='".$war->invite->id."'>
								<input type='hidden' name='id' value='".$war->id."'>						
								<input type='hidden' name='do' value='submit'>
									<fieldset>
										<ul>
											<li>
												<label>Your Side</label>
												<textarea name='f[side]'></textarea>
											</li>		
											<li class='button'>
												<button type='submit'>Go To War</button>
											</li>
										</ul>
									</fieldset>							
								</form>
							";
						}
						else if ( p('invite') AND p('invite') != $war->invite_id ) {
							echo "
								<em>Invalid Invite</em>
								Please try again.
							";
						}
					
						// else
						else {
							echo '<em>No Opposing Side</em>';
						}
					
					echo "
							</div>
						</li>
					";						
				}
				
			?>		
		</ul>	
	
	</div>
	
	<?php if ( $sides->total > 1 ) { ?>
		<div class="yui3-u-1-5 hd">
		</div>
		<div class="yui3-u-4-5">			
			<ul class="dual vote">
				<?php
					foreach ( $sides as $item ) {
						echo "
							<li>
								{% vote(war:{$war->id}, side:{$item->id}) %}
								<ul class='army'>
						";
						
							if ( array_key_exists($item->id, $armies) ) {
								foreach ( $armies[$item->id] as $item ) {						
									echo "
										<li><img class='defer bubble' title='{$item->user->name}' src='".$_pic($item->user->profile->fbid)."' width='25' height='25'></a></li>
									";
								}
							}
						
						echo "		
								</ul>
							</li>
						";	
					}	
				?>
			</ul>
		</div>
	<?php } ?>	
	
</div>

<div class="yui3-g block other">
	<div class="yui3-u-1-5 hd">
		<em>Other Sides: </em>
	</div>
	<div class="yui3-u-3-5">	
		<ul class="recent">
			<?php	
				foreach ( $other as $item ) {
					echo "
						<li>
							<img width='25' height='25' src='".$_pic($item->user->profile->fbid)."'>
							<blockquote>
								<em class='user'>{$item->user->name}</em>
								<h4><a href='".b::url('war',array('slug'=>$item->slug))."'>{$item->text}</a></h4>
								<cite>".$item->ago('added')."</cite>
							</blockquote>
							{% vote(war:{$war->id}, side:{$item->id}, number:true) %}
						</li>	
					"; 
				}		
				if ( $other->total == 0 ) {
					echo "<li class='empty'>There's no other sides to this argument. You should add yours!</a>";
				}
			?>
		</ul>
	</div>
	<div class="yui3-u-1-5">		
		<form class='submit' method='post' action='<?php echo b::url('index'); ?>'>
		<input type='hidden' name='type' value='other'>
		<input type='hidden' name='id' value='<?php echo $war->id; ?>'>
		<input type='hidden' name='do' value='submit'>
			<fieldset>
				<ul>
					<li>
						<label>Tell Your Side</label>
						<textarea name='f[side]'></textarea>
					</li>		
					<li class='button'>
						<button type='submit'>Add Your Side</button>
					</li>
				</ul>
			</fieldset>							
		</form>
	</div>
</div>

<?php /*
		<ul class="share">
			<li class="hd">Share</li>
			<li class='link'><input onclick="this.select();" type="text" value="{$short}"></li>
			<li class="fb"><a class="fb-share" href="#">Post to Facebook</a></li>
			<li class="tw"><a class="twitter-share" href="http://twitter.com/share?url=<?php echo urlencode($short)."&text=Join the the war @waroftruth! "; ?>">Post to Twitter</a></li>
			<li class="email"><a href="mailto:?body={$short}">Email</a></li>
		</ul>
*/ ?>






	
<script type="text/javascript">
	BLT.add('l',function(){	
		
		// tag
		BLT.Obj.cl.WarOfTruth.store.page = <?php echo json_encode(array(
					'asset' => array( 'type' => 'war', 'id' => $war->id, 'argument' => $war->text )
			)); ?>;
			
			
		<?php if ( Session::getLogged() AND p('posted') == 'true' AND $_user->id == $war->user->id ) { ?>
			if ( B.Obj.$('#invite-side') ) { B.Obj.$('#invite-side').simulate('click'); }
		<?php } ?>
			
	});
</script>

<?php /*
		
		
		<?php if ( $war->public ) { ?>
			
			<h3>The Truth</h3>
			<ul class="sides truth">
				<?php
					
					// item
					$item = $sides->item('first');
					
						echo "
							<li>
								<a class='do-vote votes i{$item->id}' href='#'><span>{$item->f_votes}</span> <em>vote up</em></a>
								<cite>
									<a class='img' href='".b::url('user',array('id'=>$war->user->id))."'><img src='".$_pic($war->user->profile->fbid)."'></a>							
								</cite>
								<blockquote>
									<div class='user'>
										<a href='".b::url('user',array('id'=>$war->user->id))."'>{$war->user->name}</a>
										<em>".$item->ago('added')."</em>
									</div>
									{$item->text}
								</blockquote>							
							</li>
						";				
	
				?>		
			</ul>		
			
			
			<h3>The Sides <em>(<?php echo $sides->number('total'); ?>)</em></h3>
			<ul class="sides">
				<?php
					foreach ( $sides as $item ) {
						echo "
							<li>
								<a class='do-vote votes i{$item->id}' href='#'><span>{$item->f_votes}</span></a>
								<cite>
									<a class='img' href='".b::url('user',array('id'=>$war->user->id))."'><img src='".$_pic($war->user->profile->fbid)."'></a>							
								</cite>
								<blockquote>
									<div class='user'>
										<a href='".b::url('user',array('id'=>$war->user->id))."'>{$war->user->name}</a>									
									</div>
									{$item->text}
									<em>".$item->ago('added')."</em>
								</blockquote>							
							</li>
						";				
					}
				?>		
			</ul>
			
		<?php } else { ?>		
		
*/ ?>