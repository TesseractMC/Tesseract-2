<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

/* Modificated by NycuRO on 27.03.2017 */

namespace pocketmine\level\generator\normal\biome\extension;

use pocketmine\block\Block;
use pocketmine\block\Flower as FlowerBlock;
use pocketmine\level\generator\normal\populator\Flower;
use pocketmine\level\generator\normal\populator\LilyPad;
use pocketmine\level\generator\normal\populator\Mushroom;
use pocketmine\level\generator\normal\populator\SugarCane;
use pocketmine\level\generator\normal\populator\TallGrass;

use pocketmine\level\generator\normal\biome\GrassyBiome as GB;

class SwampBiome extends GB
{

	public function __construct()
	{
		parent::__construct();

		$flower = new Flower();
		$flower->setBaseAmount(8);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_BLUE_ORCHID]);

		$lilyPad = new LilyPad();
		$lilyPad->setBaseAmount(4);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(1);

		$mushroom = new Mushroom();
		$sugarCane = new SugarCane();
		$sugarCane->setBaseAmount(2);
		$sugarCane->setRandomAmount(15);

		$this->addPopulator($mushroom);
		$this->addPopulator($lilyPad);
		$this->addPopulator($flower);
		$this->addPopulator($tallGrass);
		$this->addPopulator($sugarCane);
		$this->setElevation(60, 66);

		$this->temperature = 0.8;
		$this->rainfall = 0.9;
	}

	public function getName() : string
	{
		return "Swamp";
	}

}