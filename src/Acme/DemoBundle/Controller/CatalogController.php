<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\DemoBundle\Entity\Category;

use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogController extends Controller
{
    /**
     * @Route("/categories", name="_catalog_categories")
     * @Template()
     */
    public function categoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AcmeDemoBundle:Category')
            ->findAll();

        return array(
            'categories' => $categories,
        );
    }

    /**
     * @Route("/catagories/{name}", name="_catalog_category_content")
     * @Template()
     */
    public function categoryContentAction($name)
    {
        $category = $this->getDoctrine()
            ->getRepository('AcmeDemoBundle:Category')
            ->findOneByName($name);

        if (!$category instanceof Category) {
            throw new NotFoundHttpException(sprintf('The category "%s" could not be found.', $name));
        }

        return array(
            'products' => $category->getProducts()
        );
    }
}