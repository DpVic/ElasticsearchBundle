<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\Service;

use ONGR\ElasticsearchBundle\Service\Repository;

class RepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data provider for testConstructorException().
     *
     * @return array
     */
    public function getTestConstructorExceptionData()
    {
        return [
            [
                12345,
                'InvalidArgumentException',
            ],
            [
                'Non\Existing\ClassName',
                'InvalidArgumentException',
            ],
        ];
    }

    /**
     * @param $className
     * @param $expectedExceptionMessage
     *
     * @dataProvider getTestConstructorExceptionData()
     */
    public function testConstructorException($className, $expectedExceptionMessage)
    {
        $this->expectException($expectedExceptionMessage);

        new Repository(null, $className);
    }

    /**
     * Tests class getter
     */
    public function testGetRepositoryClass()
    {
        $collector = $this->getMockBuilder('ONGR\ElasticsearchBundle\Mapping\MetadataCollector')
            ->disableOriginalConstructor()
            ->getMock();
        $collector->expects($this->any())->method('getDocumentType')->willReturn('product');
        $manager = $this->getMockBuilder('ONGR\ElasticsearchBundle\Service\Manager')
            ->disableOriginalConstructor()
            ->getMock();
        $manager->expects($this->any())->method('getMetadataCollector')->willReturn($collector);
        $repository = new Repository(
            $manager,
            'ONGR\ElasticsearchBundle\Tests\app\fixture\TestBundle\Document\Product'
        );
        $this->assertEquals(
            'ONGR\ElasticsearchBundle\Tests\app\fixture\TestBundle\Document\Product',
            $repository->getClassName()
        );
    }
}
