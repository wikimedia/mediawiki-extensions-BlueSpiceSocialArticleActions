<?php
namespace BlueSpice\Social\ArticleActions\Hook\PageContentSaveComplete;

use BlueSpice\Hook\PageContentSaveComplete;

class CreateArticleSaveEntity extends PageContentSaveComplete {
	protected function skipProcessing() {
		if ( $this->isMinor || !$this->revision ) {
			return true;
		}
		if ( !$this->status->isOK() || $this->status->hasMessage( 'edit-no-change' ) ) {
			// ugly. we need to check the status object for the no edit warning,
			// cause on this point in the code it ist - unfortunaltey -
			// impossible to find out, if this edit changed something.
			// '$article->getLatest()' is always the same as
			// '$this->revision->getId()'. '$baseRevId' is always 'false' #5240
			return true;
		}
		$title = $this->wikipage->getTitle();

		if ( !$title || !$title->exists() ) {
			return true;
		}
		$tracked = \BlueSpice\Social\ArticleActions\Extension::isTrackedNamespace(
			$title->getNamespace()
		);
		if ( !$tracked ) {
			return true;
		}
		if ( $title->isTalkPage() ) {
			return true;
		}
		if ( $title->getContentModel() != 'wikitext' ) {
			return true;
		}
		if ( $title->isNewPage() ) {
			return true;
		}

		return false;
	}

	protected function doProcess() {
		$title = $this->wikipage->getTitle();

		$entityFactory = $this->getServices()->getService(
			'BSEntityFactory'
		);
		$entity = $entityFactory->newFromObject( (object)[
			'ownerid' => $this->user->getId(),
			'wikipageid' => $title->getArticleID(),
			'titletext' => $title->getText(),
			'namespace' => $title->getNamespace(),
			'revisionid' => $this->revision->getId(),
			'type' => 'articlesave',
		] );
		if ( !$entity ) {
			// do not fatal - here is something wrong very bad! :(
			return true;
		}

		// TODO: Status check
		$status = $entity->save();
		return true;
	}
}
