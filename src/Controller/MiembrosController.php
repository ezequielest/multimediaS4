<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use App\Entity\Miembros;

class MiembrosController extends Controller
{

    /**
     * 
     * Matches /miembros
     * 
     * @Route("/miembros", name="miembros_index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        //$miembros = $em->getRepository(Miembros::class)->getAll();

        $miembros = $this->getDoctrine()
            ->getRepository(Miembros::class)
            ->findAll();

        return $this->render('miembros/index.html.twig', array(
            'miembros' => $miembros,
        ));

    }

    /**
     * 
     *  Matches /miembros/*
     * 
     * @Route("/miembros/show", name="miembros_show")
     */
    public function show()
    {
        $em = $this->getDoctrine()->getManager();

        //$miembros = $em->getRepository(Miembros::class)->getAll();

        $miembros = $this->getDoctrine()
            ->getRepository(Miembros::class)
            ->findAll();

        return $this->render('miembros/index.html.twig', array(
            'miembros' => $miembros,
        ));

    }

    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $miembros = new Miembros();

        $form = $this->createFormBuilder($miembros)
        ->add('nombre', TextType::class)
        ->add('apellido', TextType::class)
        ->add('activo', TextType::class)
        ->add('submit', SubmitType::class, array('label' => 'Create Task'))
        ->getForm();

        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            
            $miembros = $form->getData();

           // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($miembros);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute('miembros_index');
            
        } 

        return $this->render('miembros/new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}
