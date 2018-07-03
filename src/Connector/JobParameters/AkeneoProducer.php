<?php

namespace Sylake\AkeneoProducerBundle\Connector\JobParameters;

use Akeneo\Component\Batch\Job\JobInterface;
use Akeneo\Component\Batch\Job\JobParameters\ConstraintCollectionProviderInterface;
use Akeneo\Component\Batch\Job\JobParameters\DefaultValuesProviderInterface;

/**
 * Non-final just to make it lazy-loadable.
 */
/* final */ class AkeneoProducer implements ConstraintCollectionProviderInterface, DefaultValuesProviderInterface
{
    /**
     * @var DefaultValuesProviderInterface
     */
    private $baseDefaultValuesProvider;

    /**
     * @var ConstraintCollectionProviderInterface
     */
    private $baseConstraintCollectionProvider;

    /**
     * @var string[]
     */
    private $supportedJobNames;

    /**
     * @var string[]
     */
    private $locales;

    /**
     * @var string
     */
    private $scope;

    /**
     * @param DefaultValuesProviderInterface $baseDefaultValuesProvider
     * @param ConstraintCollectionProviderInterface $baseConstraintCollectionProvider
     * @param string[] $supportedJobNames
     * @param string[] $locales
     * @param string $scope
     */
    public function __construct(
        DefaultValuesProviderInterface $baseDefaultValuesProvider,
        ConstraintCollectionProviderInterface $baseConstraintCollectionProvider,
        array $supportedJobNames,
        array $locales,
        string $scope
    ) {
        $this->baseDefaultValuesProvider = $baseDefaultValuesProvider;
        $this->baseConstraintCollectionProvider = $baseConstraintCollectionProvider;
        $this->supportedJobNames = $supportedJobNames;
        $this->locales = $locales;
        $this->scope = $scope;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValues()
    {
        return array_replace($this->baseDefaultValuesProvider->getDefaultValues(), [
            'with_media' => false,
            'filters' => [
                'data' => [
                    [
                        'field' => 'enabled',
                        'operator' => '=',
                        'value' => true
                    ]
                ],
                'structure' => [
                    'scope' => $this->scope,
                    'locales' => $this->locales
                ],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraintCollection()
    {
        return $this->baseConstraintCollectionProvider->getConstraintCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function supports(JobInterface $job)
    {
        return in_array($job->getName(), $this->supportedJobNames, true);
    }
}
