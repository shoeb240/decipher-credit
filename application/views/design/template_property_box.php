
    <div class="row">
        <div class="col-md-12 pull-left">
            
            <div class="row">
	 
        	<div class="col-md-4">
                    <div class="form-group">    
                        <input type="text"  name="description" id="description" class="form-control" placeholder="Template Name" required />       
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"> 
<!--                        <input type="text"  name="status" id="status" class="form-control" placeholder="Status" />	-->
                        <select name="status" id="status" class="form-control" placeholder="Status">
                            <option value="1" selected="selected">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"> 
<!--                        <input type="text"  name="status" id="status" class="form-control" placeholder="Status" />	-->
                        <select name="product" id="product" class="form-control" style="width: 220px;">
                            <option value="">--Select Product--</option>
                            <?php
                            foreach($products as $product) {
                                echo '<option value="'.$product->uuid.'">'.$product->description.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group"> 
                        Total Section Weight: 
<!--                        <input type="text" value="0" id="total_sec_wgt" readonly>-->
                        <span id="total_sec_wgt">0</span>
                        <input type="hidden" id="secid_list" name ="secid_list" />
                        <input type="hidden" id="orig_secid_list" name ="orig_secid_list" />
                        <input type="hidden" id="sec_wgt_list" name ="sec_wgt_list" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">    
                        <input type="button" class="btn btn-info" onclick="javascript: insert_question_block();"  name="ques_block" id="ques_block" class="form-control" value="Insert New Section"  />       
                    </div>
                </div>
            </div>
            
        </div>
    </div>

