<?php

namespace App\Serializer;

use App\Entity\RideComparison;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class RideComparisonNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{

    private const ALREADY_CALLED = 'RIDE_COMPARISON_NORMALIZER_ALREADY_CALLED';

    use NormalizerAwareTrait;

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof RideComparison;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $context['groups'][] = 'ride_comparisons_read';
        $context[self::ALREADY_CALLED] = true;

        return $this->normalizer->normalize($object, $format, $context);
    }
}