<?php
/**
 * Wrapper to integrate SVG-edit in-browser vector graphics editor in MediaWiki.
 * https://www.mediawiki.org/wiki/Extension:SVGEdit
 *
 * @copyright 2010 Brion Vibber <brion@pobox.com>
 *
 * MediaWiki-side code is GPL
 *
 * SVG-edit is under Apache license: http://code.google.com/p/svg-edit/
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'SVGEdit',
	'author'         => array( 'Brion Vibber' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SVGEdit',
	'descriptionmsg' => 'svgedit-desc',
);

$wgMessagesDirs['SVGEdit'] = __DIR__ . '/i18n';

$wgHooks['BeforePageDisplay'][] = 'SVGEditHooks::beforePageDisplay';
$wgHooks['MakeGlobalVariablesScript'][] = 'SVGEditHooks::makeGlobalVariablesScript';

$wgAutoloadClasses['SVGEditHooks'] = dirname( __FILE__ ) . '/SVGEdit.hooks.php';

$myResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'SVGEdit/modules',
	'group' => 'ext.svgedit',
);
$wgResourceModules += array(
	'ext.svgedit.editor' => $myResourceTemplate + array(
		'scripts' => array(
			'ext.svgedit.embedapi.js',
			'ext.svgedit.formmultipart.js',
			'ext.svgedit.io.js',
			'ext.svgedit.editor.js',
		),
		'styles' => array(
			'ext.svgedit.editButton.css',
		),
		'messages' => array(
			'svgedit-summary-label',
			'svgedit-summary-default',
			'svgedit-editor-save-close',
			'svgedit-editor-close',
		),
		'dependencies' => array(
			'jquery.ui'
		)
	),
);
$wgResourceModules += array(
	'ext.svgedit.editButton' => $myResourceTemplate + array(
		'scripts' => array(
			'ext.svgedit.editButton.js',
		),
		'messages' => array(
			'svgedit-editbutton-edit',
			'svgedit-edit-tab',
			'svgedit-edit-tab-tooltip'
		),
		'dependencies' => array(
			'ext.svgedit.editor'
		)
	),
);
$wgResourceModules += array(
	'ext.svgedit.inline' => $myResourceTemplate + array(
		'scripts' => array(
			'ext.svgedit.inline.js',
		),
		'messages' => array(
			'svgedit-editbutton-edit',
		),
		'dependencies' => array(
			'ext.svgedit.editor'
		)
	),
);
$wgResourceModules += array(
	'ext.svgedit.toolbar' => $myResourceTemplate + array(
		'scripts' => array(
			'ext.svgedit.toolbar.js',
		),
		'messages' => array(
			'svgedit-toolbar-insert',
		),
		'dependencies' => array(
			'ext.svgedit.editor'
		)
	),
);

// Can set to alternate SVGEdit URL to pull the editor's HTML/CSS/JS/SVG
// resources from another domain.
//
// By default, a master copy from Google Code is used. This may or may not be stable.
//
$wgSVGEditEditor = 'http://svg-edit.googlecode.com/svn/trunk/editor/svg-editor.html';

// Set to enable experimental triggers for SVG editing within article views.
// Not yet recommended.
$wgSVGEditInline = false;
