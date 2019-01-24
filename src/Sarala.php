<?php

declare(strict_types=1);

namespace Sarala;

use League\Fractal\Serializer\DataArraySerializer;

class Sarala
{
    private static $instance;

    private $handlers;

    private $handler;

    private $supportedMediaTypes;

    private function __construct()
    {
        $this->handlers = collect(config('sarala.handlers'));

        $this->handler = $this->handlers
            ->where('media_type', request()->header('Accept'))
            ->first();

        $this->supportedMediaTypes = $this->handlers
            ->pluck('media_type')
            ->all();
    }

    public static function resolve(): self
    {
        if (! isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getSerializer()
    {
        $serializer = is_null($this->handler) ? DataArraySerializer::class : $this->handler['serializer'];

        return app()->make($serializer);
    }

    public function getSupportedMediaTypes()
    {
        return $this->supportedMediaTypes;
    }
}