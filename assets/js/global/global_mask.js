/* phone */
Inputmask({
	mask: '9',
	repeat: 15,
	greedy: false,
}).mask('.mask_phone');

Inputmask({
	mask: '*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]',
	greedy: false,
	onBeforePaste: function (pastedValue, opts) {
		pastedValue = pastedValue.toLowerCase();
		return pastedValue.replace('mailto:', '');
	},
	definitions: {
		'*': {
			validator: '[0-9A-Za-z!#$%&"*+/=?^_`{|}~-]',
			cardinality: 1,
			casing: 'lower',
		},
	},
}).mask('.mask_email');
