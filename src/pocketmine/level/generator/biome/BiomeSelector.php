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

namespace pocketmine\level\generator\biome;

use pocketmine\level\generator\noise\Simplex;
use pocketmine\utils\Random;

class BiomeSelector{

	/** @var Biome */
	private $fallback;

	/** @var Simplex */
	protected $temperature;
	/** @var Simplex */
	protected $rainfall;

	/** @var Biome[] */
	private $biomes = [];

	private $map = [];


	public function __construct(Random $random, Biome $fallback){
		$this->fallback = $fallback;
		$this->temperature = new Simplex($random, 2, 1 / 16, 1 / 512);
		$this->rainfall = new Simplex($random, 2, 1 / 16, 1 / 512);
	}
	
	public function lookup(float $temperature, float $rainfall)
	{

		if($temperature < 0.5)
		{
			// Cold Biomes here.

			if($temperature < 0.15)
			{

				if($rainfall < 0.5)
				{
					// return Biome::EXTREME_HILLS;
				} 
				else
				{
					// return Biome::SMALLER_EXTREME_HILLS;
				}
			}
			if($temperature < 0.4)
			{

				if($rainfall < 0.5)
				{

					return Biome::TAIGA;

				}
				else
				{

					return Biome::ICE_FLATS;

				}
			}

			if($rainfall < 0.5) 
			{

				return Biome::PLAINS;

			}
			else
			{

				return Biome::RIVER;

			}
		}
		else
		{
			// Warm Biomes
			if($temperature < 0.6)
			{

				if($rainfall < 0.5)
				{

					return Biome::BIRCH_FOREST;

				}
				else
				{

					return Biome::FOREST;

				}
			}

			if($temperature < 0.7)
			{
				// return Biome::ROOFED_FOREST;
			}

			if($rainfall < 0.25)
			{

				if($temperature < 0.85)
				{

					return Biome::DESERT;

				}
				else
				{
					// return Biome::MESA_PLATEAU;
				}
			}

			if($rainfall < 0.85)
			{

				if($temperature < 0.58)
				{
					// return Biome::SAVANNA;
				}
				else
				{

					return Biome::OCEAN;

				}
			}

			if($rainfall < 0.93)
			{

				return Biome::SWAMP;

			}
			else
			{
				// return Biome::JUNGLE;
			}
		}
	}

	public function recalculate(){
		$this->map = new \SplFixedArray(64 * 64);

		for($i = 0; $i < 64; ++$i){
			for($j = 0; $j < 64; ++$j){
				$this->map[$i + ($j << 6)] = $this->lookup($i / 63, $j / 63);
			}
		}
	}

	public function addBiome(Biome $biome){
		$this->biomes[$biome->getId()] = $biome;
	}

	public function getTemperature($x, $z){
		return ($this->temperature->noise2D($x, $z, true) + 1) / 2;
	}

	public function getRainfall($x, $z){
		return ($this->rainfall->noise2D($x, $z, true) + 1) / 2;
	}

	/**
	 * @param $x
	 * @param $z
	 *
	 * @return Biome
	 */
	public function pickBiome($x, $z){
		$temperature = (int) ($this->getTemperature($x, $z) * 63);
		$rainfall = (int) ($this->getRainfall($x, $z) * 63);

		$biomeId = $this->map[$temperature + ($rainfall << 6)];
		return isset($this->biomes[$biomeId]) ? $this->biomes[$biomeId] : $this->fallback;
	}
}
