<!-- Right side bar -->

    <div class="col-md-2">
    	





<?php ob_start();
$mysqli = new mysqli("localhost", "102600", "choco95*", "Giftit");



 ?>
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
        <form action="filteredgifts.php" method="post" id="">
        <div id="result">
      	<h3>What is your relationship with the recipient?</h3>

              <?php 
                  $sql2="SELECT * FROM tag_type_value WHERE tag_type_id = 1";
                  $value=$mysqli->query($sql2)or die("Error " . mysqli_error($mysqli));
                  while ($row = mysqli_fetch_array($value)) {
                    # code...
                     echo '<input id="filters" type="radio" name="relationship" value="'.$row[0].'"><label for="relationship1">'.$row[2].'</label><br>';
                  }
                  
                 
                  
                 ?>
              
       </div>
       <div>
       <h3>What is the Occasion?</h3>
            <?php 
                  $sql2="SELECT * FROM tag_type_value WHERE tag_type_id = 2";
                  $value=$mysqli->query($sql2)or die("Error " . mysqli_error($mysqli));
                  while ($row = mysqli_fetch_array($value)) {
                    # code...
                     echo '<input id="filters" type="radio" name="occassion" value="'.$row[0].'"><label for="relationship1">'.$row[2].'</label><br>';
                  }
                 ?>
     
       </div>

       <div>
       <h3>What is the recipients gender?</h3>
       <?php 
                  $sql2="SELECT * FROM tag_type_value WHERE tag_type_id = 4";
                  $value=$mysqli->query($sql2)or die("Error " . mysqli_error($mysqli));
                  while ($row = mysqli_fetch_array($value)) {
                    # code...
                     echo '<input id="filters" type="radio" name="gender" value="'.$row[0].'"><label for="relationshSip1">'.$row[2].'</label><br>';
                  }
                  
                 
                  
                 ?>
               
       </div>
       <div>
       <h3>What is the Age Group?</h3>
       <?php 
                  $sql2="SELECT * FROM tag_type_value WHERE tag_type_id = 3";
                  $value=$mysqli->query($sql2)or die("Error " . mysqli_error($mysqli));
                  while ($row = mysqli_fetch_array($value)) {
                    # code...
                     echo '<input id="filters" type="radio" name="age" value="'.$row[0].'"><label for="relationship1">'.$row[2].'</label><br>';
                  }
                  
                 
                  
                 ?>

       </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back </button>
         <button id="btn" type="submit" name="filter" class="btn btn-primary">Find Gift</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>




<?php echo ob_get_clean();
if($_POST){
        $errors = array();
        
            $required = array('relationship', 'occassion', 'gender','age');
        foreach($required as $field){
            if($_POST[$field] == ''){
                    $errors[] = 'Answer all questions';
                    break;
            }
        } 
    } 

 ?>
    	<button class="btn btn-sm btn-success" style=" padding:15px;" data-toggle="modal" data-target="#filtermodal">Filter Gifts</button>
    </div>