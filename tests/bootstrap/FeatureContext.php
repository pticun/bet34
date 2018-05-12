<?php

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class FeatureContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(
        $kernel,
        EntityManager $em
    ) {
        $this->application = new Application($kernel);
        $this->em = $em;
    }

    /**
     * @When /^I run "([^"]*)" command$/
     */
    public function iRunCommand($name)
    {
        $this->application->setAutoExit(false);

        $input = new ArrayInput(['command' => $name]);

        $output = new NullOutput();
        $this->application->run($input, $output);
    }

    /**
     * @Then the :entity with :property :value should have :otherProperty equal to :expectedValue
     */
    public function theGameShouldHaveproperty($entity, $property, $value, $otherProperty, $expectedValue)
    {
        $sql = sprintf('SELECT %s FROM %s WHERE %s = ? LIMIT 1', $otherProperty, $entity, $property);
        $connection = $this->em->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $value);
        $d = $stmt->execute();
        $d = $stmt->fetch();
        $foundValue = $d[$otherProperty];

        if ($foundValue != $expectedValue) {
            throw new Exception(sprintf('Expected value "%s" for "%s", "%s" found', $expectedValue, $otherProperty, $foundValue));
        }
    }

    /**
     * @Then the last :entity should have :otherProperty equal to :expectedValue
     */
    public function theLastShouldHaveproperty($entity, $otherProperty, $expectedValue)
    {
        $sql = sprintf('SELECT %s FROM %s ORDER BY id DESC LIMIT 1', $otherProperty, $entity);
        $connection = $this->em->getConnection();
        $stmt = $connection->prepare($sql);
        $d = $stmt->execute();
        $d = $stmt->fetch();
        $foundValue = $d[$otherProperty];

        if ($foundValue != $expectedValue) {
            throw new Exception(sprintf('Expected value "%s" for "%s", "%s" found', $expectedValue, $otherProperty, $foundValue));
        }
    }
}
