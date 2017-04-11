<?php

/*
 Created by NycuRO on 11.04.2017.
 */

namespace pocketmine\level\generator\normal\populator;

use pocketmine\block\Block;
use pocketmine\block\Clay;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\VariableAmountPopulator;
use pocketmine\utils\Random;

class Clay extends VariableAmountPopulator
{

	private $level;

	public function __construct()
	{
		parent::__construct(1, 0, 64);
	}

	public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random)
	{
		if(!$this->checkOdd($random))
    	{
			return;
		}
		$this->level = $level;
		$amount = $this->getAmount($random);

		for($i = 0; $i < $amount; ++$i)
    	{
			$x = $chunkX << 4;
			$z = $chunkZ << 4;
			for($size = 20; $size > 0; $size--)
      		{
				$xx = $x - 7 + $random->nextRange(0, 15);
				$zz = $x - 7 + $random->nextRange(0, 15);
				$yy = $this->getHighestWorkableBlock($xx, $zz);
				if($yy !== -1)
        		{
					$this->level->setBlockIdAt($xx, $yy, $zz, Clay::CLAY_BLOCK);
				}
			}
		}
	}

	private function getHighestWorkableBlock($x, $z)
	{
		for($y = 256; $y >= 0; --$y)
    	{
			$b = $this->level->getBlockIdAt($x, $y, $z);
			if($b === Block::WATER)
      		{
				break;
			}
		}
		return $y === 0 ? 200 : $y - 1;
	}
}
