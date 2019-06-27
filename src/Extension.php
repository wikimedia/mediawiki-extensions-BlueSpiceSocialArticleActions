<?php
/**
 * BlueSpiceSocial base extension for BlueSpice
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * This file is part of BlueSpice MediaWiki
 * For further information visit http://bluespice.com
 *
 * @author     Patric Wirth <wirth@hallowelt.com>
 * @package    BlueSpiceSocial
 * @subpackage BlueSpiceSocialArticleActions
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GPL-3.0-only
 */
namespace BlueSpice\Social\ArticleActions;

class Extension extends \BlueSpice\Extension {

	public static function isTrackedNamespace( $iNamespace = 0 ) {
		return !in_array( $iNamespace, [
			NS_SOCIALENTITY,
			NS_USER,
			NS_MEDIAWIKI,
			NS_FILE
		]);
	}
	/**
	 * @param Article $oArticle
	 * @param User $oUser
	 * @param Content $oContent
	 * @param Revision $oRevision
	 * @return string
	 */
	public static function getAutoEditSummaray( $oArticle, $oUser, $oContent, $oRevision ) {
		global $wgLanguageCode;
		$sText = wfMessage( 'bs-socialarticleactions-autoeditsummaray' )
			->inLanguage( $wgLanguageCode )
			->plain();
		return $sText;
	}

	/**
	 * TODO: Track title move and apply them to the action entities - also for
	 * files!
	 * @return boolean
	 */
	public static function onTitleMoveComplete() {
		return true;
	}
}