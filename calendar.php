<?php
	
	// Set the ical url of the calendar feed by changing webcal to https.
	//$url = 'https://p01-calendarws.icloud.com/ca/subscribe/1/n6x7Farxpt7m9S8bHg1TGArSj7J6kanm_2KEoJPL5YIAk3y70FpRo4GyWwO-6QfHSY5mXtHcRGVxYZUf7U3HPDOTG5x0qYnno1Zr_VuKH2M';
	//$url = 'https://p19-calendars.icloud.com/published/2/44ROgzhahcsqZpKXUZVOKPg2EXIMFnbml5q790athQk0wmzn2QYwlcENvin0AgWjdS6RpcSBPbdg-StC47OQkJC01csEMJ0m7VVeteEDyhU';
	//$url = 'https://www.google.com/calendar/ical/mtps.us_6k3adsjlsnanqkgk714ik9253g%40group.calendar.google.com/public/basic.ics';
	//$url = 'https://ical.mac.com/ical/US32Holidays.ics'
	$url = 'https://p19-calendars.icloud.com/published/2/DxDgXCA8PyiQO8FUrpyO33igHSNtm6xEkcesTRvpPSi30EIN_I2tPwj49DTdWz3P5ZZkvqy9lUyffIYaiK4idTRoAscGcP9R0Ii_vdEtwD0';
	
	/*****************************************/

	// Run the helper function with the desired URL and echo the contents.
	echo get_url($url);

	// Define the helper function that retrieved the data and decodes the content.
	function get_url($url)
	{
	    //user agent is very necessary, otherwise some websites like google.com wont give zipped content
	    $opts = array(
	        'http'=>array(
	            'method'=>"GET",
	            'header'=>"Accept-Language: en-US,en;q=0.8rn" .
	                        "Accept-Encoding: gzip,deflate,sdchrn" .
	                        "Accept-Charset:UTF-8,*;q=0.5rn" .
	                        "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:19.0) Gecko/20100101 Firefox/19.0 FirePHP/0.4rn",
				"ignore_errors" => true	 //Fix problems getting data
	        ),
	        //Fixes problems in ssl 
		"ssl" => array(
			"verify_peer"=>false,
			"verify_peer_name"=>false
		)
	    );
	 
	    $context = stream_context_create($opts);
	    $content = file_get_contents($url ,false,$context); 
	     
	    //If http response header mentions that content is gzipped, then uncompress it
	    foreach($http_response_header as $c => $h)
	    {
	        if(stristr($h, 'content-encoding') and stristr($h, 'gzip'))
	        {
	            //Now lets uncompress the compressed data
	            $content = gzinflate( substr($content,10,-8) );
	        }
	    }
	     
	    return $content;
	}
