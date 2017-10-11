$(function(){
	$('input[name=num]').keyup(function(){
		var val = $(this).val();
		if(val.match(/^\d+$/) !== null)
		{
			var id = $(this).attr('id');
			$.ajax({
				url: '/shop/cart/'+id,
				method: 'post',
				 headers: {
       	 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					num: val
				},
				dataType: 'json',
				success: function(response)
				{
					console.log(response);
				}
			});
		}
	});
	$('#addA').click(function(){
		$('#addrF').toggle();
	});
});