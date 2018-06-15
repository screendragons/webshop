<?php

$postcode = '1111aa';

echo standardizePostcode($postcode); // 1111 AA



function standardizePostcode($postcode)
{

	return strtoupper(chunk_split($postcode, 4, ' '));

}