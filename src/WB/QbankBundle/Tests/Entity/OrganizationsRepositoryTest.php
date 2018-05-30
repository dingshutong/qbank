<?php
// src/Acme/StoreBundle/Tests/Entity/ProductRepositoryFunctionalTest.php
namespace WB\QbankBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrganizationsRepositoryFunctionalTest extends KernelTestCase
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

    public function testSearchOrganizations()
    {
        $organizations = $this->em
            ->getRepository('WBQbankBundle:Organizations')
            ->searchOrganizations(false, 'unicef')
        ;

       // $this->assertCount(1, $organizations);
        foreach($organizations as $o) {
            echo $o->getId() . " " . $o->getName() . "\n";
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