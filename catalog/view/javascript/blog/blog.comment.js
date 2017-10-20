// http://opencartadmin.com © 2011-2015 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
//************************************************
comments_vote = function (thisis) {
    var acr = load_acr(thisis);
    var acc = load_acc(thisis);

    var prefix = acr['prefix'];
    var mark = acr['mark'];


    if (typeof (acr['exec']) == "undefined" || acr['exec'] == '') {
        exec = '';
    } else {
        exec = acr['exec'];
    }

    var ascp_widgets_position_var = acr['ascp_widgets_position'];

    var text_voted_blog_plus_var = acc['text_voted_blog_plus'];
    var text_voted_blog_minus_var = acc['text_voted_blog_minus'];
    var text_all_var = acc['text_all'];

    var comment_id = $('#' + $(thisis).parents().prev('.container_comment_vars:first').prop('id')).find('.comment_id:first').text();
    var delta = 0;

    if ($(thisis).hasClass('blog_plus')) {
        delta = '1';
    } else {
        delta = '-1';
    }

    if ($(thisis).hasClass('loading')) {} else {
        $(thisis).addClass('loading');

        $.ajax({
            type: 'POST',
            url: 'index.php?route=record/treecomments/comments_vote&ascp_widgets_position=' + ascp_widgets_position_var + '&mark=' + mark,
            dataType: 'json',
            data: 'comment_id=' + encodeURIComponent(comment_id) + '&delta=' + encodeURIComponent(delta),
            beforeSend: function () {
                $('.success, .warning, .cmswidget .alert').remove();

            },
            success: function (data) {
                if (data.error) {
                    alert('error');
                }

                if (data.success) {

                    if (data.messages == 'ok') {

                        var voting = $('#voting_' + comment_id);
                        // выделим отмеченный пункт.
                        if (delta == '1') {
                            voting.addClass('voted_blog_plus').prop('title', text_voted_blog_plus_var);
                            $('.comment_yes', voting).addClass('voted_comment_plus');
                        } else if (delta == '-1') {
                            voting.addClass('voted_blog_minus').prop('title', text_voted_blog_minus_var);
                            $('.comment_no', voting).addClass('voted_comment_minus');
                        }

                        // обновим кол-во голосов
                        $('.score', voting).replaceWith('<span class="score" title="' + text_all_var + ' ' + data.success.rate_count + ': &uarr;' + data.success.rate_delta_blog_plus + ' и &darr;' + data.success.rate_delta_blog_minus + '">' + data.success.rate_delta + '</span>');

                        $('.score_plus', voting).html(data.success.rate_delta_blog_plus);
                        $('.score_minus', voting).html(data.success.rate_delta_blog_minus);

                        // раскрасим positive / negative
                        $('.mark', voting).prop('class', 'mark ' + data.sign);

                        if (exec != '') {
                           // eval(exec);
                        }

                    } else {

                        $('#' + prefix + 'comment_work_' + comment_id).append('<div class="warning alert alert-danger">' + data.success + ' <img src="catalog/view/theme/default/image/aclose.png" alt="" class="close"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        remove_success();
                    }

                }

            }
        });

        $(thisis).removeClass('loading');
    }

    return false;
}


//*************** $(document).on('click','.comments_vote') ********************


comments_vote_loader = function () {

    if ($.isFunction($.fn.on)) {
        $(document).on('click', '.comments_vote', function ( event, person) {

            comments_vote($(this));

            return false;
        });

    } else {

            $('.comments_vote').live('click', function () {
                comments_vote($( this ));
                return false;
            });

    }
  }


document.documentElement.id = "js";


$(document).ready(function () {





});
//*************** /$(document).on('click','.comments_vote') ********************


function captcha_fun() {

        $.ajax({
            type: 'POST',
            url: 'index.php?route=record/treecomments/captcham',
            dataType: 'html',
            success: function (data) {
                $('.captcha_status').html(data);
                return false;
            }
        });

        var timestamp = new Date().getTime();

        $('#imgcaptcha').removeAttr('src');
        /*
        $.ajax({
            type: 'POST',
            url: 'index.php?route=record/treecomments/captchadel&z=' + timestamp + Math.random(),
            dataType: 'html',
            success: function (data) {
                timestamp = new Date().getTime();
                $('#imgcaptcha').prop({
                    type: 'image/jpg',
                    src: 'index.php?route=record/treecomments/captcham5&m=' + timestamp + Math.random()
                });
            }
        });
        */
        return false;
    }
    //**************** /captcha_fun() ********************************

//**************** subcaptcha() ********************************
function subcaptcha(e) {

        ic = $('.captcha').val();
        $('.captcha').val(ic + this.value)
        return false;
    }
    //**************** /subcaptcha() ********************************
FSelectedText = function () {
    if (!$('#ctrlcopy').length > 0) {
        $('body').append('<div id=\"ctrlcopy\"><\/div>');
    }
    if ($.isFunction($.fn.on)) {
        $(document).on('mouseup', function (e) {
            // var highlighted;

            var selectedText = '';
            if (selectedText = window.getSelection) { // Не IE, используем метод getSelection
                selectedText = window.getSelection().toString();
            } else { // IE, используем объект selection
                selectedText = document.selection.createRange().text;
            }

            // if (window.getSelection) {
            //    highlighted  = window.getSelection();
            //   } else if (document.selection) {
            //      highlighted = document.selection.createRange();
            //   }
            //   if (highlighted.toString() !=='' && highlighted) {
            //  	var selectedText = highlighted.toString();
            //   }

            $('#ctrlcopy').text(selectedText + '');

            return selectedText; // to be added to clipboard
        });
    } else {

        $(document).live('mouseup', function () {

            var selectedText = '';
            if (selectedText = window.getSelection) { // Не IE, используем метод getSelection
                selectedText = window.getSelection().toString();
            } else { // IE, используем объект selection
                selectedText = document.selection.createRange().text;
            }

            $('#ctrlcopy').text(' ' + selectedText + ' ');


            return selectedText; // to be added to clipboard
        });

    }
}



insertSelectText = function (command, value, queryState) {
    // где, command - имя ББ кода
    // value - значение
    // queryState - активен ли этот ББ код в данный момент

    //this.wbbInsertCallback(command,value) // Вставка значения в редактора, value - объект с параметрами вставки
    //this.wbbRemoveCallback(command); // удаление текущего ББ кода с сохранением содержимого
    //this.wbbRemoveCallback(command,true) - удаление текущего ББ кода вместе со содержимым
    //this.showModal.call(this,command,opt.modal,queryState); //Показ модального окна средствами WysiBB
    //opt.modal.call(this,command,opt.modal,queryState); //Показ подключенного модального окна

    //В нашем примере, мы вставляем цитату
    var seltxt = $('#ctrlcopy').html();

    if (seltxt == 'false') seltxt = '';
    this.wbbInsertCallback(command, {
            seltext: seltxt
        })
        //Если не задать значение seltext - то будет взят текущий выделенный текст

}


//**************** wisybbinit() ********************************
wisybbinit = function (cid, prefix) {

        var my_id = '0';

        if (typeof (this.id) == "undefined") {
            my_id = '0';
        } else {
            my_id = this.id;
        }

        if (my_id == '0') {
            my_id = 'editor_' + cid;
        }

        var wbbOpt = {
            buttons: 'bold,italic,|,img,video,link,|,fontcolor,fontsize,|,quote',
            allButtons: {
                //quote: {
                //    cmd: insertSelectText, //подключение функции-обработчика
                 //   transform: {
                 //       '<div class="quote"><cite>{AUTHOR}</cite>{SELTEXT}</div>': '[quote{AUTHOR}]{SELTEXT}[/quote]'
                //    }
              //  }
            }
        }


        $('#' + prefix + my_id).wysibb(wbbOpt);
        //Передать фокус для Opera и старых версий браузеров
        // $('#'+prefix+my_id).execCommand("justifyleft");


        $('.wysibb-body').css('height', $('.blog-textarea_height').css('height'));



        $('span.powered').hide();
    }
    //**************** /wisybbinit() ********************************

//**************** wisybbdestroy() ********************************
wisybbdestroy = function (prefix, acr) {

        if (acr['visual_editor'] == '1') {
            $('.' + prefix + 'editor').each(function () {
                var data = $(this).data("wbb");
                if (data) {
                    $(this).destroy();
                }
            });
        }

        if (acr['visual_rating'] == '1') {
            ratingdestroy('.visual_star');
        }

    }
    //**************** /wisybbdestroy() ********************************

//**************** wisybbloader() ********************************
wisybbloader = function (cid, prefix, acr) {
        if (acr['visual_editor'] == '1') {
            wisybbdestroy(prefix, acr);
            wisybbinit(cid, prefix);
        }

        if (acr['visual_rating'] == '1') {
            ratingloader('.visual_star');
        }
    }
    //**************** /wisybbloader() ********************************




//**************** ratingdestroy() ********************************
ratingdestroy = function (id) {
        $('.star-rating-control').each(function () {
            $(this).remove();
            $(id).removeClass('star-rating-applied').show();
        });
    }
    //**************** /ratingdestroy() ********************************

//**************** ratingloader() ********************************
ratingloader = function (id) {
        $(id).rating({
            focus: function (value, link) {
                var tip = $('#hover-test');
                var rcolor = $(this).prop('alt');
                tip[0].data = tip[0].data || tip.html();
               // tip.html('<ins style="color:' + rcolor + ';">' + link.title + '<\/ins>' || 'value: ' + value);
                $('.rating-cancel').hide();
            },
            blur: function (value, link) {
                var tip = $('#hover-test');
                $('#hover-test').html(tip[0].data || '');
                $('.rating-cancel').hide();
            }
        });

        $('.rating-cancel').hide();

    }
    //**************** /ratingloader() ********************************


//**************** remove_success() ********************************
remove_success = function () {
        $('.cmswidget .success, .cmswidget .warning, .cmswidget .attention, .cmswidget .alert').fadeIn().animate({
            opacity: 0.3
        }, 10000, function () {
            $('.cmswidget .success, .cmswidget .warning, .cmswidget .attention , .cmswidget .alert').remove();
        });
    }
    //**************** /remove_success() ********************************




load_acr = function (this_data) {
    var cmswidget = $(this_data).attr('data-cmswidget');

    var avars = {};

    //avars['mark'] = $('#' + $(this_data).closest('div[id] .container_reviews').prop('id')).find('.mark:first').text();

    avars['mark'] = $('.acr' + cmswidget).find('.mark:first').attr('data-text');
    avars['mark_id'] = $('.acr' + cmswidget).find('.mark_id:first').attr('data-text');
    avars['theme'] = $('.acr' + cmswidget).find('.theme:first').attr('data-text');
    avars['exec'] = $('.acr' + cmswidget).find('.exec:first').attr('data-text');
    avars['visual_editor'] = $('.acr' + cmswidget).find('.visual_editor:first').attr('data-text');
    avars['ascp_widgets_position'] = $('.acr' + cmswidget).find('.ascp_widgets_position:first').attr('data-text');
    avars['thislist'] = $('.acr' + cmswidget).find('.thislist:first').attr('data-text');
    avars['text_wait'] = $('.acr' + cmswidget).find('.text_wait:first').attr('data-text');
    avars['visual_rating'] = $('.acr' + cmswidget).find('.visual_rating:first').attr('data-text');
    avars['signer'] = $('.acr' + cmswidget).find('.signer:first').attr('data-text');
    avars['imagebox'] = $('.acr' + cmswidget).find('.imagebox:first').attr('data-text');
    avars['prefix'] = $('.acr' + cmswidget).find('.prefix:first').attr('data-text');

    /*

if (typeof acrr == "undefined") {
	var acrr = new Array();
}
acrr['<?php echo $cmswidget; ?>_mark'] = '<?php echo $mark; ?>';
acrr['<?php echo $cmswidget; ?>_mark_id'] = '<?php echo $mark_id; ?>';
acrr['<?php echo $cmswidget; ?>_theme'] = '<?php echo $theme; ?>';
acrr['<?php echo $cmswidget; ?>_exec'] = '';
acrr['<?php echo $cmswidget; ?>_visual_editor'] = '<?php echo $visual_editor; ?>';
acrr['<?php echo $cmswidget; ?>_ascp_widgets_position'] = '<?php echo $this->registry->get('ascp_widgets_position');?>';
acrr['<?php echo $cmswidget; ?>_thislist'] = '<?php echo base64_encode(serialize($thislist)); ?>';
acrr['<?php echo $cmswidget; ?>_text_wait'] = '<?php echo $text_wait; ?>';
acrr['<?php echo $cmswidget; ?>_visual_rating'] = '<?php echo $settings_widget['visual_rating']; ?>';
acrr['<?php echo $cmswidget; ?>_signer'] = '<?php echo $settings_widget['signer']; ?>';
acrr['<?php echo $cmswidget; ?>_imagebox'] = '<?php echo $imagebox; ?>';
acrr['<?php echo $cmswidget; ?>_prefix'] = '<?php echo $prefix;?>';


    avars['mark'] = acrr[cmswidget+'_mark'];
    avars['mark_id'] = acrr[cmswidget+'_mark_id'];
    avars['theme'] = acrr[cmswidget+'_theme'];
    avars['exec'] = acrr[cmswidget+'_exec'];
    avars['visual_editor'] = acrr[cmswidget+'_visual_editor'];
    avars['ascp_widgets_position'] = acrr[cmswidget+'_ascp_widgets_position'];
    avars['thislist'] = acrr[cmswidget+'_thislist'];
    avars['text_wait'] = acrr[cmswidget+'_text_wait'];
    avars['visual_rating'] = acrr[cmswidget+'_visual_rating'];
    avars['signer'] = acrr[cmswidget+'_signer'];
    avars['imagebox'] = acrr[cmswidget+'_imagebox'];
    avars['prefix'] = acrr[cmswidget+'_prefix'];
      */

    return avars;
}


load_acc = function (this_data) {
    var cmswidget = $(this_data).attr('data-cmswidget');

    var avars = {};

   // avars['mark'] = $('#' + $(this_data).parents().find('.container_comments').attr('id')).find('.mark:first').text();

    avars['mark'] = $('.acc' + cmswidget).find('.mark:first').attr('data-text');
    avars['sorting'] = $('.acc' + cmswidget).find('.sorting:first').attr('data-text');
    avars['page'] = $('.acc' + cmswidget).find('.page:first').attr('data-text');
    avars['mark_id'] = $('.acc' + cmswidget).find('.mark_id:first').attr('data-text');
    avars['text_rollup_down'] = $('.acc' + cmswidget).find('.text_rollup_down:first').attr('data-text');
    avars['text_rollup'] = $('.acc' + cmswidget).find('.text_rollup:first').attr('data-text');
    avars['visual_editor'] = $('.acc' + cmswidget).find('.visual_editor:first').attr('data-text');
    avars['ascp_widgets_position'] = $('.acc' + cmswidget).find('.ascp_widgets_position:first').attr('data-text');
    avars['text_voted_blog_plus'] = $('.acc' + cmswidget).find('.text_voted_blog_plus:first').attr('data-text');
    avars['text_voted_blog_minus'] = $('.acc' + cmswidget).find('.text_voted_blog_minus:first').attr('data-text');
    avars['text_all'] = $('.acc' + cmswidget).find('.text_all:first').attr('data-text');
    avars['prefix'] = $('.acc' + cmswidget).find('.prefix:first').attr('data-text');

    /*
    avars['mark'] = accc[cmswidget+'_mark'];
    avars['sorting'] = accc[cmswidget+'_sorting'];
    avars['page'] = accc[cmswidget+'_page'];
    avars['mark_id'] = accc[cmswidget+'_mark_id'];
    avars['text_rollup_down'] = accc[cmswidget+'_text_rollup_down'];
    avars['text_rollup'] = accc[cmswidget+'_text_rollup'];
    avars['visual_editor'] = accc[cmswidget+'_visual_editor'];
    avars['ascp_widgets_position'] = accc[cmswidget+'_ascp_widgets_position'];
    avars['text_voted_blog_plus'] = accc[cmswidget+'_text_voted_blog_plus'];
    avars['text_voted_blog_minus'] = accc[cmswidget+'_text_voted_blog_minus'];
    avars['text_all'] = accc[cmswidget+'_text_all'];
    avars['prefix'] = accc[cmswidget+'_prefix'];
    */

    return avars;
}


//**************** comments() ********************************
$.fn.comments = function (acr, acc) {

		if (typeof acc == "undefined") {
			var acc = new Array();
		}

        var sorting = acc['sorting'];
        var page = acc['page'];

        var mark = acr['mark'];
        var mark_id = acr['mark_id'];
        var thislist = acr['thislist'];
        var ascp_widgets_position = acr['ascp_widgets_position'];
        var prefix = acr['prefix'];

        if (typeof (sorting) == "undefined") {
            sorting = 'none';
        }

        if (typeof (page) == "undefined") {
            page = '1';
        }
        var url_str = 'index.php?route=record/treecomments/comment&prefix=' + prefix + '&' + mark + '=' + mark_id + '&sorting=' + sorting + '&wpage=' + page + '&ascp_widgets_position=' + ascp_widgets_position + '&sc_ajax=1';

        return $.ajax({
            type: 'POST',
            url: url_str,
            data: {
                thislist: thislist
            },
        	    dataType: 'html',
    	        async: 'false',
  	          	beforeSend: function () {
            },

            success: function (data) {

                $('#' + prefix + 'comment_' + mark_id).html(data);

            },
            complete: function (data) {
                captcha_fun();
            }
        });
    }
    //**************** /comments() ********************************


//**************** comment_write() ********************************
function comment_write(event) {

    var acr = event.data.acr;
    var acc = event.data.acc;
    $('.success, .warning, .cmswidget .alert').remove();

    if (typeof (event.data.acc['sorting']) == "undefined") {
        sorting = 'none';
    } else {
        sorting = event.data.acc['sorting'];
    }

    if (typeof (event.data.acc['page']) == "undefined") {
        page = '1';
    } else {
        page = event.data.acc['page'];
    }

    if (typeof (event.data.acr['mark']) == "undefined") {
        mark = 'product_id';
    } else {
        mark = event.data.acr['mark'];
    }
    if (typeof (event.data.acr['exec']) == "undefined" || event.data.acr['exec'] == "") {
        exec = '';
    } else {
        exec = event.data.acr['exec'];
    }


    if (typeof (event.data.acr['thislist']) == "undefined") {
        thislist = '';
    } else {
        thislist = event.data.acr['thislist'];
    }

    if (typeof (event.data.acr['prefix']) == "undefined") {
        prefix = '';
    } else {
        prefix = event.data.acr['prefix'];
    }



    if (typeof (event.data.acr['mark_id']) == "undefined") {
        mark_id = false;
    } else {
        mark_id = event.data.acr['mark_id'];
    }

    if (typeof (event.data.acr['theme']) == "undefined") {
        theme = 'default';
    } else {
        theme = event.data.acr['theme'];
    }

    if (typeof (event.data.acr['visual_editor']) == "undefined") {
        visual_editor = '0';
    } else {
        visual_editor = event.data.acr['visual_editor'];
    }

    if (typeof (event.data.acr['ascp_widgets_position']) == "undefined") {
        ascp_widgets_position = '0';
    } else {
        ascp_widgets_position = event.data.acr['ascp_widgets_position'];
    }

    if (typeof (event.data.acr['text_wait']) == "undefined") {
        text_wait = 'Please wait...';
    } else {
        text_wait = event.data.acr['text_wait'];
    }




    if (typeof (this.id) == "undefined") {
        myid = '0';
    } else {
        myid = this.id.replace(prefix + 'button-comment-', '');
    }


    if (visual_editor == '1') {
        $('#' + prefix + 'editor_' + myid).wysibb().sync();
    }
    var data_form = $('#' + prefix + 'form_work_' + myid).serialize();

    var url_end = mark + '=' + mark_id + '&parent=' + myid + '&wpage=' + page + '&ascp_widgets_position=' + ascp_widgets_position + '&mark=' + mark;
    var url_str = 'index.php?route=record/treecomments/write&' + url_end;

    $.ajax({
        type: 'POST',
        url: url_str,
        dataType: 'html',
        data: data_form,

        beforeSend: function () {

            $('.cmswidget .success, .cmswidget .warning, .cmswidget .attention, .cmswidget  .alert').remove();
            $('.button-comment').hide();
            $('#' + prefix + 'comment_work_' + myid).hide();
            $('#' + prefix + 'comment_work_' + myid).before('<div class="attention alert alert-attention">'+text_wait+'<img src="catalog/view/theme/' + theme + '/image/aloading16.png" alt="">' +  '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');


            wisybbdestroy(prefix, acr);


        },
        error: function () {
            $('.cmswidget .success, .cmswidget .warning, .cmswidget .attention, .cmswidget  .alert').remove();
            alert('error');
        },
        success: function (data) {

            $('#' + prefix + 'comment_work_' + myid).prepend(data);

            $('.success, .attention').remove();

            if (wdata['code'] == 'error') {
                $('#' + prefix + 'comment_work_' + myid).show();

                if (myid == '0') $('#' + prefix + 'comment-title').after('<div class="warning alert alert-danger">' + wdata['message'] + ' <img src="catalog/view/theme/default/image/aclose.png" alt="" class="close"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                else
                    $('#' + prefix + 'comment_work_' + myid).prepend('<div class="warning alert alert-danger">' + wdata['message'] + ' <img src="catalog/view/theme/default/image/aclose.png" alt="" class="close"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            if (wdata['code'] == 'success') {

                $.when($('#' + prefix + 'comment_' + mark_id).comments(acr, acc)).done(function () {

                    if (myid == '0') {
                        $('#' + prefix + 'comment-title').after('<div class="success alert alert-success">' + wdata['message'] + ' <img src="catalog/view/theme/default/image/aclose.png" alt="" class="close"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    } else {

                        $('#' + prefix + 'comment_work_' + myid).append('<div class="success alert alert-success">' + wdata['message'] + ' <img src="catalog/view/theme/default/image/aclose.png" alt="" class="close"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }

                    remove_success();
                });

                $('#tabs').find('a[href=\'#tab-review\']').html(wdata['review_count']);

                $('input[name=\'name\']').val(wdata['login']);
                $('.wysibb-text-editor').html('');
                $('input[name=\'rating\']:checked').prop('checked', '');
                $('textarea[name=\'text\']').val('');
                $('input[name=\'captcha\']').val('');
                $('#' + prefix + 'comment_work_0').show();

            }

            $('.button-comment').show();

            //if (acr['visual_editor']=='1')
            {
                wisybbloader(myid, acr['prefix'], acr);
            }



        }
    });
}

//**************** /comment_write() ********************************



//**************** $(document).ready ********************************
$(document).ready(function () {

    var bingo = false;
	var $events = jQuery.data(jQuery(document)[0], "events" );

	if(typeof $events == "undefined"){
		var $events = jQuery(document).data('events');
	}
	if(typeof $events == "undefined"){
		var $events = jQuery(document).data('events');
	}

	if(typeof $events != "undefined"){
	    jQuery.each($events, function(i, event){
	        jQuery.each(event, function(i, handler){
	            if (handler['selector']=='.comments_vote') {
                  bingo = true;
	            }
	        });
	    });
	}

     //******* bingo *********//
    if (!bingo) {

    	 comments_vote_loader();
    	// FSelectedText();


    //*************** $(document).on('click','.comments_rollup') ********************
    if ($.isFunction($.fn.on)) {
        $(document).on('click', '.comments_rollup', function () {
            var acc = load_acc(this);
            var text_rollup_down = acc['text_rollup_down'];
            var text_rollup = acc['text_rollup'];

            var child_id = $(this).parents().next('.comments_parent:first').attr('id');

            if ($('#' + child_id).is(':hidden') == false) {
                $(this).html(text_rollup_down);
            } else {
                $(this).html(text_rollup);
            }

            $('#' + child_id).toggle();


            return false;
        });

    } else {
        $('.comments_rollup').live('click', function () {
            var acc = load_acc(this);
            var text_rollup_down = acc['text_rollup_down'];
            var text_rollup = acc['text_rollup'];

            var child_id = $(this).parents().next('.comments_parent:first').attr('id');

            if ($('#' + child_id).is(':hidden') == false) {
                $(this).html(text_rollup_down);
            } else {
                $(this).html(text_rollup);
            }

            $('#' + child_id).toggle();


            return false;
        });
    }
    //*************** /$(document).on('click','.comments_rollup') ********************


    //*************** $(document).on('click','.comment_reply') ********************
    if ($.isFunction($.fn.on)) {
        $(document).on('click', '.comment_reply', function () {
            var acr = load_acr(this);
            var acc = load_acc(this);


            var cid = $('#' + $(this).parents().prev('.container_comment_vars:first').prop('id')).find('.comment_id:first').text();
            if (cid == '') cid = 0;

            var prefix = acr['prefix'];

            wisybbdestroy(prefix, acr);


            $('.success, .warning, .cmswidget  .alert').remove();


            $('.' + acr['prefix'] + 'comment_work').html('');

            html_reply = $('#' + acr['prefix'] + 'reply_comments').html();

            $('#' + acr['prefix'] + 'comment_work_' + cid).html(html_reply);
            $('#' + acr['prefix'] + 'comment_work_' + cid).show();

            $('#' + acr['prefix'] + 'comment_work_' + cid).find('#' + acr['prefix'] + 'comment_work_').prop('id', acr['prefix'] + 'c_w_' + cid);
            $('#' + acr['prefix'] + 'comment_work_' + cid).find('#' + acr['prefix'] + 'form_work_').prop('id', acr['prefix'] + 'form_work_' + cid);
            $('#' + acr['prefix'] + 'comment_work_' + cid).find('#' + acr['prefix'] + 'editor_').prop('id', acr['prefix'] + 'editor_' + cid);

            $('#' + acr['prefix'] + 'comment_work_' + cid).find('.button-comment').prop('id', '' + acr['prefix'] + 'button-comment-' + cid);

            $('.bkey').unbind();
            $('.bkey').bind('click', {
                id: cid
            }, subcaptcha);

            $('#' + acr['prefix'] + 'button-comment-' + cid).bind('click', {
                acr: acr,
                acc: acc
            }, comment_write);

            captcha_fun();

            //if (acr['visual_editor']=='1')
            {
                wisybbloader(cid, acr['prefix'], acr);
            }


            return false;
        });

    } else {
        $('.comment_reply').live('click', function () {
            var acr = load_acr(this);
            var acc = load_acc(this);


            var cid = $('#' + $(this).parents().prev('.container_comment_vars:first').prop('id')).find('.comment_id:first').text();
            if (cid == '') cid = 0;

            var prefix = acr['prefix'];

            wisybbdestroy(prefix, acr);

            $('.success, .warning, .cmswidget  .alert').remove();

            $('.' + acr['prefix'] + 'comment_work').html('');

            html_reply = $('#' + acr['prefix'] + 'reply_comments').html();



            $('#' + acr['prefix'] + 'comment_work_' + cid).html(html_reply);
            $('#' + acr['prefix'] + 'comment_work_' + cid).show();

            $('#' + acr['prefix'] + 'comment_work_' + cid).find('#' + acr['prefix'] + 'comment_work_').prop('id', acr['prefix'] + 'c_w_' + cid);
            $('#' + acr['prefix'] + 'comment_work_' + cid).find('#' + acr['prefix'] + 'form_work_').prop('id', acr['prefix'] + 'form_work_' + cid);
            $('#' + acr['prefix'] + 'comment_work_' + cid).find('#' + acr['prefix'] + 'editor_').prop('id', acr['prefix'] + 'editor_' + cid);

            $('#' + acr['prefix'] + 'comment_work_' + cid).find('.button-comment').prop('id', '' + acr['prefix'] + 'button-comment-' + cid);

            $('.bkey').unbind();
            $('.bkey').bind('click', {
                id: cid
            }, subcaptcha);

            $('#' + acr['prefix'] + 'button-comment-' + cid).bind('click', {
                acr: acr,
                acc: acc
            }, comment_write);

            captcha_fun();

            //if (acr['visual_editor']=='1')
            {
                wisybbloader(cid, acr['prefix'], acr);
            }


            return false;
        });
    }
    //*************** /$(document).on('click','.comment_reply') ********************


    customer_enter = function (thisis) {
            var acr = load_acr(thisis);
            var html_form_customer = $('#' + acr['prefix'] + 'form_customer').clone();

              $('#' + acr['prefix'] + 'form_customer').remove();

            $('#' + $(thisis).parents('div[id] .' + acr['prefix'] + 'form_customer_pointer').prop('id') + '.' + acr['prefix'] + 'form_customer_pointer').prepend(html_form_customer);

            $('#' + acr['prefix'] + 'form_customer').show();

            return false;
        }
        //*************** $(document).on('click','.customer_enter') ********************
    if ($.isFunction($.fn.on)) {
        $(document).on('click', '.customer_enter', function () {
            customer_enter(this);
            return false;
        });

    } else {

        $('.customer_enter').live('click', function () {
            customer_enter(this);
            return false;
        });

    }
    //*************** /$(document).on('click','.customer_enter') ********************
    comments_sorting = function (thisis) {
        var acc = load_acc(thisis);
        var acr = load_acr(thisis);
        acc['sorting'] = thisis.value;

        $('#' + acr['prefix'] + 'comment_' + acr['mark_id']).comments(acr, acc);
        return false;
    }

    if ($.isFunction($.fn.on)) {
        $(document).on('change', '.comments_sorting', function (event) {
            comments_sorting(this);
            return false;
        });

    } else {

        $('.comments_sorting').live('change', function () {
            comments_sorting(this);
            return false;
        });

    }


    //*************** $(document).on('click','#tab-review .pagination a') ********************
    if ($.isFunction($.fn.on)) {
        $(document).on('click', '#tab-review .pagination a', function () {

            var acr = load_acr(this);

            var theme_var = acr['theme'];
            var text_wait_var = acr['text_wait'];

            $('#tab-review').prepend('<div class="attention alert alert-attention">'+text_wait_var+'<img src="catalog/view/theme/' + theme_var + '/image/aloading16.png" alt=""><button type="button" class="close" data-dismiss="alert">&times;</button></div>');

            urll = this.href + '#tab-review';
            location = urll;

            $('.attention').remove();

            return false;
        });

    } else {

        $('#tab-review .pagination a').live('click', function () {

            var acr = load_acr(this);

            var theme_var = acr['theme'];
            var text_wait_var = acr['text_wait'];

            $('#tab-review').prepend('<div class="attention alert alert-attention">'+text_wait_var+'<img src="catalog/view/theme/' + theme_var + '/image/aloading16.png" alt=""><button type="button" class="close" data-dismiss="alert">&times;</button></div>');

            urll = this.href + '#tab-review';
            location = urll;

            $('.attention').remove();


            return false;
        });

    }
    //*************** /$(document).on('click','#tab-review .pagination a') ********************

    //*************** $(document).on('click','#customer_enter') ********************
    if ($.isFunction($.fn.on)) {
        $(document).on('click', '#customer_enter', function () {

            $('#form_customer').show();

            return false;
        });

    } else {

        $('#customer_enter').live('click', function () {

            $('#form_customer').show();

            return false;
        });

    }
    //*************** /$(document).on('click','#customer_enter') ********************

    //*************** $(document).on('click','.comments_signer') ********************
    if ($.isFunction($.fn.on)) {
        $(document).on('click', '.comments_signer', function () {

            var acr = load_acr(this);

            var mark_var = acr['mark'];
            var mark_id_var = acr['mark_id'];
            var cmswidget = $(this).attr('data-cmswidget');

            $.ajax({
                type: 'POST',
                url: 'index.php?route=record/signer/subscribe&id=' + mark_id_var + '&pointer=' + mark_var + '&prefix=' + acr['prefix']+'&cmswidget='+cmswidget,
                dataType: 'html',
                data: $('#' + acr['prefix'] + 'form_signer').serialize() + '&subscribe=' + $('#customer_subscribe').serialize(),


                beforeSend: function () {
                    $('#' + acr['prefix'] + 'js_signer').html('');
                },
                error: function () {
                    $('.cmswidget .success, .cmswidget .warning, .cmswidget .attention, .cmswidget  .alert').remove();
                    alert('error');
                },
                success: function (data) {

                    $('#' + acr['prefix'] + 'js_signer').prepend(data).show();


                    if (sdata['code'] == 'error') {


                    }

                    if (sdata['code'] == 'success') {

                        if (sdata['success'] == 'remove') {
                            $('#' + acr['prefix'] + 'comments_signer').prop('checked', false);
                        }
                        if (sdata['success'] == 'set') {
                            $('#' + acr['prefix'] + 'comments_signer').prop('checked', true);
                        }
                    }

                }

            });

            return false;
        });

    } else {

        $('.comments_signer').live('click', function () {

            var acr = load_acr(this);

            var mark_var = acr['mark'];
            var mark_id_var = acr['mark_id'];

            $.ajax({
                type: 'POST',
                url: 'index.php?route=record/signer/subscribe&id=' + mark_id_var + '&pointer=' + mark_var,
                dataType: 'html',
                data: $('#' + acr['prefix'] + 'form_signer').serialize(),

                beforeSend: function () {
                    $('#' + acr['prefix'] + 'js_signer').html('');
                },
                error: function () {
                    $('.cmswidget .success, .cmswidget .warning, .cmswidget .attention, .cmswidget .alert').remove();
                    alert('error');
                },
                success: function (data) {
                    $('#' + acr['prefix'] + 'js_signer').prepend(data).show();

                    if (sdata['code'] == 'error') {

                    }

                    if (sdata['code'] == 'success') {

                        if (sdata['success'] == 'remove') {
                            $('#' + acr['prefix'] + 'comments_signer').prop('checked', false);
                        }
                        if (sdata['success'] == 'set') {
                            $('#' + acr['prefix'] + 'comments_signer').prop('checked', true);
                        }
                    }

                }

            });


            return false;
        });

    }
    //*************** /$(document).on('click','#comments_signer') ********************


   }
   //******* bingo *********//

});
//**************** /$(document).ready ********************************