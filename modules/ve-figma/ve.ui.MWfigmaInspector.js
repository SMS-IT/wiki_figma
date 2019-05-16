/**
 * MediaWiki figma inspector.
 *
 * @class
 * @extends ve.ui.MWLiveExtensionInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */

ve.ui.MWFigmaInspector = function VeUiMWFigmaInspector() {
	
	// Parent constructor
	ve.ui.MWFigmaInspector.super.apply( this, arguments );

	// Mixin constructor
	ve.ui.MWFigmaWindow.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWFigmaInspector, ve.ui.MWLiveExtensionInspector );

OO.mixinClass( ve.ui.MWFigmaInspector, ve.ui.MWFigmaWindow );

/* Static properties */

ve.ui.MWFigmaInspector.static.name = 'figmaInspector';

ve.ui.MWFigmaInspector.static.modelClasses = [ ve.dm.MWFigmaNode ];

ve.ui.MWFigmaInspector.static.title = 'Figma properties';

ve.ui.MWFigmaInspector.static.dir = 'ltr';


/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWFigmaInspector.prototype.initialize = function () {
 //console.log('ve.ui.MWFigmaInspector.prototype.initialize');
	// Parent method
	ve.ui.MWFigmaInspector.super.prototype.initialize.call( this );

	// Mixin method
	ve.ui.MWFigmaWindow.prototype.initialize.call( this );

	// Initialization
	this.$content.addClass( 've-ui-mwFigmaInspector-content' );
};

/**
 * @inheritdoc
 */
ve.ui.MWFigmaInspector.prototype.getReadyProcess = function ( data ) {
 console.log('ve.ui.MWFigmaInspector.prototype.getReadyProcess');
	// Parent process
	var process = ve.ui.MWFigmaInspector.super.prototype.getReadyProcess.call( this, data );
	// Mixin process
	return ve.ui.MWFigmaWindow.prototype.getReadyProcess.call( this, data, process );
};

/**
 * @inheritdoc
 */
ve.ui.MWFigmaInspector.prototype.getSetupProcess = function ( data ) {
 //console.log('ve.ui.MWFigmaInspector.prototype.getSetupProcess');
	// Parent process
	var process = ve.ui.MWFigmaInspector.super.prototype.getSetupProcess.call( this, data );
	// Mixin process
	return ve.ui.MWFigmaWindow.prototype.getSetupProcess.call( this, data, process ).next( function () {
		//
	}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWFigmaInspector.prototype.getTeardownProcess = function ( data ) {
 //console.log('ve.ui.MWFigmaInspector.prototype.getTeardownProcess');
	// Parent process
	var process = ve.ui.MWFigmaInspector.super.prototype.getTeardownProcess.call( this, data );
	// Mixin process
	return ve.ui.MWFigmaWindow.prototype.getTeardownProcess.call( this, data, process ).first( function () {
		//
	}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWFigmaInspector.prototype.updateMwData = function () {
 //console.log('ve.ui.MWFigmaInspector.prototype.updateMwData');
	// Parent method
	ve.ui.MWFigmaInspector.super.prototype.updateMwData.apply( this, arguments );	
	// Mixin method
	ve.ui.MWFigmaWindow.prototype.updateMwData.apply( this, arguments );
};



/* Registration */

ve.ui.windowFactory.register( ve.ui.MWFigmaInspector );
