/**
* External dependencies
*/
import Save from './save';
import Edit from './edit';

import { __ } from 'wp.i18n';

/**
* WordPress dependencies
*/
const {
	registerBlockType
} = wp.blocks;

/**
* Module Constants
*/
const baseClass = 'wp-block-getwid-contact-form-name';

/**
* Component Output
*/
export default registerBlockType(
    'getwid/contact-form-name',
    {
        title: __('Contact Form Name', 'getwid'),
        category: 'getwid-blocks',
        parent: [ 'getwid/contact-form' ],

        keywords: [
		],

        attributes: {
            label: {
                type: 'string',
                source: 'html',
                selector: '.wp-block-getwid-contact-form-name__label'
            },
            name: {
                type: 'string',
                source: 'attribute',
                selector: '.components-base-control__field input',
                attribute: 'placeholder'
            }
        },
        edit: (props) => {
            return (
                <Edit {...{
                    ...props,
                    baseClass,
                }}/>
            )
        },
        save: (props) => {
            return (
                <Save {...{
                    ...props,
                    baseClass,
                }}/>
            )
        }
    }
);