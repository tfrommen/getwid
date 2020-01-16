/**
* External dependencies
*/
import { __ } from 'wp.i18n';
import { isEqual } from 'lodash';

/**
* WordPress dependencies
*/
const { isBlobURL } = wp.blob;
const { withSelect } = wp.data;

const { Component, Fragment } = wp.element;
const { Spinner, IconButton } = wp.components;

/**
* Module Constants
*/
const baseClass = 'wp-block-getwid-images-slider';

/**
* Create an Sub Component
*/
class MediaContainer extends Component {
	constructor() {
		super( ...arguments );

		this.bindContainer = this.bindContainer.bind( this );
	}

	bindContainer( ref ) {
		this.container = ref;
	}

	componentDidUpdate( prevProps ) {
		const { image, url } = this.props;
		if ( image && ! url ) {
			this.props.setAttributes( {
				url: image.source_url,
				alt: image.alt_text,
			} );
		}
	}

	render() {
		const { url, original_url, alt, id, linkTo, link, custom_link, isSelected } = this.props;
		let href;

		if (linkTo == 'media'){
			href == original_url;
		} else if (linkTo == 'attachment') {
			href == link;
		} else if (linkTo == 'custom') {
			href == custom_link;
		}

		const img = (
			<Fragment>
				<img
					className={`${baseClass}__image`}
					src={url}
					alt={alt}
					data-custom-link={custom_link ? custom_link : undefined}
					data-original-link={original_url ? original_url : undefined}
					data-id={id}
					tabIndex='0'
				/>
				{ isBlobURL( url ) && <Spinner/> }
			</Fragment>
		);

		return (
			<Fragment>
				{href ? <a href={href}>{img}</a> : img}
			</Fragment>
		);
	}
}

export default withSelect( ( select, ownProps ) => {
	const { getMedia } = select( 'core' );
	const { id } = ownProps;

	return {
		image: id ? getMedia( id ) : null
	};
} )( MediaContainer );