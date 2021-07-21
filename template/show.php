<table>
	<thead>
		<tr>
			<th>Code</th>
			<th></th>
			<th>price</th>
		</tr>
	</thead>
	<tbody>
		<h3><?=$header?></h3>
		<br>
		<?php foreach($data as $v):?>
		<tr>
			<td><?=$v['code']?></td>
			<td> ...... </td>
			<?php $w=($v['nominal']==1)?$v['value']:(1/$v['value']*$v['nominal']); ?>
			<td><?=number_format($w,4)?></td>
		</tr>
		<?php endforeach; ?>
</table>
	</tbody>
</table>