<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="product_category")
     */
    public function category($slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(["slug" => $slug]);
        // dd($category);

        if (!$category) {
            // throw new NotFoundHttpException("La catégorie demandée n'existe pas");
            //we can use shotcut that give us AbstractController
            throw $this->createNotFoundException("La catégorie demandée n'existe pas");
        }
        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            'category' => $category
        ]);
    }

    /**
     * @Route("/{category_slug}/{slug}", name="product_show")
     */
    public function show(
        $slug,
        ProductRepository $productRepository
        // , UrlGeneratorInterface $urlGenerator
    ) {
        // dd($urlGenerator->generate('product_category', [
        //     'slug' => 'test-de-slug'
        // ]));
        $product = $productRepository->findOneBy([
            "slug" => $slug
        ]);
        // dd($product->getName());
        if (!$product) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }
        return $this->render('product/show.html.twig', [
            'product' => $product
            // ,
            // 'urlGenerator' => $urlGenerator
        ]);
    }
    /**
     * @Route("/admin/product/create", name="product_create")
     */
    public function create(FormFactoryInterface $factory)
    {
        $builder =   $factory->createBuilder();
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => [
                    // 'class' => 'form-control', 
                    'placeholder' => 'Tapez le nom du produit', 'value'
                ]
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => [
                    // 'class' => 'form-control',
                    'placeholder' => 'Tapez une description assez courte mais parlante pour le visiteur'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit',
                'attr' => [
                    // 'class' => 'form-control',
                    'placeholder' => 'Tepez le prix du produits en €'
                ]
            ])

            // $options = [];

            // foreach ($categoryRepository->findAll() as $category) {
            //     $options[$category->getName()] = $category->getId();
            // }
            // dd($options);

            // // ChoiceType::class, we replace it with EntityType 
            // ->add('category', ChoiceType::class, [
            //     'label' => 'Catégorie',
            //     'attr' => ["class" => 'form-control'],
            //     'placeholder' => '-- Choisir une catégorie --',
            //     'choices' => $options
            // ]);

            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                // 'attr' => ["class" => 'form-control'],
                'placeholder' => '-- Choisir une catégorie --',
                'class' => Category::class,
                // 'choice_label' => 'name' //choice_label is importent key pour modifier affichage
                'choice_label' => function (Category $category) //on va créer un petit function pour modifier le rendu
                {
                    return strtoupper($category->getName()); //pour modifier le opting en majuscule
                }

            ]);
        // $builder->setMethod('GET')
        //     ->setAction('/toto');
        //$form objet est immance alors on extrait just formView de cet objet
        $form = $builder->getForm();

        $formView = $form->createView();

        return $this->render('product/create.html.twig', [
            'formView' => $formView
        ]);
    }
}
