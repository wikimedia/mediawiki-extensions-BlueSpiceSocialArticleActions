<?php
/**
 * Hook handler for MediaWiki hook UploadComplete
 */
namespace BlueSpice\Social\ArticleActions\Hook\UploadComplete;

use BlueSpice\Hook\UploadComplete;
use MediaWiki\MediaWikiServices;

class CreateFileCreateEntity extends UploadComplete {

	protected function skipProcessing() {
		$file = $this->upload->getLocalFile();

		if ( !$file || !$file->exists() || !$file->isLocal() ) {
			return true;
		}

		$res = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_REPLICA )->select(
			'oldimage',
			'oi_name',
			[ 'oi_name' => $file->getTitle()->getDBkey() ],
			__METHOD__,
			[ 'ORDER BY' => 'oi_timestamp DESC' ]
		);
		// we only need new uploads
		if ( $res->numRows() > 0 ) {
			return true;
		}

		return false;
	}

	protected function doProcess() {
		$file = $this->upload->getLocalFile();

		$entityFactory = $this->getServices()->getService(
			'BSEntityFactory'
		);
		$entity = $entityFactory->newFromObject( (object)[
			'ownerid' => $file->getUser( 'id' ),
			'summary' => $file->getDescription(),
			'titletext' => $file->getTitle()->getText(),
			'namespace' => $file->getTitle(),
			'filename' => $file->getName(),
			'filetimestamp' => $file->getTimestamp(),
			'type' => 'filecreate',
		] );

		if ( !$entity ) {
			// do not fatal - here is something wrong very bad!
			return true;
		}

		// TODO: Status check
		$status = $entity->save();
		return true;
	}

}
