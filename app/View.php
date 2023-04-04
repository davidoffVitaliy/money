<?php
/* *
*
*
 */
function render(string $path, $content)
	{
		ob_start();
		extract($content);
		include_once 'resources/views/' . $path . '.php';
		return ob_get_clean();
	    
	}

	