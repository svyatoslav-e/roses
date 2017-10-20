$(window).load(function() {
		var $img = $('.bbimage');

		// сбрасываем атрибуты для кеша
		$img.each(function() {
		    var src = $(this).attr('src');
		    $(this).attr('src', '');
		    $(this).attr('src', src);
		});

		// ждем загрузки картинки браузером
		$img.load(function(){
		    // удаляем атрибуты width и height

		   var attrwidth_parent = $(this).closest('div').width();

           if (typeof ($(this).attr("width")) == "undefined") {
     		   	attrwidth = attrwidth_parent;
		    } else {
        		attrwidth = $(this).attr("width");
        		if (attrwidth > attrwidth_parent) {        			attrwidth = attrwidth_parent;
        		}
		    }

		    $(this).removeAttr("width").removeAttr("height").css({ width: "", height: "" });

		    // получаем заветные цифры
		    var width  = $(this).width();
		    var height = $(this).height();

		 if ((width > attrwidth) || (width > attrwidth_parent)) {
			$(this).attr('width', attrwidth+'px');
		 } else {
		    $(this).attr('width', width+'px');
		}
		});
});