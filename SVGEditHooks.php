<?php

use MediaWiki\MediaWikiServices;
use MediaWiki\Title\Title;

/**
 * SVGEdit extension: hooks
 * @copyright 2010 Brion Vibber <brion@pobox.com>
 */

class SVGEditHooks {
	/* Static Methods */

	/**
	 * BeforePageDisplay hook
	 *
	 * Adds the modules to the page
	 *
	 * @param OutputPage $out output page
	 * @param Skin $skin current skin
	 * @return bool
	 */
	public static function beforePageDisplay( OutputPage $out, Skin $skin ) {
		global $wgRequest, $wgSVGEditInline;
		$title = $out->getTitle();
		$user = $out->getUser();
		$modules = [];
		if ( self::trigger( $title, $user ) ) {
			$modules[] = 'ext.svgedit.editButton';
		}
		if ( $wgSVGEditInline ) {
			// Experimental inline edit trigger.
			// Potentially expensive and tricky as far as UI on article pages!
			if ( $user->isAllowed( 'upload' ) ) {
				$modules[] = 'ext.svgedit.inline';
			}
		}
		if ( $wgRequest->getVal( 'action' ) == 'edit' ) {
			if ( $user->isAllowed( 'upload' ) ) {
				$modules[] = 'ext.svgedit.toolbar';
			}
		}
		if ( $modules ) {
			$out->addModules( $modules );
		}
		return true;
	}

	/**
	 * MakeGlobalVariablesScript hook
	 *
	 * Exports a setting if necessary.
	 *
	 * @param array &$vars Array of vars
	 * @return bool
	 */
	public static function makeGlobalVariablesScript( array &$vars ) {
		global $wgSVGEditEditor;
		$vars['wgSVGEditEditor'] = $wgSVGEditEditor;
		return true;
	}

	/**
	 * Should the editor links trigger on this page?
	 *
	 * @param Title $title
	 * @param User $user
	 * @return bool
	 */
	private static function trigger( Title $title, User $user ) {
		if ( $title && $title->getNamespace() == NS_FILE ) {
			if ( class_exists( 'MediaWiki\Permissions\PermissionManager' ) ) {
				// MW 1.33+
				$pm = MediaWikiServices::getInstance()->getPermissionManager();
				return $pm->userCan( 'edit', $user, $title ) &&
					$pm->userCan( 'upload', $user, $title );
			} else {
				return $title->userCan( 'edit' ) && $title->userCan( 'upload' );
			}
		}
		return false;
	}

}
