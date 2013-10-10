$(document).ready(function() { 

	$('#login_form').center();    
	$(window).bind('resize', function() {
    $('#login_form').center({transition:300});
  });
		

	$('#login_form').delay(500).show('slow');
	$('#login_form').fadeIn('slow').delay(5000);

	$('#phpos_desktop_logo').delay(2500).show('fast');
	$('#phpos_desktop_logo').fadeIn('slow').delay(5000);		
	
	$('.form_login_btn').mouseenter(function() {
		$(this).removeClass('btn_mouseleave').addClass('btn_mouseenter');	
	});	
	
	$('.form_login_btn').mouseleave(function() {
		$(this).removeClass('btn_mouseenter').addClass('btn_mouseleave');	
	});
		
	$('#input_login').mouseover(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseleave').addClass('input_mouseenter');	
		}
	});	
	
	$('#input_login').mouseleave(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});
	
	$('#input_login').click(function() {
		$('#input_password').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('#input_login').focusin(function() {
		$('#input_password').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	
	$('#input_password').mouseover(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseleave').addClass('input_mouseenter');	
		}
	});	
	
	$('#input_password').mouseleave(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});
	
	$('#input_password').click(function() {
		$('#input_login').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('#input_password').focusin(function() {
		$('#input_login').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('*').click(function() {
		if(!$('#input_password').is(":focus"))
		{
			$('#input_password').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
		
		if(!$('#input_login').is(":focus"))
		{
			$('#input_login').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});		
		
	
	
	 $('#phpos_login').submit(function(){
	 
		if($('#input_login').val() == '' || $('#input_password').val() == '')
		{			
			$('#error_message').html('<p>Error. Login or password is empty.</p>');
			$('#error_message').css('display', 'block');			
		
			return false;
		}   
		
   });
	
	
	$('.form_login_btn').click(function() {
		$('#phpos_login').submit();
	});
	
	
});