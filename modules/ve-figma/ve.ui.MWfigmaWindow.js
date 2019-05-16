/*!
 * VisualEditor UserInterface MWFigmaWindow class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
 
/**
 * MediaWiki figma window.
 *
 * @class
 * @abstract
 *
 * @constructor
 */
  
ve.ui.MWFigmaWindow = function VeUiMWFigmaWindow() {
};

/* Inheritance */

OO.initClass( ve.ui.MWFigmaWindow );


/* Static properties */

ve.ui.MWFigmaWindow.static.icon = 'figmaicon';

ve.ui.MWFigmaWindow.static.title = 'Figma window';

ve.ui.MWFigmaWindow.static.dir = 'ltr';


/* Methods */


/**
 * Initialize window list of editable diagram property fields
 */
ve.ui.MWFigmaWindow.prototype.initialize = function () {
  
	var figma_window = this;
	
	this.nameFieldLayout = new OO.ui.FieldLayout( this.input, {
		align: 'top',
		label: 'Figma URL',
	} );
	
	this.form.$element.append(
		this.nameFieldLayout.$element,
	);	
};

/**
 * @inheritdoc OO.ui.Window
 */
// inherit getReadyProcess parent class
ve.ui.MWFigmaWindow.prototype.getReadyProcess = function ( data, process ) {
	return process.next( function () {
	}, this );
};


/**
 * @inheritdoc OO.ui.Window
 * Subscribe input fields to event handler to refresh image of diagram.
 */
ve.ui.MWFigmaWindow.prototype.getSetupProcess = function ( data, process ) {
	return process.next( function () {
	}, this );
};

/**
 * @inheritdoc OO.ui.Window
 * Unsubscribe events while close window.
 */
ve.ui.MWFigmaWindow.prototype.getTeardownProcess = function ( data, process ) {
	return process.first( function () {
	}, this );
};

/**
 * Add attributes to tag.
 */
ve.ui.MWFigmaWindow.prototype.updateMwData = function ( mwData ) {
};
