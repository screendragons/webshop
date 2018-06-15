<?php
	require '../boot.php';

	$database = db(); // verbinding maken

	$product = $database->prepare('SELECT * FROM products WHERE slug = :slug');

	try {
		$product->execute([
			'slug' => $_GET['slug']
		]);
		$product->setFetchMode(PDO::FETCH_ASSOC);
		$product = $product->fetch();
	}
	catch(PDOException $e) {
        dd($e->getMessage());
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Webshop</title>
		<link rel="stylesheet" type="text/css" href="<?php echo asset('style.css'); ?>">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	</head>
	<body>
		<section id="home">
			<ul id="list">
				<li id="list"><a href="index.php">Home</a></li>
				<li id="list"><a href="product.php">Products</a></li>
				<li id="list"><a href="shoppingcart.php">Shoppingcart</a></li>
			</ul>

			<div style="clear:both;" class="product">
				<h1><?php echo $product['title']; ?></h1>
				<a href="<?php echo asset('product/'.$product['slug']); ?>">
					<img src="<?php echo asset('images/'.$product['image']); ?>" style="float: left; padding-right: 20px;">
				</a>
				<div style="height: 100px;">
					<button type="button" class="btn btn-warning add-to-cart" data-url="cart/add.php?id=<?php echo $product['id']; ?>">Add to shoppingcart
					</button>
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

