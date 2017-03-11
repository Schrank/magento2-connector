<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Test\Unit\Model\ProductExport\ProductAttributeTransformer;

use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\ProductAttributeTransformer\BaseEntityFieldTransformer;

class BaseEntityFieldTransformerTest extends AbstractTransformerTest
{
    protected function setUp()
    {
        $this->subject = new BaseEntityFieldTransformer();
    }

    public function transformationTestDataProvider()
    {
        return [
            [['sku' => 'test-sku'], 'sku', ['sku' => 'test-sku']],
            [['id' => 5], 'id', ['id' => 5]]
        ];
    }
}
