/**
 *
 * @author     Patric Wirth <wirth@hallowelt.com>
 * @package    BluespiceSocial
 * @subpackage BSSocialActionMW
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License v2 or later
 */

bs.social.EntityFileSave = function( $el, type, data ) {
	bs.social.EntityAction.call( this, $el, type, data );
	var me = this;
};
OO.initClass( bs.social.EntityFileSave );
OO.inheritClass( bs.social.EntityFileSave, bs.social.EntityAction );

bs.social.EntityFileSave.static.name = "\\BlueSpice\\Social\\ArticleActions\\Entity\\ActionFileSave";
bs.social.factory.register( bs.social.EntityFileSave );
