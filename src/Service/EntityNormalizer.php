<?php

namespace App\Service;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class EntityNormalizer {

    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    public function normalize($entities, array $attributes) {
        return $this->serializer->normalize($entities, null, [AbstractNormalizer::ATTRIBUTES => $attributes]);
    }
}