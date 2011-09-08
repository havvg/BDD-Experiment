<?php

namespace Acme\DemoBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
    Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Feature context.
 */
class FeatureContext extends BehatContext
{
    /**
     * @Given /There is no "([^"]*)" in database/
     */
    public function thereIsNoRecordInDatabase($entityName)
    {
        $entities = $this->getEntityManager()->getRepository('AcmeDemoBundle:'.$entityName)->findAll();
        foreach ($entities as $eachEntity) {
            $this->getEntityManager()->remove($eachEntity);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @Given /I have a category "([^"]*)"/
     */
    public function iHaveACategory($name)
    {
        $category = new \Acme\DemoBundle\Entity\Category();
        $category->setName($name);

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }

    /**
     * @Given /I have a product "([^"]*)"/
     */
    public function iHaveAProduct($name)
    {
        $product = new \Acme\DemoBundle\Entity\Product();
        $product->setName($name);

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     * @When /I add product "([^"]*)" to category "([^"]*)"/
     */
    public function iAddProductToCategory($productName, $categoryName)
    {
        $product = $this->getRepository('AcmeDemoBundle:Product')->findOneByName($productName);
        $category = $this->getRepository('AcmeDemoBundle:Category')->findOneByName($categoryName);

        $category->addProduct($product);

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }

    /**
     * @Then /I should find product "([^"]*)" in category "([^"]*)"/
     */
    public function iShouldFindProductInCategory($productName, $categoryName)
    {
        $category = $this->getRepository('AcmeDemoBundle:Category')->findOneByName($categoryName);

        $found = false;
        foreach ($category->getProducts() as $product) {
            if ($productName === $product->getName()) {
                $found = true;
                break;
            }
        }

        assertTrue($found);
    }

    /**
     * Returns the Doctrine entity manager.
     *
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getEntityManager();
    }

    /**
     * Returns the Doctrine repository manager for a given entity.
     *
     * @param string $entityName The name of the entity.
     *
     * @return Doctrine\ORM\EntityRepository
     */
    protected function getRepository($entityName)
    {
        return $this->getEntityManager()->getRepository($entityName);
    }
}
