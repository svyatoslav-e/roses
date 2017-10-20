$(document).ready(function(){

colorbox_css = function() {	    $('#colorbox').css('z-index','9999');
	    $('#cboxOverlay').css('z-index','9999');
	    $('#cboxOverlay').css('opacity','0.3');
	    $('#cboxWrapper').css('z-index','9999');
}


colorbox_resize = function() {

var modal_height = $('#cboxContent').height();
var modal_width = $('#cboxContent').width();

var modalheight_modal = $('#cboxLoadedContent').height();
var modalwidth_modal = $('#cboxLoadedContent').width();

 if (modal_height != modalheight_modal  || modal_width != modalwidth_modal) {
    if (modalheight_modal !=0 && modal_height!= null) {
    		if (modalwidth_modal !=0 && modal_width!= null) {
   				$(this).colorbox.resize();
			}
		}
	}
}


colorbox_image = function(e) {

var gal = $('.imagebox').colorbox({
	 width: "auto",
	 height: "auto",
	 scrolling: true,
	 returnFocusOther: true,
	 reposition: false,
	 fixed: false,
	 maxHeight: "90%",
	 maxWidth: "90%",
	 innerHeight: "90%",
	 innerWidth: "90%",
	 opacity: 0.5,
	 overlayClose: true,
     onLoad: function () {     },
     onComplete: function () {

     	colorbox_css();

        $(this).colorbox.resize();

		colorboxInterval = setInterval( function() {
               colorbox_resize()
			 }, 2000 );
        },

	 onClosed: function(){
			 clearInterval(colorboxtimeout);
			 $.colorbox.close();

	 },
    });

  return gal;
}



colorbox_modal = function(e) {

var colorboxInterval;
var cmswidget =  $(e).attr('data-cmswidget');
var template_modal = $(e).attr('data-template_modal');
var modal_link = $(e).attr('href');

$.ajax({
	url: modal_link,
	type: 'POST',
	data: { cmswidget: cmswidget, sc_ajax: '2', template_modal: template_modal},
	dataType: 'html',
	beforeSend: function()
	{
	},
	success: function(html) {
	if (html) {
	 /************************/
		    $("#modal_base_tmp").remove();

			$('#cmswidget-' + cmswidget).append('<div id="modal_base_tmp" style="display: none; clear: both;"><div id="modal_tmp" style="clear: both;">'+html+'</div></div>');
		    $("#modal_tmp").css( { "width" : "100%" });

			$.colorbox({
			 title: "",
			 width: "auto",
			 height: "auto",
			 scrolling: true,
			 returnFocusOther: true,
			 reposition: false,
			 fixed: false,
			 maxHeight: "90%",
			 maxWidth: "90%",
			 innerHeight: "90%",
			 innerWidth: "90%",
			 opacity: 0.5,
			 overlayClose: true,
			 inline: true,
		     href: '#modal_tmp',
			 onOpen: function(){
			 },
			 onLoad: function(){
			 },
		     onComplete: function () {

                colorbox_css();
                var container_width = $("#modal_tmp").width() - 20;
			   // $("#cboxLoadedContent .breadcrumb ").hide();
		        $("#cboxLoadedContent > div ").css( { "margin" : "0", "padding" : "0px" } );
		        $("#cboxLoadedContent #content").css( { "margin" : "0", "padding" : "0px" } );
		        $("#cboxLoadedContent .row").css( { "margin" : "0", "padding" : "0px" } );
		        $("#cboxLoadedContent .container").css( { "width" : container_width+'px', "padding" : "0px" } );


		        $(window).resize(function() {
		          //colorbox_resize();
		        });

				colorboxInterval = setInterval( function() {
		              // colorbox_resize();
				}, 2000 );

		     },

			 onClosed: function(){
				 clearInterval(colorboxInterval);
				  $("#modal_base_tmp").remove();
		  	 },

			 });
	/*************************/
	}

	}
 });

	return false;

}


var colorbox_loader = function (event) {
	$(document).off('click', '.imagebox', colorbox_loader);
	var gl = colorbox_image(this);
	$(this).click();
	$(document).on('click', '.imagebox', colorbox_loader);
	return false;
}

var colorbox_modal_loader = function (event) {
	colorbox_modal(this);
	return false;
}


//*******************************************
    if ($.isFunction($.fn.on)) {
        $(document).on('click', '.imagebox', colorbox_loader);
    } else {
        $('.imagebox').live('click', colorbox_loader);
    }

    if ($.isFunction($.fn.on)) {
        $(document).on('click', '.colorbox_modal', colorbox_modal_loader);
    } else {
        $('.colorbox_modal').live('click', colorbox_modal_loader);
    }
});