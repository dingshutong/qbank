<?php
// src/Acme/StoreBundle/Tests/Entity/ProductRepositoryFunctionalTest.php
namespace WB\QbankBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use WB\QbankBundle\Entity\Classifications;

class QuestionnaireModulesRepositoryFunctionalTest extends KernelTestCase
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

    public function testSearchQuestions()
    {
        $test = $this->em
            ->getRepository('WBQbankBundle:QuestionnaireModuleQuestions')
            ->getQuestionClassificationCodes(58, 966)
        ;

        foreach($test as $q) {
            echo $q->getId() . " " . $q->getDescription() . " " . ($q->getQuestionsRelClassifications()->first() ? $q->getQuestionsRelClassifications()->first()->getSkipValue() : "null") . "\n";
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
