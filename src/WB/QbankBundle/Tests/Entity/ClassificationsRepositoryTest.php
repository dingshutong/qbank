<?php
// src/Acme/StoreBundle/Tests/Entity/ProductRepositoryFunctionalTest.php
namespace WB\QbankBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClassificationsRepositoryFunctionalTest extends KernelTestCase
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

    public function testSearchClassifications()
    {
        $classifications = $this->em
            ->getRepository('WBQbankBundle:Classifications')
            ->searchClassifications("not null", 1, 'marital')
        ;

       // $this->assertCount(1, $classifications);
        foreach($classifications as $c) {
            echo $c->getId() . " " . $c->getName() . "\n";
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