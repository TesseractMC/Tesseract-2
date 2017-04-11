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

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\normal\biome\extension\OceanBiome;
use pocketmine\level\generator\normal\biome\extension\MesaBiome;
use pocketmine\level\generator\normal\biome\extension\SwampBiome;
use pocketmine\level\generator\normal\biome\extension\BeachBiome;
use pocketmine\level\generator\normal\biome\extension\DesertBiome;
use pocketmine\level\generator\normal\biome\extension\ForestBiome;
use pocketmine\level\generator\normal\biome\extension\IcePlainsBiome;
use pocketmine\level\generator\normal\biome\extension\PlainBiome;
use pocketmine\level\generator\normal\biome\extension\RiverBiome;
use pocketmine\level\generator\normal\biome\extension\TaigaBiome;
use pocketmine\level\generator\nether\biome\HellBiome;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

use pocketmine\level\generator\normal\populator\Flower;

abstract class Biome{

	const OCEAN = 0; // generated
	const PLAINS = 1; // generated
	const DESERT = 2; // generated
	const EXTREME_HILLS = 3; // Mountains, generated
	const FOREST = 4; // generated
	const TAIGA = 5; // generated
	const SWAMPLAND = 6; // generated 
	const RIVER = 7; // generated 
	const HELL = 8; // - NETHER
	const SKY = 9; // - END
	const FROZEN_OCEAN = 10; // not generated
	const FROZEN_RIVER = 11; // generated
	const ICE_FLATS = 12; // Ice Plains, generated
	const ICE_MOUNTAINS = 13; // generated
	const MUSHROOM_ISLAND = 14; // generated
	const MUSHROOM_ISLAND_SHORE = 15; // generated
	const BEACHES = 16; // BEACH, generated
	const DESERT_HILLS = 17; // generated
	const FOREST_HILLS = 18; // generated
	const TAIGA_HILLS = 19; // generated
	const SMALLER_EXTREME_HILLS = 20; // Small Mountains, not generated
	const JUNGLE = 21; // generated
	const JUNGLE_HILLS = 22; // generated
	const JUNGLE_EDGE = 23; // generated
	const DEEP_OCEAN = 24; // generated
	const STONE_BEACH = 25; // generated
	const COLD_BEACH = 26; // Cold - need created file, generated
	const BIRCH_FOREST = 27; // generated
	const BIRCH_FOREST_HILLS = 28; // generated
	const ROOFED_FOREST = 29; // generated
	const TAIGA_COLD = 30; // generated
	const TAIGA_COLD_HILLS = 31; // generated
	const REDWOOD_TAIGA = 32; // generated
	const REDWOOD_TAIGA_HILLS = 33; // generated
	const EXTREME_HILLS_WITH_TREES = 34; // Yes,is correct, generated.
	const SAVANNA = 35; // generated
	const SAVANNA_ROCK = 36; // generated
	const MESA = 37; // generated 
	const MESA_ROCK = 38; // generated
	const MESA_CLEAR_ROCK = 39; // generated
	
	// This biomes isn't generated. Probably FarLands biomes.
	const VOID = 127;
	const UNKNOWN = 128; // ?? - MiNET
	const MUTATED_PLAINS = 129;
	const MUTATED_DESERT = 130;
	const MUTATED_EXTREME_HILLS = 131;
	const MUTATED_FOREST = 132;
	const MUTATED_TAIGA = 133;
	const MUTATED_SWAMPLAND = 134;
	const MUTATED_ICE_FLATS = 140;
	const MUTATED_JUNGLE = 149;
	const UNKNOWN_BIOME = 150; // ?? - MiNET 
	const MUTATED_JUNGLE_EDGE = 151;
	const MUTATED_BIRCH_FOREST = 155;
	const MUTATED_BIRCH_FOREST_HILLS = 156;
	const MUTATED_ROOFED_FOREST = 157;
	const MUTATED_TAIGA_COLD = 158;
	const MUTATED_REDWOOD_TAIGA = 160;
	const MUTATED_REDWOOD_TAIGA_HILLS = 161;
	const MUTATED_EXTREME_HILLS_WITH_TREES = 162;
	const MUTATED_SAVANNA = 163;
	const MUTATED_SAVANNA_ROCK = 164;
	const MUTATED_MESA = 165;
	const MUTATED_MESA_ROCK = 166;
	const MUTATED_MESA_CLEAR_ROCK = 167;

	const MAX_BIOMES = 256; // What is that?!

	/** @var Biome[] */
	private static $biomes = [];

	private $id;
	private $registered = false;
	/** @var Populator[] */
	private $populators = [];

	private $minElevation;
	private $maxElevation;

	private $groundCover = [];

	protected $rainfall;
	protected $temperature;

	protected static function register($id, Biome $biome){
		self::$biomes[(int) $id] = $biome;
		$biome->setId((int) $id);

		$flowerPopFound = false;

		foreach($biome->getPopulators() as $populator){
			if($populator instanceof Flower){
				$flowerPopFound = true;
				break;
			}
		}

		if($flowerPopFound === false){
			$flower = new Flower();
			$biome->addPopulator($flower);
		}
	}

	public static function init(){
		self::register(self::OCEAN, new OceanBiome());
		self::register(self::PLAINS, new PlainBiome());
		self::register(self::DESERT, new DesertBiome());
		self::register(self::FOREST, new ForestBiome());
		self::register(self::TAIGA, new TaigaBiome());
		self::register(self::SWAMPLAND, new SwampBiome());
		self::register(self::RIVER, new RiverBiome());
		self::register(self::BEACHES, new BeachBiome());
		self::register(self::MESA, new MesaBiome());
		self::register(self::ICE_FLATS, new IcePlainsBiome());
		self::register(self::HELL, new HellBiome());
		self::register(self::BIRCH_FOREST, new ForestBiome(ForestBiome::TYPE_BIRCH));
	}

	/**
	 * @param $id
	 *
	 * @return Biome
	 */
	public static function getBiome($id){
		return isset(self::$biomes[$id]) ? self::$biomes[$id] : self::$biomes[self::OCEAN];
	}

	public function clearPopulators(){
		$this->populators = [];
	}

	public function addPopulator(Populator $populator){
		$this->populators[get_class($populator)] = $populator;
	}

	public function removePopulator($class){
		if(isset($this->populators[$class])){
			unset($this->populators[$class]);
		}
	}

	public function populateChunk(ChunkManager $level, $chunkX, $chunkZ, Random $random){
		foreach($this->populators as $populator){
			$populator->populate($level, $chunkX, $chunkZ, $random);
		}
	}

	public function getPopulators(){
		return $this->populators;
	}

	public function setId($id){
		if(!$this->registered){
			$this->registered = true;
			$this->id = $id;
		}
	}

	public function getId(){
		return $this->id;
	}

	public abstract function getName();

	public function getMinElevation(){
		return $this->minElevation;
	}

	public function getMaxElevation(){
		return $this->maxElevation;
	}

	public function setElevation($min, $max){
		$this->minElevation = $min;
		$this->maxElevation = $max;
	}

	/**
	 * @return Block[]
	 */
	public function getGroundCover(){
		return $this->groundCover;
	}

	/**
	 * @param Block[] $covers
	 */
	public function setGroundCover(array $covers){
		$this->groundCover = $covers;
	}

	public float function getTemperature(){
		return $this->temperature;
	}

	public float function getRainfall(){
		return $this->rainfall;
	}
}
