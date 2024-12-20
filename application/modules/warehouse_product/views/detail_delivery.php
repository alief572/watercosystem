
<div class="box box-primary">
	<div class="box-body">
		<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
				<tr class='bg-blue'>
          <th class='text-center th' style='vertical-align:middle;'>No</th>
          <th class='text-center th' style='vertical-align:middle;'>Product Name</th>
          <th class='text-center th' style='vertical-align:middle;'>Qty Order</th>
          <th class='text-center th' style='vertical-align:middle;'>Qty Delivery</th>
          <th class='text-center th' style='vertical-align:middle;'>Qty Balance </th>
        </tr>

			</thead>
			<tbody>
        <?php
          foreach ($detail as $key => $value) { $key++;
              echo "<tr>";
              echo "<td class='text-center'>".$key."</td>";
              echo "<td>".strtoupper(get_name('ms_inventory_category2','nama','id_category2',$value['product']))."</td>";
              echo "<td class='text-center'>".$value['qty_order']."</td>";
              echo "<td class='text-center'>".$value['qty_delivery']."</td>";
              echo "<td class='text-center'>".$value['qty_kurang']."</td>";
              echo "</tr>";
          }
         ?>
			</tbody>
		</table>
	</div>
</div>
