$(document).ready(function(){

	$("#search_btn").click(function(){
		$("#get_product").html("<h3>Loading...</h3>");
		var keyword = $("#search").val();
		if(keyword != ""){
			$.ajax({
			url		:	"cart_man.php",
			method	:	"POST",
			data	:	{search:1,keyword:keyword},
			success	:	function(data){ 
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
		}
	})
	


	
	$("#login").on("submit",function(){
		
		$.ajax({
			url	:	"insertlogin.php",
			method:	"POST",
			data	:$("#login").serialize(),
			success	:function(data){
				if(data == "login_success"){
					window.location.href = "userprofile.php";
				}else if(data == "cart_login"){
					window.location.href = "cart.php";
				}else{
					$("#e_msg").html(data);
				}
			}
		})
	})

	$("#signup_form").on("submit",function(){
		$.ajax({
			url : "insertregister.php",
			method : "POST",
			data : $("#signup_form").serialize(),
			success : function(data){
				if (data == "register_success") {
					window.location.href = "cart.php";
				}else{
					$("#signup_msg").html(data);
				}
				
			}
		})
	})

	$("body").delegate("#product","click",function(event){
		var pid = $(this).attr("pid");
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "cart_man.php",
			method : "POST",
			data : {addToCart:1,proId:pid},
			success : function(data){
				count_item();
				getCartItem();
				$('#product_msg').html(data);
				$('.overlay').hide();
			}
		})
	})

	count_item();
	function count_item(){
		$.ajax({
			url : "cart_man.php",
			method : "POST",
			data : {count_item:1},
			success : function(data){
				$(".badge").html(data);
			}
		})
	}

	getCartItem();
	function getCartItem(){
		$.ajax({
			url : "cart_man.php",
			method : "POST",
			data : {Common:1,getCartItem:1},
			success : function(data){
				$("#cart_product").html(data);
			}
		})
	}

	
	
	$("body").delegate(".quantity","keyup",function(event){
		event.preventDefault();
		var row = $(this).parent().parent();
		var price = row.find('.price').val();
		var quantity = row.find('.quantity').val();
		if (isNaN(quantity)) {
			quantity = 1;
		};
		if (quantity < 1) {
			quantity = 1;
		};
		var total = price * quantity;
		row.find('.total').val(total);
		var net_total=0;
		$('.total').each(function(){
			net_total += ($(this).val()-0);
		})
		$('.net_total').html("Total : $ " +net_total);

	})
	
	$(document).delegate("a.remove","click",function(event){
		let remove_id = $( $(this).closest('.btn-group') ).data('product-id');		

		$.ajax({
			url	:	"cart_man.php",
			method	:	"POST",
			data	:	{removeItemFromCart:1,rid:remove_id},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})
	})
	$("body").delegate("a.update","click",function(event){
		var update = $(this).parent().parent().parent();
		var update_id = update.find("a.update").attr("update_id");
		var quantity = update.find("a.quantity").val();
		$.ajax({
			url	:	"cart_man.php",
			method	:	"POST",
			data	:	{updateCartItem:1,update_id:update_id,quantity:quantity},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})


	})
	checkOutDetails();
	net_total();
	
	function checkOutDetails(){
	 $('.overlay').show();
		$.ajax({
			url : "cart_man.php",
			method : "POST",
			data : {Common:1,checkOutDetails:1},
			success : function(data){
				$('.overlay').hide();
				$("#cart_checkout").html(data);
					net_total();
			}
		})
	}
	function net_total(){
		var net_total = 0;
		$('.quantity').each(function(){
			var row = $(this).parent().parent();
			var price  = row.find('.dollars').val();
			console.log(price);
			var total = price * $(this).val()-0;
			row.find('.dollar').val(total);
		})
		$('.dollar').each(function(){
			net_total += ($(this).val()-0);
		})
		$('.net_total').html("Total : $ " +net_total);
	}

	page();
	function page(){
		$.ajax({
			url	:	"cart_man.php",
			method	:	"POST",
			data	:	{page:1},
			success	:	function(data){
				$("#pageno").html(data);
			}
		})
	}
	$("body").delegate("#page","click",function(){
		var pn = $(this).attr("page");
		$.ajax({
			url	:	"cart_man.php",
			method	:	"POST",
			data	:	{getProduct:1,setPage:1,pageNumber:pn},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	})


	$('body').on("submit","form.add-product-form",function (event){ event.preventDefault();});


	$('body').on("click","form.add-product-form #add_to_cart",function (event){
		event.preventDefault();
		
		jQuery('#modal_errors').html("");
		var size=jQuery('#size').val();
		var available=jQuery('#available').val();
 		var error='';
		var data= $($(this).closest('form')).serializeArray();
		data.push({name: "add_to_cart",value: "true"});
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
				success: function(data){
					console.log(data);
					location.reload();
				},
				error: function(){alert("Something Went Wrong!")}
			})
		}
	});

	// Removes modal after close
	$('body').on("click",".modal#details-modal #close-modal",function(event){
		location.reload();
	});
});