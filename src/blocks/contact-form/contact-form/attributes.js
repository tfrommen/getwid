const attributes = {
	align: {
		type: 'string'
	},
	backgroundColor: {
		type: 'string'
	},
	textColor: {
		type: 'string'
	},
	customBackgroundColor: {
		type: 'string'
	},
	customTextColor: {
		type: 'string'
	},
	to: {
		type: 'string',
		source: 'attribute',
		selector: '.wp-block-getwid-contact-form__to',
		attribute: 'value',
		default: null
	},
	subject: {
		type: 'string',
		source: 'attribute',
		selector: '.wp-block-getwid-contact-form__subject',
		attribute: 'value',
		default: null
	},
	align: {
		type: 'string'
	},
	text: {
		type: 'string',
		source: 'html',
		selector: 'button',
		default: 'Submit'
	}
};

export default attributes;