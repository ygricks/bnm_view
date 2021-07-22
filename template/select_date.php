<form method="POST">
	<h3>Currency Exchange Rates</h3>
	<table>
		<tr>
			<td>select date:</td>
			<td><input type="date" name="date" value="<?=$date->format('Y-m-d')?>"></td>
		</tr>
		<tr>
			<td>select valute:</td>
			<td>&nbsp;
				<?php foreach($code as $c=>$v): ?>
					<label for="<?=$c?>"> <?=$c?> <input id="<?=$c?>" type="checkbox" <?=$v?'checked="checked"':''?> name="code[]" value="<?=$c?>"></label> &nbsp;
				<?php endforeach; ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit"></td>
		</tr>
	</table>
</form>