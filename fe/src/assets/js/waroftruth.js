YUI.add("bolt-project-wot",function(Y) {

	// shortcuts
	var $ = Y.one, $j = Y.JSON, $b = false;

	// new rashomon
	BLT.add('i',function() { BLT.Obj.cl.WarOfTruth = new BLT.Class.WarOfTruth(); } );

	// base 
	BLT.Class.WarOfTruth = function() {
		this.init();
	}

	// base prototype
	BLT.Class.WarOfTruth.prototype = {
		
		store : {},
		
		// init
		init : function() {
		
			// set b 
			$b = BLT.Obj;	
		
			// mouse
			$('#doc').on('mouseover',this.mouse,this);
			$('#doc').on('mouseout',this.mouse,this);

			$('#doc').on('click', this.click, this);
			
			// fbPerms
			$b.fbPerms = "email";
		
			// init facebook
			$b.fbInit();
		
			// submit
			if ( $('form.submit') ) {
			
				// when it's clicked on
				// open it up
				$('form.submit li').on('click',function(e){
					Y.all('form.submit textarea').each(function(el){
						el.transition({
							'height': '100px',
							'duration':.3
						});	
					});							
					$b.getParent(e.target,{'tag':'li'}).one('textarea').focus();
				},this);
				
				// when they submit
				$("form.submit").on('submit',function(e){
				
					// stop by default
					e.halt();
				
					// login
					$b.fbLogin(function(){
						$('form.submit').submit();
					});
				
				});
			
			}
		
		},
		
		click : function(e) {
		
			// tar
			var tar = e.target, otar = e.target;		
		
			// do-vote
			if ( (tar = $b.getParent(otar, 'do-vote')) ) {
				e.halt(); this.vote(tar);
			}
			else if ( otar.hasClass('fb-share') ) {
							
				// no click
				e.halt();	
							
				 FB.ui(
				   {
				     method: 'feed',
				     name: 'Facebook Dialogs',
				     link: document.href,
				   },
				   function(response) {
				   }
				 );			
			
			}
			else if ( otar.hasClass('twitter-share') ) {
				
				// stop
				e.halt();
				
				// open in a new window
				window.open( otar.getAttribute('href'), 'twitter', "width=600,height=150" );
				
			}			
		
		},
		
		mouse : function(event) {
		
			// targ
			var e = event;
			var tar = e.target;
			var oTar = tar;
			var self = this;
			
			// bubble
			if ( (tar = BLT.Obj.getParent(oTar,'bubble')) ) {
				BLT.Obj.titleBubble(tar, e, e.type);
			}
		
		},
		
		vote : function(tar) {
		
			// get the id
			var _id = false;
				
				// class
				var cl = tar.getAttribute('class').split(' ');
				
				// loop through eahc
				for ( var c in cl ) {
					if ( cl[c].substr(0,1) == 'i' ) {
						_id = cl[c].substr(1);
					}
				}
		
			// localize
			var _self = this, _tar = tar;
		
			// vote
			var _vote = function() {
				
				// url
				var url = $b.getAjaxUrl('pages/index/vote?id='+_id);
			
				// do it 
				Y.io(url,{
					'on': {
						'success': function(id, o) {
							var j = $j.parse(o.responseText);
							if ( j.num ) {
								Y.all('.i'+_id).each(function(el){
									el.one('span').set('innerHTML', j.num);
									el.one('em').set('innerHTML','votes');
									el.removeClass('do-vote');
								});
							}
						}
					}
				});
			
			};
		
			// lets vote it up
			// but first we need to see if they're logged in
			FB.getLoginStatus(function(r){	
				( r.session ? _vote() : $b.fbLogin(_vote) );
			});
		
			
			
		}
		
	}
	
});