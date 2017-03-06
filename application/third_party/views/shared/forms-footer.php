 </div>
     <?php
	 if(isset($footerScripts) && !is_null($footerScripts)){
		       foreach($footerScripts as $script)
			   {
				  echo "<script type=\"text/javascript\" src=\"" . $docRoot . $script . "\" ></script>\n";
			   }
			}
		?>
    <script type="text/javascript">
            $(document).ready(function () {                                             
                global.init();
                <?php
				     if (function_exists('initializers')) {
						initializers();
					 } 
				?>               
            });

    </script>


</body>
</html>
