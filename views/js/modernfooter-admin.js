/**
* @author  	   DevSoft Presta-Modules.net
* @copyright      Copyright DevSoft 2010-2012. All rights reserved.
* @license 	   GPLv3 License http://www.gnu.org/licenses/gpl-3.0.html
* @version 	   1.0
*
*/

function tinySetup(){}
$(document).ready(function(){
	$.ajaxSetup({
		error:function(x,e){
			if(x.status==0){
			alert('You are offline!!\n Please Check Your Network.');
			}else if(x.status==404){
			alert('Requested URL not found.');
			}else if(x.status==500){
			alert('Internel Server Error.');$('#ds-footer').prepend(x.responseText);
			}else if(e=='parsererror'){
			alert('Error.\nParsing JSON Request failed. \n'+x.responseText);
			}else if(e=='timeout'){
			alert('Request Time out.');
			}else {
			alert('Unknow Error.\n'+x.responseText);
			}
		}
	});

	function addAdminButtons(){
		$('.ds-link_box ul').each(function(i){
			$(this).append('<a href="#" id="' + (i + 1) + '" class="ds-add-link"></a>');
		});
		$('.ds-link_box li').each(function(i){
			$(this).append('<span class="ds-delete-link"></span>');
		});
		$('#ds-payment div').each(function() {
			$(this).append('<span style="display:none;" class="enable-icon"></span>');
		});
	}

	addAdminButtons();

	$('#getColors').live("click", function() {
		var content = $('#ds-colors');
		$.fancybox({
			content: content,
			'beforeClose'		: function() {
				$("#ds-colors").append(content);
			}
		});
		return false;
	});

	$('#submitColors_1').live('click', function(){
		$.fancybox.showLoading();
		var  data = $('.colorsForm form').serializeArray();

		//sent
		$.post( urlJson + '&action=savecolors', data, function(response) {
			$('#ds-load').replaceWith(response);
			addAdminButtons();
			$.fancybox.close();
			$.fancybox.hideLoading();
		});
		return false;
	});

	$('#ds-payment div').live({
	        mouseenter:
	           function()
	           {
	 			$(this).find('.enable-icon').css("display", "block");
	           },
	        mouseleave:
	           function()
	           {
				$(this).find('.enable-icon').css("display", "none");
	           }
	 });

	$('#ds-links li').live({
	        mouseenter:
	           function()
	           {
	 			$(this).find('.ds-delete-link').css("display", "block");
	           },
	        mouseleave:
	           function()
	           {
				$(this).find('.ds-delete-link').css("display", "none");
	           }
	 });

	$('.ds-add-link').live('click', function(e){
		$('#newlink #id_block').val( $(this).attr('id') );
		var content = $('#ds-add-link-wrap').html();
		$('form#newlink').remove();

		$.fancybox({
			    content: content,
			    'beforeClose'		: function() {
				    $("#ds-add-link-wrap").append(content);
			    }
		});
        return false;
	});

	$('.enable-icon').live('click', function(){
		$.fancybox.showLoading();
		var src =  $(this).parent().find('img').attr('src');
		var fileNameIndex = src.lastIndexOf("/") + 1;
		var filename = src.substr(fileNameIndex);
		var fileNameIndexSecond = filename.indexOf("?");
		if(fileNameIndexSecond > -1 ){
			filename = filename.substr(0,fileNameIndexSecond );
		}
		var enable = $(this);
		$.post( urlJson + '&action=enableicon', {filename: filename}, function(response) {
			if(response == '"disable"'){
			    d = new Date();
				enable.parent().css("opacity", "0.5");
				var newsrc = "../modules/modernfooter/views/img/user/" + current_shop + "/payment/disable-" + filename + '?' + d.getTime();
				enable.parent().find('img').attr('src', newsrc);
			}  else {
				d = new Date();
				var newsrc = "../modules/modernfooter/views/img/user/" + current_shop + "/payment/" + filename.replace('disable-', '') + '?' + d.getTime();
				enable.parent().find('img').attr('src', newsrc);
				enable.parent().css("opacity", "1");
			}
			$.fancybox.hideLoading();
		});
		return false;
	 });

	/*
	* edit form for textarea
	*/
	var elements = '#ds-info p, #ds-info span, #ds-about p, #ds-copyrights p, #ds-links h3, #ds-adress_box p, #ds-links_right a';
	elements +=',.ds-info_image img, #ds-payment img, #ds-basket img, .ds-link_box img, .ds-subscribe-info';

	$( elements ).live({
	        mouseenter:
	           function()
	           {
	 			$(this).css("opacity", "0.5");
				$(this).css('cursor', 'hand');
				$(this).css('cursor', 'pointer');
	           },
	        mouseleave:
	           function()
	           {
				$(this).css("opacity", "1");
	           }
	 });

	/*
	* edit form for textarea
	*/
	$('#ds-info p, #ds-about p, #ds-copyrights p, #ds-payment h3').live('click', function(){
	       $.fancybox.showLoading();
		 var fieldname = $(this).attr('id');
		 fieldname = fieldname.replace('ds-f-','');
		 //sent
           	$.post( urlJson + '&action=gettextarea', {fieldname: fieldname}, function(response) {
          		$.fancybox({
					content: response
				});
				$.fancybox.hideLoading();
           	});
          	return false;
	 });

	/*
	* edit form for input
	*/
	$('#ds-info span, #ds-links h3, #ds-adress_box p, .ds-subscribe-info').live('click', function(){
		$.fancybox.showLoading();
		 var fieldname = $(this).attr('id');
		fieldname = fieldname.replace('ds-f-','');
		//sent
		$.post( urlJson + '&action=getinput', {fieldname: fieldname}, function(response) {
			$.fancybox({
				content: response
			});
			$.fancybox.hideLoading();
		});
		return false;
	 });

	/*
	* edit form for links
	*/
	$('#ds-links_right li a').live('click', function(e){
	       $.fancybox.showLoading();
	        e.preventDefault();
		 var id_link = $(this).attr('id');
			id_link = id_link.replace('ds-f-link-','');
		 //sent
           	$.post( urlJson + '&action=getlink', {id_link: id_link}, function(response) {
          		$.fancybox({
					content: response
				});
				$.fancybox.hideLoading();
           	});
          	return false;
	 });

	$('.ds-delete-link').live("click",function(e) {
	       $.fancybox.showLoading();
	       e.preventDefault();
		 var id_link = $(this).parent().find('a').attr('id');
			id_link = id_link.replace('ds-f-link-','');
		 //sent
           	$.post( urlJson + '&action=deletelink', {id_link: id_link}, function(response) {
				$('#ds-load').replaceWith(response);
				addAdminButtons();
				$.fancybox.hideLoading();
           	});
          	return false;
	});

	//submit form for textarea
	$('#submitfield').live('click', function(){
	        $.fancybox.showLoading();
		 var  data = $('#formtextarea').serializeArray();
		 //sent
		$.post( urlJson + '&action=savefield', data, function(response) {
			$('#ds-load').replaceWith(response);
			addAdminButtons();
			$.fancybox.close();
			$.fancybox.hideLoading();
		});
		return false;
	 });

	/*
	* submit new link form for links
	*/
	$('#submitnewlink').live('click', function(){
		 $.fancybox.showLoading();
		 var  newform = $('form#newlink').serializeArray();
		 //sent
           	$.post( urlJson + '&action=savelink', newform, function(response) {
		       $('#ds-load').replaceWith(response);
				addAdminButtons();
          		$.fancybox.close();
			$.fancybox.hideLoading();
           	});
          	return false;
	 });

	//submit form for links
	$('#submitlink').live('click', function(){
	       $.fancybox.showLoading();
		 var  data = $('#formtextarea').serializeArray();
		 //sent
           	$.post( urlJson + '&action=savelink', data, function(response) {
		       $('#ds-load').replaceWith(response);
				addAdminButtons();
          		$.fancybox.close();
			$.fancybox.hideLoading();
           	});
          	return false;
	 });

	//change styles
	$('#styles a').live('click', function(){
		$.fancybox.showLoading();
		var  id = $(this).attr('rel');
		//sent
		$.post( urlJson + '&action=changestyle', {id: id}, function(response) {
			$('#ds-load').replaceWith(response);
			addAdminButtons();
			$.fancybox.close();
			$.fancybox.hideLoading();
		});
		return false;
	});

	//upload images on image click
	$('.ds-info_image img, #ds-payment img, #ds-basket img, .ds-link_box img').live('click', function(){
	       $('input[name="uploadfile"]').remove();
	       var src =  $(this).attr('src');
		var fileNameIndex = src.lastIndexOf("/") + 1;
		var filename = src.substr(fileNameIndex);
		var fileNameIndexSecond = filename.indexOf("?");
		if(fileNameIndexSecond > -1 ){
			filename = filename.substr(0,fileNameIndexSecond );
		}
		var type = '';
		if (src.indexOf("/payment/") >= 0){ type = 'payment'; }
		var btnUpload=$("#upload");
		var status=$("#status");
			new AjaxUpload(btnUpload, {
				action: urlJson,
				name: "uploadfile",
				autoSubmit: true,
				data: {"action": "upload", "file_name": filename, "id_shop":current_shop, "type":type},
				onSubmit: function(file, ext){
					 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
	                            // extension is not allowed
						status.text("Only JPG, PNG or GIF files are allowed");
						return false;
					}
					status.text("Uploading...");
				},
				onComplete: function(file, response){
					status.text("");
					if(response==="error"){
						alert("error upload file.");
					}
					d = new Date();
					$("#ds-load img").each(function(){
						var src = $(this).attr('src');
						if(src.indexOf('?') > -1)
							src = src.substring(0, src.indexOf('?'));
						$(this).attr("src", src+'?'+d.getTime());
					});
				}
			});

		$('input[name="uploadfile"]').click();
          	return false;
	 });
});
