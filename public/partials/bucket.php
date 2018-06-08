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
			<td><?php echo $cartProduct['quantity']; ?></td>
			<td><?php echo $cartProduct['price']; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
