<?php
			    
			    
			    
			    header('Content-disposition: attachment; filename="'.basename($_GET['zip_file']).'"');
                header('Content-type: application/zip');
			    /*header('Content-type: application/zip');
				header('Content-Disposition: attachment; filename="'.basename($_GET['zip_file']).'"');
				header("Content-length: " . filesize($_GET['zip_file']));
				header("Pragma: no-cache");
				header("Expires: 0");
				ob_clean();
				flush();*/
				readfile($_GET['zip_file']);
			
?>