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

/* Created by NycuRO on 30.03.2017 */

namespace pocketmine\level\generator\normal\biome\extension;

class DeepOceanBiome extends OceanBiome
{

	/* DESC:
  A variation of the Ocean biome. 
  In deep ocean biomes, the ocean can exceed 30 blocks in depth, making it twice as deep as the normal ocean. 
  In contrast to default oceans, the ground is mainly covered with gravel. 
  Ocean monuments generate in deep oceans, which spawn guardians.
	*/

	public function __construct()
	{
		parent::__construct();

		$this->setElevation(16, 63);

		$this->temperature = 0.5F;
		$this->rainfall = 0.5F;
	}

	public function getName() : string
	{
		return "Deep Ocean";
	}

}