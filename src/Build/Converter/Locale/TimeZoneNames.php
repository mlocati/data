<?php

declare(strict_types=1);

namespace Punic\DataBuilder\Build\Converter\Locale;

use Punic\DataBuilder\Build\Converter\Locale;
use Punic\DataBuilder\Build\SourceData;
use RuntimeException;

class TimeZoneNames extends Locale
{
    public function __construct()
    {
        parent::__construct('main', ['dates', 'timeZoneNames']);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Punic\DataBuilder\Build\Converter\Locale::process()
     */
    protected function process(SourceData $sourceData, array $data, string $localeID): array
    {
        $data = parent::process($sourceData, $data, $localeID);
        foreach (array_keys($data) as $dataKey) {
            switch ($dataKey) {
                case 'gmtFormat':
                case 'gmtZeroFormat':
                case 'regionFormat':
                case 'regionFormat-type-standard':
                case 'regionFormat-type-daylight':
                case 'fallbackFormat':
                    $data[$dataKey] = $this->toPhpSprintf($data[$dataKey]);
                    break;
                case 'hourFormat':
                    break;
                case 'zone':
                case 'metazone':
                    $this->clearEmptyArray($data, $dataKey);
                    break;
                default:
                    throw new RuntimeException("Unknown data key for time zone names: {$dataKey}");
            }
        }

        return $data;
    }
}
