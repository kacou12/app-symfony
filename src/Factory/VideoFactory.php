<?php

namespace App\Factory;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Video|Proxy createOne(array $attributes = [])
 * @method static Video[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Video|Proxy find($criteria)
 * @method static Video|Proxy findOrCreate(array $attributes)
 * @method static Video|Proxy first(string $sortedField = 'id')
 * @method static Video|Proxy last(string $sortedField = 'id')
 * @method static Video|Proxy random(array $attributes = [])
 * @method static Video|Proxy randomOrCreate(array $attributes = [])
 * @method static Video[]|Proxy[] all()
 * @method static Video[]|Proxy[] findBy(array $attributes)
 * @method static Video[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Video[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static VideoRepository|RepositoryProxy repository()
 * @method Video|Proxy create($attributes = [])
 */
final class VideoFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
            // 'url' => self::faker()->text(),
            'url' => "https://www.youtube.com/watch?v=0PrtmE0IcoI",
            'content' => self::faker()->text(),
            'author' => self::faker()->name(),
            'title' => self::faker()->title(),
            // 'slug' => self::faker()->text(),
            // 'createdAt' => null, // TODO add DATETIME ORM type manually
            // 'updatedAt' => null, // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Video $video) {})
        ;
    }

    protected static function getClass(): string
    {
        return Video::class;
    }
}
