<?php
// src/Acme/StoreBundle/Tests/Entity/ProductRepositoryFunctionalTest.php
namespace WB\QbankBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryFunctionalTest extends KernelTestCase
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

    public function testSearchUsers()
    {
        $users = $this->em
            ->getRepository('WBUserBundle:User')
            ->searchUsers('world bank')
        ;

       // $this->assertCount(1, $users);
        foreach($users as $u) {
            echo $u->getId() . " " . $u->getUserName() . "\n";
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