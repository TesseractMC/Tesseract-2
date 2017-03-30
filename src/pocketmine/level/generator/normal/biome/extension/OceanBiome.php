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

use pocketmine\level\generator\normal\populator\Mushroom;
use pocketmine\level\generator\normal\populator\SugarCane;
use pocketmine\level\generator\normal\populator\TallGrass;

use pocketmine\level\generator\normal\biome\WateryBiome as WB;

class OceanBiome extends WB
{

	/* DESC:
	A large, open biome made entirely of water going up to y=63, with underwater relief on the sea floor, such as small mountains and plains, usually including gravel. 
	Oceans typically extend under 3,000 blocks in any direction, around 60% of the Overworld's surface is covered in Ocean. 
	Small islands with infrequent vegetation can be found in oceans. 
	Passive mobs are unable to spawn on these islands, but hostiles can. 
	Cavern entrances can be found infrequently at the bottom of the ocean. 
	In the Console versions, they surround the edges of the map.
	*/

	public function __construct()
	{
		parent::__construct();

		$this->setElevation(46, 63);

		$this->temperature = 0.5;
		$this->rainfall = 0.5;
	}

	public function getName() : string
	{
		return "Ocean";
	}

}
