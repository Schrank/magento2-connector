<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export\ProductAttributeTransformer;

use Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface;

class MediaGalleryTransformer implements AttributeTransformerInterface
{
    const IMAGES = 'images';

    /**
     * process
     *
     * @param array $inputData
     * @param array $outputData
     * @param string $key
     *
     * @return array $outputData
     */
    public function process(
        array $inputData,
        array $outputData,
        string $key
    ): array {
        $mediaGalleryData = $inputData[$key];

        if (empty($mediaGalleryData)) {
            $outputData[static::IMAGES] = [];
            return $outputData;
        }

        $mainImage = $this->getMainProductImage($inputData, $key);
        $outputData[static::IMAGES] = $this->prepareImagesData($mediaGalleryData, $mainImage);

        return $outputData;
    }

    private function getMainProductImage(array $productData, string $key): ProductAttributeMediaGalleryEntryInterface
    {
        if (false === array_key_exists($key, $productData)) {
            return null;
        }
        $mainImage = array_reduce($productData[$key], function ($mainImageEntry, $currentEntry) {
            /** @var ProductAttributeMediaGalleryEntryInterface $mainImageEntry */
            /** @var ProductAttributeMediaGalleryEntryInterface $currentEntry */
            return array_search('base', $currentEntry->getTypes()) ? $currentEntry : $mainImageEntry;
        }, null);

        if (null === $mainImage && count($productData[$key])) {
            $mainImage = array_shift($productData[$key]);
        }

        return $mainImage;
    }
    /**
     * @param ProductAttributeMediaGalleryEntryInterface[] $mediaGalleryData
     * @param ProductAttributeMediaGalleryEntryInterface $mainProductImage
     * @return array[]
     */
    private function prepareImagesData(
        array $mediaGalleryData,
        $mainProductImage
    ): array {
        return array_map(function ($image) use ($mainProductImage) {
            /** @var ProductAttributeMediaGalleryEntryInterface $image */
            return [
                'main'  => ($mainProductImage !== null) && $image->getFile() === $mainProductImage->getFile(),
                'label' => $image->getLabel(),
                'file'  => basename($image->getFile()),
            ];
        }, $mediaGalleryData);
    }
}
