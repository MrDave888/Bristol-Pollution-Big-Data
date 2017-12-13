<?php
	$reader = new XMLReader;
	$file = open('brislington.xml');
	
	$doc = new DOMDocument;
	
	while($file->read() && $file->name === 'desc');
	
?>