(function($){
$.fn.newsTicker = function(options) {
	var defaults = {
		speed: 700,
		pause: 4000,
		NoOfItems: 4,
		isPaused: false,
		height: 0
	};

	var options = $.extend(defaults, options);

	
		var obj = $(this);
		var maxHeight = 0;

		obj.css({overflow: 'hidden', position: 'relative'})
			.children('ul').css({position: 'absolute', margin: 0, padding: 0})
			.children('li').css({margin: 0, padding: 0, cursor:'pointer'});

		// Get the height if the list items
			maxHeight = obj.children('ul').children('li').height();
		// Set the height of the newsticker
			obj.height(maxHeight * options.NoOfItems);
		
		// The main function which executes the move-up animation
    	var interval = setInterval(function(){ 
				moveUp(obj, maxHeight, options); 
		}, options.pause);
		
		// To activate mouse pause
			obj.bind("mouseenter",function(){
				options.isPaused = true;
			}).bind("mouseleave",function(){
				options.isPaused = false;
			});
			
	moveUp = function(container, height, options){
		if(options.isPaused)
			return;
		
		var obj_ul = container.children('ul');
		
    	var copy_first = obj_ul.children('li:first').clone(true);
	
    	obj_ul.animate({top: '-=' + height + 'px'}, options.speed, function() {
        	$(this).children('li:first').remove();
        	$(this).css('top', '0px');
        });
		
		obj_ul.children('li:first').fadeOut(options.speed);
		if(options.height == 0)
		{
		obj_ul.children('li:eq(' + options.NoOfItems + ')').hide().fadeIn(options.speed).show();
		}

    	copy_first.appendTo(obj_ul); // Copy the first element back to the main ul object
	};
	
};
})(jQuery);