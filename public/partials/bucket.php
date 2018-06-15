<h2>Winkelwagen</h2>

<table class="table">
	<thead>
		<tr>
			<th>Titel</th>
			<th>Aantal</th>
			<th>Prijs</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach($_SESSION['cart']['products'] as $cartProduct) { ?>
		<tr>
			<td><?php echo $cartProduct['title']; ?></td>
			<td><?php echo $cartProduct['quantity']; ?>
				<button type="button" class="btn btn-success btn-xs add-to-cart" data-url="<?php echo asset('cart/add.php?id='.$cartProduct['id']); ?>">+</button>
				<button type="button" class="btn btn-danger btn-xs remove-from-cart" data-url="<?php echo asset('cart/remove.php?id='.$cartProduct['id']); ?>">-</button>
			</td>
			<td><?php echo $cartProduct['price']; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
