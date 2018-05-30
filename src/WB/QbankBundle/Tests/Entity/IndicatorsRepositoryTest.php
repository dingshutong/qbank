<?php
// src/Acme/StoreBundle/Tests/Entity/ProductRepositoryFunctionalTest.php
namespace WB\QbankBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IndicatorsRepositoryFunctionalTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function testSearchIndicators()
    {
        $indicators = $this->em
            ->getRepository('WBQbankBundle:Indicators')
            ->searchIndicators(false, false, 'ASC', 'agri')
        ;

       // $this->assertCount(1, $indicators);
        foreach($indicators as $i) {
            echo $i->getId() . " " . $i->getName() . "\n";
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}
