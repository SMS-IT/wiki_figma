/**
 * VisualEditor DataModel MWFigmaNode class.
 *
 * @class
 * @abstract
 *
 * @constructor
 */

ve.dm.MWFigmaNode = function VeDmMWFigmaNode() {
 	ve.dm.MWFigmaNode.super.apply( this, arguments );
};


/* Inheritance */

OO.inheritClass( ve.dm.MWFigmaNode, ve.dm.MWInlineExtensionNode );


/* Static members */

ve.dm.MWFigmaNode.static.name = 'mwFigma';

ve.dm.MWFigmaNode.static.extensionName = 'figma';

ve.dm.MWFigmaNode.static.tagName = 'div';

/*
ve.dm.MWFigmaNode.static.getMatchRdfaTypes = function () {
	return [ 'mw:Extension/figma' ];
};
*/

/* Static methods */

/**
 * @inheritdoc
 */
 /*
ve.dm.MWFigmaNode.static.toDataElement = function ( domElements, converter ) {
	// Parent method
	var dataElement = ve.dm.MWExtensionNode.static.toDataElement.call( this, domElements, converter );
	var isInline = this.isHybridInline( domElements, converter );

	dataElement.type = 'mwFigma';
	return dataElement;
};
*/


/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWFigmaNode );
