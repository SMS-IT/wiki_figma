/**
/**
/**
 * MediaWiki UserInterface Figma tool.
 *
 * @class
 * @extends ve.ui.FragmentInspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */

ve.ui.MWFigmaInspectorTool = function VeUiMWFigmaInspectorTool() {
	ve.ui.MWFigmaInspectorTool.super.apply( this, arguments );
};

OO.inheritClass( ve.ui.MWFigmaInspectorTool, ve.ui.FragmentInspectorTool );

ve.ui.MWFigmaInspectorTool.static.name = 'figmaInspector';
ve.ui.MWFigmaInspectorTool.static.group = 'object';
ve.ui.MWFigmaInspectorTool.static.icon = 'figmaicon';
ve.ui.MWFigmaInspectorTool.static.title = 'Figma diagramm';

ve.ui.MWFigmaInspectorTool.static.modelClasses = [ ve.dm.MWFigmaNode ];
ve.ui.MWFigmaInspectorTool.static.commandName = 'figmaInspector';

ve.ui.toolFactory.register( ve.ui.MWFigmaInspectorTool );
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'figmaInspector', 'window', 'open',
		{ args: [ 'figmaInspector' ], supportedSelections: [ 'linear' ] }
	)
);


ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextFigma', 'figma', '<figma', 6 )
);

ve.ui.commandHelpRegistry.register( 'insert', 'figma', {
	sequences: [ 'wikitextFigma' ],
	label: 'Figma'
} );

