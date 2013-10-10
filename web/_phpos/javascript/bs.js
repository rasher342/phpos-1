//Bench Sketch Tool Tip
// Good Tip From BenchSketch.com
// Use it !!
// email benchsketch@gmail.com if you want to get in on this project

(function($){ 
	$.fn.extend({
		bstip: function(options) {
		
				// get user extensions
				var opts = $.extend({}, $.fn.bstip.defaults, options);

			//start to build tips
			return this.each(function(i){						
			   //load properties then create tip
				var nowid=$(this).id, nowtitle=$(this).attr("title"),here=$(this);
				var nowclass=here.attr("class"),nowrel=here.attr("rel");
				
				here.addClass("souniqueithurts");
				
				// I hacked a little bit. Sorry. Let me know if you have a better solution to grabbing the unique selector
				if(nowclass==""){
					newclass="";
				}else{
					newclass=nowclass;
					newclass=newclass.replace(/ /,"");
				}
				if(nowid==""){
					newid="";
				}else{
					newid=nowid;
				}
				if(nowrel==""){
					newrel="";
				}else{
					newrel=nowrel;
				}
				
				
				//Generate Tip Type
				// Tip will get a title :: Menu will get a div based on id from title
				if(opts.type=="tip"){
				
					// If you edit this make sure to back this up
					$("body").append("<div class='"+opts.color+"' id='bs"+i+newclass+newid+newrel+"'>"+opts.forewrap+nowtitle+opts.backwrap+"</div>"); 
				
				}else if(opts.type=="menu"){
					
					// get menu values
					nextitem=$('#'+nowtitle);
					nextcont=nextitem.html();
					
					// If you edit this make sure to back this up
					$("body").append("<div class='"+opts.color+"' id='bs"+i+newclass+newid+newrel+"'>"+opts.forewrap+nextcont+opts.backwrap+"</div>");
					
					// Removes The Item
					nextitem.remove();
				
				}
				
				// Our Position Starts Here
				var bs_tooltip = $("#bs"+i+newclass+newid+newrel); // This is our tooltip
				
				tipwidth=bs_tooltip.width()// Get Tip Width
				tipheight=bs_tooltip.height()//get Tip Height
						
						//Math Vars	
						offset = here.offset(); // this items offset
						left=offset.left;
						right=offset.right;
						nwidth=$(this).width(); // this items width
						nheight=$(this).height(); // this items height
						
						// Generate Positions
						
							// Position Left And Right
							if(opts.hook=="bottom-right" || opts.hook=="mid-right" || opts.hook=="top-right"){
								bleft=offset.left+nwidth+opts.xnudge;
							}else if(opts.hook=="bottom-mid" || opts.hook=="mid-mid" || opts.hook=="top-mid"){
								bleft=offset.left+(nwidth/2)-(tipwidth/2)+opts.xnudge;
							}else if(opts.hook=="bottom-left" || opts.hook=="mid-left" || opts.hook=="top-left"){
								bleft=offset.left-opts.xnudge-tipwidth;
							}
							 //Position Up and Down
							 if(opts.hook=="top-right" || opts.hook=="top-mid" || opts.hook == "top-left"){
								btop=offset.top-opts.ynudge-tipheight;
							 }else if(opts.hook=="mid-right" || opts.hook=="mid-mid" || opts.hook == "mid-left"){
								btop=offset.top+opts.ynudge;
							 }else if(opts.hook=="bottom-right" || opts.hook=="bottom-mid" || opts.hook=="bottom-left"){
								btop=offset.top+nheight+opts.ynudge;
							 }
						 
					// Adjust the css
					bs_tooltip.css({top:btop,left:bleft,position:"absolute",display:"none"});
					
					
		//Check for Stick Type	
		if(opts.sticky=="none"){
			// Adjust the Mouse over with no sticky
			$(this).removeAttr("title").hover(function(){
				bs_tooltip.css({"opacity":opts.opacity}).fadeIn(opts.speed);
			},function(){
				//Time out tack
				t = setTimeout(function(){
					bs_tooltip.fadeOut(opts.speed);
				}, opts.tack);
			});
					bs_tooltip.hover(function(){
						clearTimeout(t);
					},function(){
						t = setTimeout(function(){
							bs_tooltip.fadeOut(opts.speed);						
						}, opts.tack);
					});
			
		}else if(opts.sticky=="move"){
			//Adjust the settings for mouse move
			$(this).removeAttr("title").mouseover(function(){
					bs_tooltip.css({opacity:opts.opacity, display:"none"}).fadeIn(opts.speed);
			}).mousemove(function(kmouse){
						//We need some math to adjust for the hook
						tipwidth=bs_tooltip.width()// Get Tip Width
						tipheight=bs_tooltip.height()//get Tip Height
						// Position Left And Right
							if(opts.hook=="bottom-right" || opts.hook=="mid-right" || opts.hook=="top-right"){
								bleft=kmouse.pageX+opts.xnudge;
							}else if(opts.hook=="bottom-mid" || opts.hook=="mid-mid" || opts.hook=="top-mid"){
								bleft=kmouse.pageX-(tipwidth/2)+opts.xnudge;
							}else if(opts.hook=="bottom-left" || opts.hook=="mid-left" || opts.hook=="top-left"){
								bleft=kmouse.pageX-opts.xnudge-tipwidth;
							}
							 //Position Up and Down
							 if(opts.hook=="top-right" || opts.hook=="top-mid" || opts.hook == "top-left"){
								btop=kmouse.pageY-tipheight-opts.ynudge;
							 }else if(opts.hook=="mid-right" || opts.hook=="mid-mid" || opts.hook == "mid-left"){
								btop=kmouse.pageY-(tipheight/2)+opts.ynudge;
							 }else if(opts.hook=="bottom-right" || opts.hook=="bottom-mid" || opts.hook=="bottom-left"){
								btop=kmouse.pageY+opts.ynudge;
							 }
						
					bs_tooltip.css({left:bleft, top:btop});
			}).mouseout(function(){
					bs_tooltip.fadeOut(opts.speed);
			});	
		}else if(opts.sticky=="slide"){
			//Adjust the settings for mouse move
			$(this).removeAttr("title").mouseover(function(){
					bs_tooltip.css({opacity:opts.opacity, display:"none"}).fadeIn(opts.speed);
			}).mousemove(function(kmouse){
						//We need some math to adjust for the hook
						
						// Position Left And Right
							if(opts.hook=="bottom-right" || opts.hook=="mid-right" || opts.hook=="top-right"){
								bleft=kmouse.pageX+opts.xnudge;
							}else if(opts.hook=="bottom-mid" || opts.hook=="mid-mid" || opts.hook=="top-mid"){
								bleft=kmouse.pageX-(tipwidth/2)+opts.xnudge;
							}else if(opts.hook=="bottom-left" || opts.hook=="mid-left" || opts.hook=="top-left"){
								bleft=kmouse.pageX-opts.xnudge-tipwidth;
							}
							 //Position Up and Down
							 if(opts.hook=="top-right" || opts.hook=="top-mid" || opts.hook == "top-left"){
								btop=top-opts.ynudge-tipheight;
							 }else if(opts.hook=="mid-right" || opts.hook=="mid-mid" || opts.hook == "mid-left"){
								btop=top+opts.ynudge;
							 }else if(opts.hook=="bottom-right" || opts.hook=="bottom-mid" || opts.hook=="bottom-left"){
								btop=top+nheight+opts.ynudge;
							 }
						
					bs_tooltip.css({left:bleft, top:btop});
			}).mouseout(function(){
				
					//Time out tack
				t = setTimeout(function(){
					bs_tooltip.fadeOut(opts.speed);
				}, opts.tack);
			});	
			
					bs_tooltip.hover(function(){
						clearTimeout(t);
					},function(){
						t = setTimeout(function(){
							bs_tooltip.fadeOut(opts.speed);						
						}, opts.tack);
					});
			
		}
						
	
	}); // end return this.each
	} // end bstip: function()
}); // end $.fn.extend
	
			
	
		// True Plugin Defaults
  $.fn.bstip.defaults = {
   		sticky:'move',
		forewrap:'<p>',
		backwrap:'</p>',
		hook:'bottom-right',
		color:'bstip',
		speed:'fast',
		type:'tip',
		tack:0,
		keep:2000,
		ynudge:15,
		xnudge:15,
		opacity:.8
  };

	
})(jQuery); // end (function($){