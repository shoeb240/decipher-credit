<ul class="vertical-list">
    <li class="header static-assets/sidebar-header-full.png">
        <h3 class="sponsors">
            Field Properties</h3>
			<a href="javascript:void(0);" class="image-icon-link the-pin-icon pinned-icon-link" title="Unpin property editor"></a>
    </li>
    <li>
        <table id="field-property-table" class="field-property-table " cellpadding="0" cellspacing="0">

         <!-- Header -->
            <tr class="header">
                <td class="label">
                    <label class="label">
                        Text</label>
                </td>
                <td class="input">
                    <input type="text" data-field-property="text" class="is-publisher" value="Click to edit" />
                </td>
            </tr>

            <!-- field label -->
            <tr class="textbox textarea dropdownlist radiobutton checkbox fullname email address phone birthdaypicker filepicker captcha datepicker">
                <td class="label">
                    <label class="label">
                        Label</label>
                </td>
                <td class="input">
                    <input type="text" data-field-property="label" class="is-publisher" value="Click to edit" />
                </td>
            </tr>
            <!-- max characters -->
            <tr class="textbox textarea email">
                <td class="label">
                    <label class="label">
                        Max Characters</label>
                </td>
               <td class="input">
                    <input type="text"  data-field-property="maxcharacters" class="numeric-entry is-publisher"/>
                </td>
            </tr>
            <!-- is required -->
            <tr class="textbox textarea dropdownlist radiobutton checkbox fullname email address phone birthdaypicker filepicker datepicker">
                <td class="label">
                    <label class="label">
                        Required</label>
                </td>
                <td class="input">
                    <select id="prop-isrequired" data-field-property="isrequired" class="is-publisher">
                        <option value="false" selected="selected">False</option>
                        <option value="true">True</option>                        
                    </select>
                </td>
            </tr>          
            <!--//end is required -->
            
			<!-- Options Alignment-->
            <tr class="radiobutton checkbox">
                <td class="label">
                    <label class="label">Alignment</label>
                </td>
                <td class="input">
                    <select data-field-property="optionsalignment" class="is-publisher">
                        <option value="vertical" selected="selected">Vertical</option>                        
						<option value="horizontal">Horizontal</option>                        						                   
                    </select>
                </td>
            </tr>          
            <!--//end Options Alignment -->
			
			
			
            <!-- option -->
            <tr class="dropdownlist radiobutton checkbox" data-show-if="dictionary:Null">
                <td class="label">
                    <label class="label">
                       Options</label>
            </td>
               <td class="input">
                    <input id="prop-options" type="text" value="option 1,option 2,option 3" title="Enter options seperated by commas"  data-field-property="options" class="is-publisher"/>
                </td>
            </tr>
            <!--//end options -->

            <!-- selected option -->
              <tr class="dropdownlist radiobutton">
                <td class="label">
                    <label class="label">
                       Selected Option</label>
            </td>
               <td class="input">
                    <input type="text" value=""  data-field-property="selectedoption" class="is-publisher"/>
                </td>
            </tr>
            <!--// end selected option -->
			
			<!-- Multiselect-->
            <tr class="dropdownlist">
                <td class="label">
                    <label class="label">Multiselect</label>
                </td>
                <td class="input">
                    <select data-field-property="multiselect" class="is-publisher">
                        <option value="False" selected="selected">False</option>   
						<option value="True">True</option>                        						                     						
                    </select>
                </td>
            </tr>          
            <!--//end Multiselect -->			
			
			  <!-- dictionary -->
              <tr class="dropdownlist listbox">
                <td class="label">
                    <label class="label">
                       Dictionary</label>
            </td>
               <td class="input">
                    <select id="dictionary" data-field-property="dictionary" class="is-publisher">
						<option value="Null">Select a dictionary</option>
						<?php
							if (isset($data_dictionaries)){								
								foreach($data_dictionaries as $key=>$value){
									echo "<option value='".$key."'>" . $key . "</option>";
								}
							}
						?>
                    </select>			
                </td>
            </tr>
            <!--// end dictionary -->

			<!-- Mode-->
            <tr class="textbox">
                <td class="label">
                    <label class="label">Mode</label>
                </td>
                <td class="input">
                    <select id="textmode" data-field-property="textmode" class="is-publisher">
                        <option value="Text" selected="selected">Text</option>                        
						<option value="Password">Password</option>                        						
						<option value="Number">Number</option>  
                    </select>
                </td>
            </tr>          
            <!--//end Mode-->
			
			<!--Minimum-->
            <tr class="textbox"  data-show-if="textmode:Number">
                <td class="label">
                    <label class="label">Min. Number</label>
                </td>
                <td class="input">
                    <input type="text" value="0" title="Enter minimum number" data-field-property="minnumber" class="is-publisher numeric-entry"/>
                </td>
            </tr>          
            <!--//end Minimum-->
			
			<!--Maximum-->
            <tr class="textbox"  data-show-if="textmode:Number">
                <td class="label">
                    <label class="label">Max. Number</label>
                </td>
                <td class="input">
                    <input type="text" value="100" title="Enter maximum number"  data-field-property="maxnumber" class="is-publisher numeric-entry"/>
                </td>
            </tr>          
            <!--//end Maximum-->			
            
			<!-- input masks -->
              <tr id="prop-tr-inputmask" class="textbox" data-show-if="textmode:Text">
                <td class="label">
                    <label class="label">
                       Input Mask</label>
				</td>
                <td class="input">
                    <select id="prop-inputmask" data-field-property="inputmask" class="is-publisher">
						<option value="">Select an Input Mask</option>
						<?php
							if (isset($input_masks)){								
								foreach($input_masks as $key=>$value){
									echo "<option value='".$key."'>" . $key . "</option>";
								}
							}
						?>
                    </select>			
                </td>
            </tr>
            <!--// input masks -->
            
            <!-- Watermark -->
            <tr class="textbox textarea email">
                <td class="label">
                    <label class="label">
                        Hint</label>
                </td>
                <td class="input">
                    <input type="text"  data-field-property="hint" class="is-publisher"/>
                </td>
            </tr>
            <!--//watermark-->

            <!--min. age -->
             <tr class="birthdaypicker">
                <td class="label">
                    <label class="label">
                        Minimum Age</label>
                </td>
                <td class="input">
                    <select name="minAge" id="minAge" data-field-property="minimumage" class="is-publisher" data-sub-channel="sub-minimumage-4">
					   <?php 
					     for($x=100; $x >= 1; $x--){
						    echo strFormat("<option value='{0}' {1}>{2}</option>", $x, outputIfTrue($x==18, "selected='selected'"), $x);
						 }
					   ?>
					</select>
                </td>
            </tr>      
            <!-- end min. age -->
             <tr class="birthdaypicker">
                <td class="label">
                    <label class="label">
                        Maximum Age</label>
                </td>
                <td class="input">
                   <select name="maxAge" id="maxAge" data-field-property="maximumage" class="is-publisher" data-sub-channel="sub-maximumage-4">				   
				    <?php 
					     for($x=1; $x <= 100; $x++){
						    echo strFormat("<option value='{0}' {1}>{2}</option>", $x, outputIfTrue($x==100, "selected='selected'"), $x);
						 }
					   ?>
					</select>
                </td>
            </tr>      

            <!--valid extensions -->
            <tr class="filepicker">
                <td class="label">
                    <label class="label">
                        Valid Extensions</label>
                </td>
               <td class="input">
                    <input type="text" value="<?php echo Settings::DEFAULT_FILE_EXTENSIONS; ?>"  data-field-property="validextensions" class="is-publisher"/>
              </td>
            </tr> 
            <!-- end valid extensions-->

            <!--Max filesize-->
            <tr class="filepicker">
                <td class="label">
                    <label class="label">
                        Max. File size (kb)</label>
                </td>
               <td class="input">
                    <input type="text" value="<?php echo Settings::DEFAULT_MAX_FILE_SIZE_IN_KB; ?>"  data-field-property="maxfilesize" class="numeric-entry is-publisher"/>
              </td>
            </tr> 
            <!--// end max filesize-->

            <!--Min. filesize-->
            <tr class="filepicker">
                <td class="label">
                    <label class="label">
                        Min. File size (kb)</label>
                </td>
               <td class="input">
                    <input type="text" value="<?php echo Settings::DEFAULT_MIN_FILE_SIZE_IN_KB; ?>"  data-field-property="minfilesize" class="numeric-entry is-publisher"/>
              </td>
            </tr> 
            <!--// end min. filesize-->
			<!--Show time-->
			<tr class="datepicker">
                <td class="label">
                    <label class="label">
                        Show Time</label>
                </td>
                <td class="input">
                    <select id="showtime" data-field-property="showtime" class="is-publisher">
                        <option value="False" selected="selected">False</option>
                        <option value="True">True</option>                        
                    </select>
                </td>
            </tr>
			<!--// end Show time-->
			
			<!--Time Format-->
			<tr class="datepicker hide" data-show-if="showtime:True">
                <td class="label">
                    <label class="label">
                        Time Format</label>
                </td>
                <td class="input">
                    <select data-field-property="timeformat" class="is-publisher">					    
                        <option value="24">24 hr</option>
                        <option value="AMPM" selected="selected">AM/PM</option>                        
                    </select>
                </td>
            </tr>
			<!--// end time format-->
			
			
			<!--to/from mode-->
			<tr class="datepicker">
                <td class="label">
                    <label class="label">
                        Enable To/From</label>
                </td>
                <td class="input">
                    <select data-field-property="istofromdate" class="is-publisher">
                        <option value="False" selected="selected">False</option>
                        <option value="True">True</option>                        
                    </select>
                </td>
            </tr>
			<!--//to/from mode-->
			
			<!--Language-->
			<tr class="datepicker">
                <td class="label">
                    <label class="label">
                        Language</label>
                </td>
                <td class="input">
                    <select data-field-property="language" class="is-publisher">
						<?php
							if (isset($data_dictionaries) && array_key_exists("Languages", $data_dictionaries)){
								echo getSelectListOptions($data_dictionaries["Languages"]->Items, "Select a language"); 
							}
						?>
                    </select>										
                </td>
            </tr>
			<!--//language-->
			
			<!-- Css Class-->
            <tr class="all-fields">
                <td class="label">
                    <label class="label">
                        CSS Class</label>
                </td>
                <td class="input">
                    <input type="text"  data-field-property="css" class="is-publisher"/>
                </td>
            </tr>
            <!--//end css class-->
			
			
			<!-- Previous text -->
            <tr class="formbreak">
                <td class="label">
                    <label class="label">
                        Previous Text</label>
                </td>
               <td class="input">
                    <input type="text" maxlength="15"  data-field-property="previoustext" class="is-publisher"/>
				</td>
			</tr>
			<!--// end Previous text -->
			
			<!-- Next text -->
            <tr class="formbreak">
                <td class="label">
                    <label class="label">
                        Next Text</label>
                </td>
               <td class="input">
                    <input type="text" maxlength="15"  data-field-property="nexttext" class="is-publisher"/>
				</td>
			</tr>
			<!--// end Next text -->
			
            <!-- is previous visible-->
            <tr class="formbreak">
                <td class="label">
                    <label class="label">
                        Show Previous</label>
                </td>
                <td class="input">
                    <select data-field-property="showprevious" class="is-publisher">
                        <option value="True" selected="selected">True</option>                        
						<option value="False">False</option>                        
                    </select>
                </td>
            </tr>          
            <!--//end is previous visible -->


            <!-- is next visible-->
            <tr class="formbreak">
                <td class="label">
                    <label class="label">Show Next</label>
                </td>
                <td class="input">
                    <select data-field-property="shownext" class="is-publisher">
                        <option value="True" selected="selected">True</option>                        
						<option value="False">False</option>                        
                    </select>
                </td>
            </tr>          
            <!--//end is next visible -->			
			
			<!-- Alignment-->
            <tr class="image paragraph">
                <td class="label">
                    <label class="label">Alignment</label>
                </td>
                <td class="input">
                    <select data-field-property="alignment" class="is-publisher">
                        <option value="Left" selected="selected">Left</option>                        
						<option value="Right">Right</option>                        
						<option value="Center">Center</option>                        
                    </select>
                </td>
            </tr>          
            <!--//end Alignment -->

			
			 <!-- Alt Text -->
            <tr class="image">
                <td class="label">
                    <label class="label">
                        Alt Text</label>
                </td>
                <td class="input">
                    <input type="text"  data-field-property="alttext" class="is-publisher"/>
                </td>
            </tr>
            <!--//Alt Text-->
			
			 <!-- Url-->
            <tr class="image">
                <td class="label">
                    <label class="label">
                        Url</label>
                </td>
                <td class="input">
                    <input type="text"  data-field-property="url" class="is-publisher"/>
                </td>
            </tr>
            <!--//Url-->
			
			<!-- Help text -->
            <tr class="textbox textarea dropdownlist radiobutton checkbox fullname email address phone birthdaypicker filepicker datepicker">
                <td class="label">
                    <label class="label">
                        Help Text</label>
                </td>
               <td class="input">
                    <input type="text"  data-field-property="helptext" class="is-publisher"/>
				</td>
			</tr>
			<!--// end Help text -->
			
    </table> 
    </li>
</ul>
