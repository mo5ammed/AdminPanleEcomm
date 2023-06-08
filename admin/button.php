

        

        <?php   function buttons($descname, $names) {?>
              
              

            <div class='form-group form-group-lg'>
            <label class='col-sm-2 control-lable'><?php $descname ?></label>
            <div class="col-sm-10 col-md-6">
            <input type='text' name="<?php $names ?>"class='form-control' required='required' placeholder='Name Of The Item'/>
            </div> 

        <?php  return $names; }?>