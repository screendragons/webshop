<?php

	require 'validation.php';

  	$errors = [];

  		$checkToFunction = [
  			'required',
  			'name',
  			'min',
  			'max',
  			'email',
  			'confirm',	
  		];


            $variables = [
                'first_name' => ['required', 'name', 'min:2', 'max:25'],
                'suffix_name' => ['name', 'min:2', 'max:15'],
                'last_name' => ['required', 'name', 'min:2', 'max:50'],
                'country' => ['required', 'name', 'min:2', 'max:15'],
                'city' => ['required', 'name', 'min:2', 'max:70'],
                'street' => ['required', 'name', 'min:2', 'max:70'],
                'street_number' => ['required', 'number', 'min:1', 'max:5'],
                'street_suffix' => ['min:1', 'max:50'],
                'zipcode' => ['required', 'min:6', 'max:7'],
                'email' => ['required', 'email', 'min:9', 'max:150'],
                'password' => ['required', 'confirmed', 'min:8', 'max:150'],
            ];

            $var = 'isRequired';

            foreach($variables as $key => $checks) {
            	foreach($checks as $check){
            		$checkExploded = explode(':', $check);
            		if(count($checkExploded) > 1) {
            			// wel een :

            		}
            		else{
            			// geen :

	            		if($check == 'required')  {

	                        if($error = isRequired($_POST[$key], $key, $checks)) {
	                            // actie ondernemen.
	                            if(array_key_exists($key, $errors)) {
	                                array_push($errors[$key], $error);
	                            }
	                            else {
	                                $errors[$key] = [$error];
	                            }
	                        }
	                    }

            		}
            	}
            	if()

                   
                    if(in_array('number', $checks)) {

                        if($error = isNumber($_POST[$key], $key, $checks)) {
                            // actie ondernemen.
                            if(array_key_exists($key, $errors)) {
                                array_push($errors[$key], $error);
                            }
                            else {
                                $errors[$key] = [$error];
                            }
                        }
                    }
            }

            dd($errors);

        }


?>