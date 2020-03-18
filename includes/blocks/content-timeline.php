<?php

namespace Getwid\Blocks;

class ContentTimeline extends \Getwid\Blocks\AbstractBlock {

	protected static $blockName = 'getwid/content-timeline';

	public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			self::$blockName
		);

	}
}

\Getwid\BlocksManager::addBlock(
	new \Getwid\Blocks\ContentTimeline()
);
