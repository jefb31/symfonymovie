<?php

	namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);

	/**
     * @Route("/movies", name="movies")
     */
    public function moviesListAction(Request $request)
    {
      $repository = $this->getDoctrine()->getRepository('AppBundle:Movie');
      // find *all* todo items
      $movies = $repository->findAll();
      return $this->render('movies/list.html.twig', array(
        'movies' => $movies,
      ));
    }

    /**
   * Matches /todo_edit/*
   *
   * @Route("/movie_edit/{slug}", name="movie_edit")
   */
   public function editAction($slug, Request $request)
   {
     $movie = $this->getDoctrine()
     ->getRepository('AppBundle:Movie')
     ->find($slug);
     if (!$movie) {
       throw $this->createNotFoundException(
         'No movie found for id '.$slug
       );
     }
     $form = $this->createFormBuilder($movie)
     ->add('title', TextType::class)
     ->add('summary', TextType::class)
     ->add('category', TextType::class)
     ->add('save', SubmitType::class, array('label' => 'Modify Movie'))
     ->getForm();
     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
       $em = $this->getDoctrine()->getManager();
       $em->flush();
       return $this->redirectToRoute('movies');
     }
     return $this->render('movies/form.html.twig', array(
       'form' => $form->createView(),
     ));        
    }
}
?>





