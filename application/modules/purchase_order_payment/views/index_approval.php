<div class="box">
    <div class="box-body">
        <table id="purchase-order-payment-data_approval" data-payment-list
               data-url="<?= html_escape(base_url('purchase_order_payment/data_approval')) ?>"
               class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Incoming</th>
                    <th>Tanggal Incoming</th>
                    <th>Supplier</th>
                    <th>Total Hutang USD</th>
                    <th>Kurs</th>
                    <th>Total Hutang IDR</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/purchase_order_payment.js') ?>"></script>
