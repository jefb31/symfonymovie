<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilmsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('films/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);

    }



	/**
     * @Route("/films", name="films")
     */
    public function filmsListAction(Request $request)
    {
      $repository = $this->getDoctrine()->getRepository('AppBundle:Films');
      // find *all* todo items
      $films = $repository->findAll();
      return $this->render('films/list.html.twig', array(
        'films' => $films,
      ));
    }

    /**
   * Matches /todo_edit/*
   *
   * @Route("/films_edit/{slug}", name="films_edit")
   */
   public function editAction($slug, Request $request)
   {
     $films = $this->getDoctrine()
     ->getRepository('AppBundle:Films')
     ->find($slug);
     if (!$films) {
       throw $this->createNotFoundException(
         'No movie found for id '.$slug
       );
     }
     $form = $this->createFormBuilder($films)
     ->add('title', TextType::class)
     ->add('summary', TextType::class)
     ->add('category', TextType::class)
     ->add('save', SubmitType::class, array('label' => 'Modify Movie'))
     ->getForm();
     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
       $em = $this->getDoctrine()->getManager();
       $em->flush();
       return $this->redirectToRoute('films');
     }
     return $this->render('films/form.html.twig', array(
       'form' => $form->createView(),
     ));
    }
}
?>
