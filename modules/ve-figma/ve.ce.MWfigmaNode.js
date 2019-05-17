/**
 * ContentEditable MediaWiki Figma node.
 *
 * @class
 * @extends ve.ce.MWInlineExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWFigmaNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
 
ve.ce.MWFigmaNode = function VeCeMWFigmaNode() {
	ve.ce.MWFigmaNode.super.apply( this, arguments ); 
};

/* Inheritance */

OO.inheritClass( ve.ce.MWFigmaNode, ve.ce.MWInlineExtensionNode );

/* Static Properties */

ve.ce.MWFigmaNode.static.name = 'mwFigma';

ve.ce.MWFigmaNode.static.primaryCommandName = 'figma';

ve.ce.MWFigmaNode.static.tagName = 'div';


/* Methods */

// Inherits from ve.ce.BranchNode
ve.ce.MWFigmaNode.prototype.onSetup = function () {
	// Parent method
	ve.ce.MWFigmaNode.super.prototype.onSetup.call( this );

	// DOM changes
	this.$element.addClass( 've-ce-mwFigmaNode' );
};

// Inherits from ve.ce.GeneratedContentNode
/*
ve.ce.MWFigmaNode.prototype.generateContents = function () {
	var node = this,
		args = arguments;
	// Parent method
	return ve.ce.MWExtensionNode.prototype.generateContents.apply( node, args );
};
*/

/*
ve.ce.MWFigmaNode.prototype.validateGeneratedContents = function ( $element ) {
	if ( $element.is( 'div' ) && $element.hasClass( 'errorbox' ) ) {
		return false;
	}
	return true;
};
*/

// Inherits from ve.ce.FocusableNode
/*
ve.ce.MWFigmaNode.prototype.getBoundingRect = function () {
	// HACK: Because nodes can overflow due to the pre tag, just use the
	// first rect (of the wrapper div) for placing the context.
	return this.rects[ 0 ];
};
*/

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWFigmaNode );
