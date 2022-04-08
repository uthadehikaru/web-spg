
var KTDatatableHtmlTableDemo = function() {
	// Private functions

	// demo initializer
	var demo = function() {

		var datatable = $('.kt-datatable').KTDatatable({
			data: {
				saveState: {cookie: false},
			},
			search: {
				input: $('#generalSearch'),
			},
			columns: [
				{
					field: 'Total',
					type: 'number',
				}, 
				{
					field: 'Order ID',
					title: 'Order ID',
					autoHide: false,
				},
				{
					field: 'Status',
					title: 'Status',
					autoHide: false,
					// callback function support for column rendering
					template: function(row) {
						var status = {
							'canceled': {'title': 'Canceled', 'class': 'kt-badge--danger'},
							'processed': {'title': 'Processed', 'class': ' kt-badge--success'},
							'draft': {'title': 'Draft', 'class': ' kt-badge--info'},
							'cancel': {'title': 'Waiting Cancel', 'class': ' kt-badge--warning'},
							'error': {'title': 'Error', 'class': ' kt-badge--danger'},
							'processing': {'title': 'Processing', 'class': ' kt-badge--brand'},
						};
						return '<span class="kt-badge ' + status[row.Status].class + ' kt-badge--inline kt-badge--pill">' + status[row.Status].title + '</span>';
					},
				},
			],
		});

    $('#kt_form_status').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'Status');
    });

    $('#kt_form_status').selectpicker();

	};

	return {
		// Public functions
		init: function() {
			// init dmeo
			demo();
		},
	};
}();

jQuery(function() {
	KTDatatableHtmlTableDemo.init();
});