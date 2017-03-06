<?php
    
	require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
	require_once(ABSPATH . '/lib/php-export-data.class.php');
		
    $formView = new FormViewModel();
		
	if(!isNullOrEmpty($_GET["id"]) && is_numeric($_GET["id"])){
	   $id=$_GET["id"];
	   $formRepo  = new FormRepository;
       $form = $formRepo->getByPrimaryKey($id);
		   
	   if($form == null){	      
		  setErrorMessage("A valid form was not found.");
		  redirectToErrorPage();
	   }   
	   
	   $formView = FormViewModel::createFromObject($form);
	   $formView->Entries = $formRepo->GetRegistrantObjectsByForm($id);
	   $formView->loadGroupedEntries();
	   
	   $filename = $formView->Slug . '.xls';
	   $exporter = new ExportDataExcel('browser', $filename);
	   $exporter->initialize();
	    if(isset($formView->ColumnNames))
		{
			$colNames=array();	
			$columnCount=0;
			$cellCount=0;
			foreach ($formView->ColumnNames as $column => $name)
			{				
					$colName=$name;
					if(in_array($colName, $colNames)){
						
						$columnCount=1;
						do{
							$colName = $name . "(" . $columnCount . ")";
							$columnCount++;
							
						}while(in_array($colName, $colNames));
					}					
					array_push($colNames, $colName);
					$cellCount = $cellCount + 1;					                      								
			}
			array_push($colNames, "Submitted On");
			$exporter->addRow($colNames);
			
			foreach (array_values($formView->GroupedEntries) as $group)
			{
				$row = array();				
                $fieldAddedOn = array_values($group)[0]->DateAdded;
                foreach ($formView->ColumnNames as $column => $name)
                {
                   $field = null;

                   if (array_key_exists($column,$group))
                   {
                        $field = $group[$column];                                                            
						array_push($row,$field->format(true));
                   }else{
					   array_push($row, '');		
                   }
                }               
				array_push($row, $fieldAddedOn);
				$exporter->addRow($row);
			}				
		}
		
		$exporter->finalize();
		
	}else{
		setErrorMessage("Cannot find form for invalid Id");
		redirectToErrorPage();
	}
?>