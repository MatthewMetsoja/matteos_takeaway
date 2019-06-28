<h5 class="text-center">Edit item</h5>

<div class="menu_form"> 
<form method="post" action="">

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u> Name</u> </b> </label>
    <div class="col-sm-12">
    <div class="alert-danger form-inline">  <?= $msg['name']; ?>  </div>
        <input type="text" value=" <?= isset($name) ? trim($name) :  $this->old_name ; ?> "   class="form-control" name="name" placeholder="Enter item name">
    </div>
</div>
 
<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u>  Category  </u> </b> </label>
  
</div>
    <div class="col-sm-6"> 
    <div class="alert-danger">  <?= $msg['category']; ?> </div>
    <select class="form-control" name="category">
        <?php $this->show_categories_select(); ?>
    </select>    
</div>
<br>

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u>Price</u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger" id="price_error_div"> <?= $msg['price']; ?> </div>
        <input type="number" min=0 step="0.01" value="<?= isset($price) ? $price:  $this->old_price ;?>" class="form-control" name="price" id="inputName" placeholder="Enter item price. (Don't forget decimal point) 0.00">
    </div>
</div>
<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u> Description </u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['description'] ?></div>
        <textarea class="form-control" cols="30" rows="10" name="description" id="inputName" placeholder="Enter item description"><?= isset($description) ? $description : $this->old_description; ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u> Vegetarian </u> </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['vegetarian'] ?></div>
    No  <input type="radio" 
    <?php if(isset($this->old_vegatarian) && $this->old_vegatarian == "0" ) {echo "checked";}
          elseif(isset($vegetarian) && $vegetarian == "0"){echo "checked";} ?>  value="0" name="vegetarian" id="inputName">  &nbsp; &nbsp; 
    Yes <input type="radio" 
     <?php  if(isset($this->old_vegatarian) && $this->old_vegatarian == "1" ) {echo "checked";}
          elseif(isset($vegetarian) && $vegetarian == "1"){echo "checked";} ?>  value="1" name="vegetarian" id="inputName">
  
    </div>
</div>
<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u> Nut traces </u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['nut_traces'] ?></div>
    No <input type="radio"
     <?php  if(isset($this->old_nut_traces) && $this->old_nut_traces == "0" ) {echo "checked";} 
            elseif(isset($nut_traces) && $nut_traces == "0"){echo "checked";} ?> value="0" name="nut_traces" id="inputName">    &nbsp; &nbsp; 
    Yes <input type="radio" 
    <?php  if(isset($this->old_nut_traces) && $this->old_nut_traces == "1" ) {echo "checked";} 
         elseif(isset($nut_traces) && $nut_traces == "1"){echo "checked";} ?> value="1" name="nut_traces" id="inputName">
    </div>
</div>

 <button type="submit" name="submit" class="btn btn-block btn-dark">Update item</button>

</form>

</div>