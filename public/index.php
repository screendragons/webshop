<?php
	require '../boot.php';


	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	    require '../../app/validation/createPublicUser.php';
	}

	$database = db(); // verbinding maken
	//query SELECT * FROM products ORDER BY id DESC LIMIT 3
	// result

	$products = $database->prepare('SELECT * FROM products ORDER BY id DESC LIMIT 3');

	try {
		$products->execute([]);
		$products->setFetchMode(PDO::FETCH_ASSOC);
		$products = $products->fetchAll();
	}
	catch(PDOException $e) {
        dd($e->getMessage());
    }

   /* Dit stuk nog verplaatsen*/
  	if($_SERVER['REQUEST_METHOD'] === 'POST') {


	   $variables = [
	       'email' => ['required', 'email', 'min:7', 'max:155'],
	       'password' => ['required', 'min:8', 'max:100', 'confirmed'],
	       'first_name' => ['required', 'name', 'min:2', 'max:50'],
	       'suffix_name' => ['min:1', 'max:15', 'name'],
	       'last_name' => ['required', 'name', 'min:2', 'max:50'],
	       'country' => ['min:2', 'max:15', 'name'],
	       'city' => ['required', 'min:2', 'max:55', 'name'],
	       'street' => ['required', 'min:2', 'max:85', 'name'],
	       'street_number' => ['required', 'min:1', 'max:5'],
	       'street_suffix' => ['min:1', 'max:25'],
	       'zipcode' => ['required', 'postcode', 'min:6', 'max:7'],
	   ];

	   require '../../app/validation/validations.php';

	   if(count($errors) == 0) {
	       require '../../app/payment/new.php';
	   }

	   dd('Joepie! We kunnen betalen!');

	/*
	   $webhookUrl = (router()->domainName == 'localhost') ? 'https://686079cb.ngrok.io/webshop/public/pay/webhook/'.$orderId : router()->name('pay.webhook', ['orderId' => $orderId]);

	       $mollie = new \Mollie\Api\MollieApiClient();
	       $mollie->setApiKey('test_ERVdf4R9tBQwyfAmEbcvpNn2R45fwJ'); // test api key

	       // create a mollie api v2 payment: https://github.com/mollie/mollie-api-php
	       $payment = $mollie->payments->create([
	           "amount" => [
	               "currency" => "EUR",
	               "value" => (string)$_SESSION['cart']['total']
	           ],
	           "description" => "Bedankt voor uw aankoop bij MyBikeShop.nl!",
	           "redirectUrl" => router()->name('pay.done', ['orderId' => $orderId]),
	           "webhookUrl"  => $webhookUrl,
	           'metadata' => $orderId, // send along the order id
	       ]);
	 */

	}

	function value($key)
	{
		return @$_POST[$key];
	}

	/*tot hier*/
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Webshop</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

	</head>
	<body>
		<section id="home">
			<ul id="list">
				<li id="list"><a href="index.php">Home</a></li>
				<li id="list"><a href="product.php">Products</a></li>
				<li id="list"><a href="shoppingcart.php">Shoppingcart</a></li>
			</ul>

			<?php foreach($products as $product) { ?>
			<div style="clear:both;" class="product">
				<h1><?php echo $product['title']; ?></h1>
				<a href="<?php echo asset('product/'.$product['slug']); ?>">
					<img src="<?php echo asset('images/'.$product['image']); ?>" style="float: left; padding-right: 20px;">
				</a>
				<div style="height: 100px;">
					<a href="shoppingcart.php"><button type="button" class="btn btn-warning add-to-cart" data-url="cart/add.php?id=<?php echo $product['id']; ?>">Add to shoppingcart
					</button></a>
				</div>

			</div>
			
			<div class="row">
  				<div class="column">
					<p>
					 Lorem ipsum dolor sit amet, nonumes patrioque an vim. Id magna molestiae quo. Dico soleat delicata an nam, mei erat altera dissentiunt et, usu postea scriptorem interpretaris ex. An tempor delicata deterruisset eum, wisi semper probatus id mel. Ea malis putent vocent eum.

					 Aliquid principes pro no. No alii mandamus honestatis vel, laudem eirmod quaerendum nam at. Qui albucius singulis cu, inani harum at pro. Vidit illud fierent sea no, cum virtute pertinacia in. Eos et quaeque voluptatum, cum ne eruditi quaestio intellegam.

					</p>
				</div>
			</div>
			<?php } ?>
		</section>

		<aside class="bucket" id="bucket">
			<?php include "partials/bucket.php"; ?>
		</aside>

		
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

		<script>
			$(document).ready(function() {
			    bucket();
			});


			function bucket()
			{
			    $('.add-to-cart, .remove-from-cart').unbind('click').click(function(event) {
			        event.preventDefault();

			        // alert($(this).data('url'));

			        jQuery.ajax($(this).data('url'), {
			            method: 'post',
			            cache: false,
			            // dataType: 'json',
			        })
			        .done(function(data) {
			            if(data) {
			                $('#bucket').html(data);
			                bucket();
			            }
			        })
			        .fail(function() {
			            alert( "error" );
			            bucket();
			        });
			    });
			}
		</script>
	<!-- 	<script>
			  document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')
		</script> -->
	</body>
</html>
