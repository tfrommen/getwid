/**
* External dependencies
*/
import attributes from './attributes';
import { renderSlideHeightPanel } from 'GetwidUtils/render-inspector';
import GetwidCustomTabsControl  from 'GetwidControls/custom-tabs-control';

/**
* WordPress dependencies
*/
import { __ } from 'wp.i18n';

const { Component, Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor || wp.editor;
const { Button, BaseControl, PanelBody, ToggleControl, SelectControl, RadioControl, TextControl } = wp.components;

/**
* Create an Inspector Controls
*/
class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );

		this.changeState = this.changeState.bind( this );

		this.state = {
			tabName: 'general'
		};
	}

	changeState(param, value) {
		this.setState( { [ param ]: value } );
	}

	hasSliderSettings(){

		const { sliderSlidesToShow, sliderSlidesToShowLaptop, sliderSlidesToShowTablet, sliderSlidesToShowMobile, sliderSlidesToScroll, sliderAutoplay, sliderAnimationEffect } = this.props.attributes;
		const { sliderAutoplaySpeed, sliderInfinite, sliderAnimationSpeed, sliderCenterMode, sliderVariableWidth, sliderSpacing } = this.props.attributes;

		return ( 
			sliderSlidesToShow    != attributes.sliderSlidesToShow.default       ||
			sliderSlidesToShowLaptop != attributes.sliderSlidesToShowLaptop.default ||
			sliderSlidesToShowTablet != attributes.sliderSlidesToShowTablet.default ||
			sliderSlidesToShowMobile != attributes.sliderSlidesToShowMobile.default ||
			sliderSlidesToScroll     != attributes.sliderSlidesToScroll.default     ||
			sliderAutoplay           != attributes.sliderAutoplay.default           ||
			sliderAnimationEffect    != attributes.sliderAnimationEffect.default    ||
			sliderAutoplaySpeed      != attributes.sliderAutoplaySpeed.default      ||
			sliderInfinite           != attributes.sliderInfinite.default           ||
			sliderAnimationSpeed     != attributes.sliderAnimationSpeed.default     ||
			sliderCenterMode         != attributes.sliderCenterMode.default         ||
			sliderVariableWidth      != attributes.sliderVariableWidth.default      ||
			sliderSpacing            != attributes.sliderSpacing.default
		);
	}

	render() {
		const {
			attributes:{
				images,
				imageSize,
				imageCrop,
				linkTo,
				imageAlignment,
				sliderAnimationEffect,
				sliderSlidesToShow,
				sliderSlidesToShowLaptop,
				sliderSlidesToShowTablet,
				sliderSlidesToShowMobile,
				sliderSlidesToScroll,
				sliderAutoplay,
				sliderAutoplaySpeed,
				sliderInfinite,
				sliderAnimationSpeed,
				sliderCenterMode,
				sliderVariableWidth,
				sliderSpacing,
				sliderArrows,
				sliderDots,
			},
			setAttributes,
			pickRelevantMediaFiles,
			imgObj
		} = this.props;

		const onChangeImageSize = (imageSize) => {

			if (!imgObj.some((el) => typeof el == 'undefined')){
				setAttributes( {
					imageSize,
					images: imgObj.map( ( image ) => pickRelevantMediaFiles( image, imageSize ) ),
				} );
			}
		};

		const resetSliderSettings = () => {
			setAttributes({
				sliderSlidesToShow: attributes.sliderSlidesToShow.default,
				sliderSlidesToShowLaptop: attributes.sliderSlidesToShowLaptop.default,
				sliderSlidesToShowTablet: attributes.sliderSlidesToShowTablet.default,
				sliderSlidesToShowMobile: attributes.sliderSlidesToShowMobile.default,
				sliderSlidesToScroll: attributes.sliderSlidesToScroll.default,
				sliderAutoplay: attributes.sliderAutoplay.default,
				sliderAnimationEffect: attributes.sliderAnimationEffect.default,
				sliderAutoplaySpeed: attributes.sliderAutoplaySpeed.default,
				sliderInfinite: attributes.sliderInfinite.default,
				sliderAnimationSpeed: attributes.sliderAnimationSpeed.default,
				sliderCenterMode: attributes.sliderCenterMode.default,
				sliderVariableWidth: attributes.sliderVariableWidth.default,
				sliderSpacing: attributes.sliderSpacing.default,
			})
		};

		const { tabName } = this.state;
		const { changeState } = this;

		return (
			<InspectorControls>
				<GetwidCustomTabsControl
					state={tabName}
					stateName={'tabName'}
					onChangeTab={changeState}
					tabs={[ 'general', 'advanced' ]}
				/>

				{ tabName === 'general' && (
					<Fragment>
						<PanelBody initialOpen={true}>
							{ ( imgObj.length != 0 ) && (
								<SelectControl
									label={__( 'Image Size', 'getwid' )}
									help={__( 'For images from Media Library only.', 'getwid' )}
									value={imageSize}
									onChange={onChangeImageSize}
									options={Getwid.settings.image_sizes}
								/>
							)}
							<ToggleControl
								label={__( 'Crop Images', 'getwid' )}
								checked={imageCrop}
								onChange={ () => {
									setAttributes( { imageCrop: ! imageCrop } );
								} }
							/>

							<SelectControl
								label={__( 'Link to', 'getwid' )}
								value={linkTo}
								onChange={linkTo => setAttributes( { linkTo } )}
								options={[
									{ value: 'none'      , label: __( 'None'           , 'getwid') },
									{ value: 'attachment', label: __( 'Attachment Page', 'getwid') },
									{ value: 'media'     , label: __( 'Media File'     , 'getwid') },
									{ value: 'custom'    , label: __( 'Custom link'    , 'getwid') }
								]}
							/>

							{ renderSlideHeightPanel( this ) }

							<ToggleControl
								label={__( 'Enable Slideshow', 'getwid' )}
								checked={sliderAutoplay}
								onChange={ () => {
									setAttributes( { sliderAutoplay: !sliderAutoplay } );
								} }
							/>
							{ !! sliderAutoplay && (
								<TextControl
									label={__( 'Slideshow Speed', 'getwid' )}
									type={'number'}
									value={sliderAutoplaySpeed}
									min={0}
									onChange={sliderAutoplaySpeed => setAttributes( { sliderAutoplaySpeed } )}
								/>
							)}
							{ parseInt( sliderSlidesToShow, 10 ) < 2 && (
								<RadioControl
									disabled={ parseInt(sliderSlidesToShow, 10) < 2 ? null : true}
									label={__( 'Animation Effect', 'getwid' )}
									selected={sliderAnimationEffect}
									options={[
										{ value: 'slide', label: __( 'Slide', 'getwid') },
										{ value: 'fade' , label: __( 'Fade' , 'getwid') }
									]}
									onChange={sliderAnimationEffect => setAttributes( { sliderAnimationEffect } )}
								/>
							) }
							<ToggleControl
								label={__( 'Infinite', 'getwid' )}
								checked={sliderInfinite}
								onChange={() => {
									setAttributes( { sliderInfinite: !sliderInfinite } );
								}}
							/>
							<TextControl
								label={__( 'Animation Speed', 'getwid' )}
								type={'number'}
								value={sliderAnimationSpeed}
								min={0}
								onChange={sliderAnimationSpeed => setAttributes( { sliderAnimationSpeed } )}
							/>
						</PanelBody>
					</Fragment>
				) }

				{ tabName === 'advanced' && (
					<Fragment>
						<PanelBody title={ __( 'Image Settings', 'getwid' ) } initialOpen={true}>
							<TextControl
								label={__( 'Slides on Desktop', 'getwid' )}
								type={'number'}
								value={parseInt( sliderSlidesToShow, 10 )}
								min={1}
								max={10}
								step={1}
								onChange={sliderSlidesToShow => {
									setAttributes({
										sliderSlidesToShow: sliderSlidesToShow.toString()
									});
								}}
							/>
							<TextControl
								disabled={ parseInt(sliderSlidesToShow, 10) > 1 ? null : true }
								label={__( 'Slides on Laptop', 'getwid' )}
								type={'number'}
								value={parseInt( sliderSlidesToShowLaptop, 10 )}
								min={1}
								max={10}
								step={1}
								onChange={sliderSlidesToShowLaptop => {
									setAttributes({
										sliderSlidesToShowLaptop: sliderSlidesToShowLaptop.toString()
									});
								}}
							/>
							<TextControl
								disabled={parseInt(sliderSlidesToShow, 10) > 1 ? null : true}
								label={__( 'Slides on Tablet', 'getwid' )}
								type={'number'}
								value={parseInt(sliderSlidesToShowTablet, 10)}
								min={1}
								max={10}
								step={1}
								onChange={sliderSlidesToShowTablet => {
									setAttributes({
										sliderSlidesToShowTablet: sliderSlidesToShowTablet.toString()
									});
								}}
							/>
							<TextControl
								disabled={parseInt(sliderSlidesToShow, 10) > 1 ? null : true}
								label={__( 'Slides on Mobile', 'getwid' )}
								type={'number'}
								value={parseInt(sliderSlidesToShowMobile, 10)}
								min={1}
								max={10}
								step={1}
								onChange={sliderSlidesToShowMobile => {
									setAttributes({
										sliderSlidesToShowMobile: sliderSlidesToShowMobile.toString()
									});
								}}
							/>
							<TextControl
								disabled={parseInt(sliderSlidesToShow, 10) > 1 ? null : true}
								label={__( 'Slides to Scroll', 'getwid' )}
								type={'number'}
								value={parseInt( sliderSlidesToScroll, 10 )}
								min={1}
								max={10}
								step={1}
								onChange={sliderSlidesToScroll => {
									setAttributes({
										sliderSlidesToScroll: sliderSlidesToScroll.toString()
									});
								}}
							/>
							{ imageCrop == false && images.length > 1 && (
								<SelectControl
									label={__( 'Image Alignment', 'getwid' )}
									value={imageAlignment}
									onChange={imageAlignment => setAttributes( { imageAlignment } )}
									options={[
										{ value: 'top'   , label: __( 'Top'   , 'getwid' ) },
										{ value: 'center', label: __( 'Middle', 'getwid' ) },
										{ value: 'bottom', label: __( 'Bottom', 'getwid' ) }
									]}
								/>
							)}
							<ToggleControl
								label={__( 'Center Mode', 'getwid' )}
								checked={sliderCenterMode}
								onChange={() => {
									setAttributes( { sliderCenterMode: ! sliderCenterMode } );
								}}
							/>
							<ToggleControl
								label={__( 'Variable Width', 'getwid' )}
								checked={sliderVariableWidth}
								onChange={() => {
									setAttributes( { sliderVariableWidth: ! sliderVariableWidth } );
								}}
							/>
							{ parseInt(sliderSlidesToShow, 10) > 1 && (
								<SelectControl
									label={__( 'Spacing', 'getwid' )}
									value={sliderSpacing}
									onChange={sliderSpacing => setAttributes({ sliderSpacing })}
									options={ [
										{ value: 'none'  , label: __( 'None'  , 'getwid' ) },
										{ value: 'small' , label: __( 'Small' , 'getwid' ) },
										{ value: 'normal', label: __( 'Medium', 'getwid' ) },
										{ value: 'large' , label: __( 'Large' , 'getwid' ) },
										{ value: 'huge'  , label: __( 'Huge'  , 'getwid' ) }
									] }
								/>
							) }
							<BaseControl>
								<Button isLink
									onClick={ resetSliderSettings }
									disabled={ ! this.hasSliderSettings() }>
									{__( 'Reset', 'getwid' )}
								</Button>
							</BaseControl>
						</PanelBody>
						<PanelBody title={__( 'Controls Settings', 'getwid' )} initialOpen={false}>
							<RadioControl
								label={__('Arrows', 'getwid')}
								selected={sliderArrows}
								options={[
									{ value: 'ouside', label: __( 'Ouside', 'getwid') },
									{ value: 'inside', label: __( 'Inside', 'getwid') },
									{ value: 'none'  , label: __( 'None'  , 'getwid') }
								]}
								onChange={sliderArrows => setAttributes( { sliderArrows } )}
							/>
							<RadioControl
								label={__('Dots', 'getwid')}
								selected={sliderDots}
								options={ [
									{ value: 'ouside', label: __( 'Ouside', 'getwid' ) },
									{ value: 'inside', label: __( 'Inside', 'getwid' ) },
									{ value: 'none'  , label: __( 'None'  , 'getwid' ) }
								] }
								onChange={sliderDots => setAttributes( { sliderDots } )}
							/>
						</PanelBody>
					</Fragment>
				) }	
			</InspectorControls>
		);
	}
}

export default Inspector;