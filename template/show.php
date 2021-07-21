<table>
	<thead>
		<tr>
			<th>Code</th>
			<th>price</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $v):?>
		<tr>
			<td><?=$v['code']?></td>
			<td><?=($v['nominal']==1)?$v['value']:(1/$v['value']*$v['nominal'])?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>