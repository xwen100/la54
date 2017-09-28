$(function(){
	$('.showImage').click(function(){
		showMask();
		var img = $($(this).children('img').get(0)).clone();
		img.attr('width', 'auto');
		img.attr('height', $(document).height());
		$('#imageWrap').append(img);
		imageWidth = img.width() == 0 ? imageWidth : img.width();
		$('#imageWrap').css('margin-left', -Math.round(imageWidth / 2));
		$('#imageWrap').show();
	});
	$(document).on('click', '#imageWrap img', function(){
		$('#imageWrap img').remove();
		$('#imageWrap').hide();
		hideMask();
	});
});

//显示遮罩层    
function showMask(){     
    $("#mask").css("height",$(document).height());     
    $("#mask").css("width",$(document).width());     
    $("#mask").show();
} 

//隐藏遮罩层  
function hideMask(){     
      
    $("#mask").hide();     
}  
