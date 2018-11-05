<!DOCTYPE html>
<html>
<head>
	{ include("_views/include/head.php") }
	{ css src/plugins/datatables/media/css/jquery.dataTables.css }
	{ css src/plugins/datatables/media/css/dataTables.bootstrap4.css }
	{ css src/plugins/datatables/media/css/responsive.dataTables.css }
</head>
<body>
	{ include("_views/include/header.php") }
	{ include("_views/include/sidebar.php") }
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Kunden</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{ :app_url }">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Kunden</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Export Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Kundenübersicht</h5>
						</div>
					</div>
					<div class="row">
						<table class="stripe hover multiple-select-row data-table-export nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Rechnungsnummer</th>
									<th>Kunde</th>
                                    <th>Produkt</th>
									<th>Total</th>
									<th>Bezahlt</th>
                                    <th>Aktion</th>
								</tr>
							</thead>
                            <tbody>
                                { foreach :invoice in :data }
                                <tr>
                                    <td class="table-plus"><a data-id="{ :invoice.link }" onclick="openInvoice(this.dataset.id)">{ :invoice.invoice_id }</a></td>
                                    <td>{ :invoice.customer }</td>
                                    <td>{ :invoice.product }</td>
                                    <td>{ :invoice.total }</td>
                                    <td>{ :invoice.complete }</td>
                                    <td><a class="btn btn-success" data-id="{ :invoice.id }" onclick="mark(this.dataset.id)" href="#"><i class="fa fa-check"></i>Als bezahlt makieren</a>
                                    </td>
                                </tr>
                                { endforeach }

							</tbody>
						</table>
					</div>
				</div>
            </div>
			{ include("_views/include/footer.php") }
		</div>
	</div>
	{ include("_views/include/script.php") }
	{ js src/plugins/datatables/media/js/jquery.dataTables.min.js }
	{ js src/plugins/datatables/media/js/dataTables.bootstrap4.js }
	{ js src/plugins/datatables/media/js/dataTables.responsive.js }
	{ js src/plugins/datatables/media/js/responsive.bootstrap4.js }
	<!-- buttons for Export datatable -->
	{ js src/plugins/datatables/media/js/button/dataTables.buttons.js }
	{ js src/plugins/datatables/media/js/button/buttons.bootstrap4.js }
	{ js src/plugins/datatables/media/js/button/buttons.print.js }
	{ js src/plugins/datatables/media/js/button/buttons.html5.js }
	{ js src/plugins/datatables/media/js/button/buttons.flash.js }
	{ js src/plugins/datatables/media/js/button/pdfmake.min.js }
	{ js src/plugins/datatables/media/js/button/vfs_fonts.js }

	<script>

        function mark(id) {
            $.get("{ :app_url }api/mark/" + id, function(data, status) {
                console.log(data);
                window.location.reload(true);
            });
        }

        function openInvoice(link) {
            let strWindowFeatures = "location=yes,height=932,width=646,scrollbars=yes,status=yes";
            let win = window.open(link, "_blank", strWindowFeatures);
        }

		$('document').ready(function(){
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"language": {
					"info": "_START_-_END_ of _TOTAL_ entries",
					searchPlaceholder: "Search"
				},
			});
			$('.data-table-export').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"language": {
					"info": "_START_-_END_ of _TOTAL_ entries",
					searchPlaceholder: "Search"
				},
				dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
				]
			});
			var table = $('.select-row').DataTable();
			$('.select-row tbody').on('click', 'tr', function () {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
			var multipletable = $('.multiple-select-row').DataTable();
			$('.multiple-select-row tbody').on('click', 'tr', function () {
				$(this).toggleClass('selected');
			});
		});
	</script>
</body>
</html>