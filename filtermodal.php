





<?php ob_start(); ?>
<div class="modal fade details" id="filtermodal" tabindex="-1" role="dialog" aria-labelledby="filtermodal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" onclick="CloseModal()" aria-label="close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title text-center" id="filtermodal">Filter Using Questions</h5>
        
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="filter.php" method="post" id="">
        <div>
      	<h3>What is your relationship with the recipient?</h3>
        <input type="radio" name="gender" value="male" checked>Mother<br>
                <input type="radio" name="gender" value="female">Father<br>
                <input type="radio" name="gender" value="other">Friend<br>
                <input type="radio" name="gender" value="other">Sister<br>
                <input type="radio" name="gender" value="other">Brother<br>
       </div>
       <div>
       <h3>What is the Occasion?</h3>
                <input type="radio" name="gender" value="female">Wedding<br>
                <input type="radio" name="gender" value="other">Birthday<br>
                <input type="radio" name="gender" value="other">Christmas<br>
                <input type="radio" name="gender" value="other">Anniversary<br>
       </div>
       <h3>What is the recipients gender?</h3>
                <input type="radio" name="gender" value="female">Female<br>
                <input type="radio" name="gender" value="other">Male<br>
       </div>
       <h3>What is the Age Group?</h3>
                <input type="radio" name="gender" value="female">0-9<br>
                <input type="radio" name="gender" value="other">10-15><br>
                <input type="radio" name="gender" value="other">16-20<br>
                <input type="radio" name="gender" value="other">21-30<br>
                <input type="radio" name="gender" value="other">31-50<br>

       </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back to Cart</button>
       <a href=""> <button type="button" class="btn btn-primary">Edit Details</button></a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function CloseModal() {
    jQuery('#filtermodal').modal('hide');
    setTimeout(function(){
      jQuery('#filtermodal').remove();
      jQuery('.modal-backdrop').remove();
    }, 500);
  }
</script>
<?php echo ob_get_clean(); ?>