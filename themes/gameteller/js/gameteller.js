/* Undo the silly no-conflict mode for jQuery */
$ = jQuery.noConflict(true);

/* Pretty much nothing; set up the "recommendation" functions for the index site. */
$(document).ready(function()
{
    $(".front-page-link").hide();
    
    $(".reveal-link").mouseleave(function()
    {
    	$('.front-page-link',this).fadeOut();
    });
    
    $(".reveal-link").mouseenter(function()
    {
    	//Have to disable links during fade-in
    	if ($('.front-page-link',this).is(':hidden'))
    	{
	    	$('.front-page-link', this).bind('click', function(e)
	    	{
	            e.preventDefault();
	    	});
	    	
	    	$('.front-page-link',this).fadeIn(200, function()
	    	{	    		
	    		$(this).unbind('click');
	    	});
	    }
    });
});