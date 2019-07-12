</div>
<footer class="text-center" id="footer" style="margin-top: 650px;">
	&copy; CopyWrite 2018,Web Application Development Project by Rosanne and Thomas
</footer>
<script>
	function modal(Id) {
		var data ={"Id":Id};

		jQuery.ajax({
			url:'/GIFT-SHOP/Include/modal.php',
			method: "post",
			data: data,
			success: function(data){
				jQuery('body').append(data);
				jQuery('#details-modal').modal('toggle');
			},
			error:function(){
				alert("Something went Wrong!");
			}
		});
	}

	
	function add_to_cart(){
		console.log('Hello');

		return;
		
		jQuery('#modal_errors').html("");
		var size=jQuery('#size').val();
		var available=jQuery('#available').val();
 		var error='';
		var data= jQuery('#add_product_form').serialize();
		if (size=='' || quantity==''|| quantity==0) {
			error+='<p class="text-danger text-center">You must chose a size and quanitiy</p>';
			jQuery('#modal_errors').html(error);
			return;
		}
		 // else if(quantity > available){
			// error +='<p class="text-danger text-center">There are only'+available+' available</p>';
			// jQuery('#modal_errors').html(error);
			// return;
		 // }
		else{
			jQuery.ajax({
				url:'/GIFT-SHOP/cart_man.php',
				method:'post',
				data: data,
				success: function(){
					 location.reload();
				},
				error: function(){alert("Something Went Wrong!")}
			})
		}
	}

 
  


	
</script>
</div>
</body>
</html>