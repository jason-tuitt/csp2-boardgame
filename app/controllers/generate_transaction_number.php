<?php  

function referenceNumberGenerator() {
    $ref_number = '';
    
    $source = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
    
    for ($i = 0; $i < 16; $i++) {
        $index = rand(0, 15); // Generate random number
        
        // Append random character
        $ref_number = $ref_number . $source[$index];
    }
    
    $today = getdate();  // Seconds since Unix Epoch
    
    return $ref_number.'-'.$today[0];
}

// $referenceNumber = referenceNumberGenerator();



// var_export( referenceNumberGenerator() );