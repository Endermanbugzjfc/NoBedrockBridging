<?php

declare(strict_types=1);

namespace Endermanbugzjfc\NoBedrockBridging\libs\_cf61bfba62556b0f\cosmicpe\npcdialogue\player;

use Endermanbugzjfc\NoBedrockBridging\libs\_cf61bfba62556b0f\cosmicpe\npcdialogue\dialogue\NpcDialogue;

final class PlayerNpcDialogueInfo{

	public const STATUS_SENT = 0;
	public const STATUS_RECEIVED = 1;
	public const STATUS_CLOSED = 2;

	/**
	 * @param NpcDialogue $dialogue
	 * @param self::STATUS_* $status
	 * @param int $tick
	 */
	public function __construct(
		public NpcDialogue $dialogue,
		public int $status,
		public int $tick
	){}
}