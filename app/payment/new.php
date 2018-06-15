<?php

try {

    // transaction starten
    $connection = db();
    $connection->beginTransaction();

    // user aanmaken
    $query = 'INSERT INTO `users`
    (first_name, suffix_name, last_name, country, city, street, street_number, street_suffix, zipcode, email, password, created_at, updated_at)
    VALUES
    (:first_name, :suffix_name, :last_name, :country, :city, :street, :street_number, :street_suffix, :zipcode, :email, :password, :created_at, :updated_at)';

    $data = [
        'first_name' => standardizeName($_POST['first_name']),
        'suffix_name' => trim($_POST['suffix_name']),
        'last_name' => standardizeName($_POST['last_name']),
        'country' => $_POST['country'],
        'city' => standardizeName($_POST['city']),
        'street' => standardizeName($_POST['street']),
        'street_number' => $_POST['street_number'],
        'street_suffix' => $_POST['street_suffix'],
        'zipcode' => standardizePostcode($_POST['zipcode']),
        'email' => strtolower($_POST['email']),
        'password' => password_hash($_POST['password']PASSWORD_BCRYPT),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ];


    $products = $database->prepare($query); // query voorbereiden
    $products->execute($data);

    $userId = $connection->lastInsertId();

    
    // order aanmaken
    $query = 'INSERT INTO `orders`
    (amount, payment_status, user_id)
    VALUES
    (:amount, "open", :user_id)';


    $products = $database->prepare($query); // query voorbereiden
    $products->execute([
    	'amount' => 
    ]);

    $userId = $connection->lastInsertId();
    // product_order koppellen

    // mollie betaling

    // order updaten met mollie feedback
    dd('no commit');

    // transaction commit
    $connection->commit();

    // doorsturen naar betaling gelukt/mislukt

}
catch(Exception $e) {

    // transaction rollback
    $connection->rollBack();

    dd($e->getMessge());
}


function standardizePostcode($postcode)
{
    return strtoupper(chunk_split($postcode, 4, ' '));
}


function standardizeName($string)
{
    return ucfirst(trim($string));
}