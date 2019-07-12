</div>
<footer class="text-center" id="footer">
	&copy; CopyWrite 2018,Web Application Development Project by Rosanne & Thomas
</footer>

</div>

<script>
function updateSizes(){
	var sizeString = '';
	for(var i=1;i<=12;i++){
		if(jQuery('#size'+i).val() != ''){
			sizeString += jQuery('#size'+i).val()+':'+jQuery('#quantity'+i).val()+',';
			
		}
		
	}
	jQuery('#sizes').val(sizeString);
	
}
function get_child_options(selected){
	if(typeof selected === 'undefined'){
        var selected = '';
    }
	var parentID = jQuery('#parent').val();
	jQuery.ajax({
		url: '/GIFT-SHOP/admin/parsers/child_categories.php',
		type: 'POST',
		data: {parentID : parentID, selected: selected},
		success: function(data){
			jQuery('#child').html(data);
		},
		error: function(){alert("Something went wrong with the child options.")},
	});
}

//listener for parent option to change
jQuery('select[name="parent"]').change(function(){
    get_child_options();
});
</script>

</body>
</html>