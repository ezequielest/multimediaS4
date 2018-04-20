<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Actividades;
use App\Entity\Miembros;

class ActividadesController extends Controller
{

    /**
     * @Route("/actividades", name="actividades_index",methods={"GET","HEAD"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        //$miembros = $em->getRepository(Miembros::class)->getAll();

        $actividades = $this->getDoctrine()
            ->getRepository(Actividades::class)
            ->findAll();

        return $this->render('actividades/index.html.twig', array(
            'actividades' => $actividades,
        ));

    }


    /**
     * @Route("/actividades/show", name="actividades_show",methods={"GET","HEAD"})
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

        $actividades = new Actividades();

        $miembros = $em->getRepository(Miembros::class)->findAll();

        $form = $this->createFormBuilder($actividades)
        ->add('nombre', TextType::class, array(
            'attr'=> array(
                'class'=> 'form-control'
            )
        ))
        ->add('descripcion', TextareaType::class, array(
            'attr' => array(
                'class' => 'tinymce form-control'),
        ))
        ->add('lugar', TextType::class, array(
            'attr'=> array(
                'class' => 'form-control'
            )
        ))
        ->add('fecha', DateTimeType::class, array(
            'placeholder' => array(
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
            ),
        ))
        /*->add('miembros', ChoiceType::class,[
            'choices' => [
                $miembros
            ],
            'choice_label' => function($miembros, $key, $index) {
                return $miembros->getNombre();
            },
            'attr'=> array(
                'class' => 'form-control'
            )

        ])*/
        ->add('submit', SubmitType::class, array(
            'label' => 'Crear actividad',
            'attr'=> array(
                'class' => 'btn btn-primary'
            )
        ))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {      
            

            $actividades = $form->getData();

            //var_dump($_POST['miembros']);
            //die();

            $miembros = $em->getRepository(Miembros::class)->findById($_POST['miembros']);
            
            foreach ($miembros as $miembro){
                $actividades->addMiembro($miembro);
            }

            $em->persist($actividades);

            $em->flush();


            return $this->redirectToRoute('actividades_index');

        }

        return $this->render('actividades/new.html.twig', array(
            'form' => $form->createView(),
            'miembros' => $miembros
        ));

    }

    public function generarListaMultimedia()
    {
        $em = $this->getDoctrine()->getManager();

        $miembros = $em->getRepository(Miembros::class)->findAll();

        return $this->render('actividades/generarListaMultimedia.html.twig', array(
            'miembros' => $miembros
        ));



    }

    /**
     * @Route("/actividades/listaActividadesAjax")
     */
    public function listaActividadesAjax()
    {
        $em = $this->getDoctrine()->getManager();

        /*$actividades = $this->getDoctrine()
            ->getRepository(Actividades::class)
            ->findAll();*/
        $ahora = new \DateTime("now");

        $query = $em->createQuery(
        'SELECT a FROM App\Entity\Actividades a WHERE a.fecha > :ahora ORDER BY a.fecha asc'
        )->setParameter('ahora',$ahora);

        $actividades = $query->getResult();

        $actividadesJson = [];
        foreach($actividades as $key => $actividad){

            //2018-03-15
            $fechas =  $actividad->getFecha()->format('Y-m-d'); 

            $actividadesJson[$actividad->getFecha()->format('Y')][$actividad->getFecha()->format('m')][$key][$actividad->getFecha()->format('d')]['fecha'] = $actividad->getFecha()->format('Y-m-d'); 



            $miembros = $actividad->getMiembros();

            foreach($miembros as $miembro){
                $actividadesJson[$actividad->getFecha()->format('Y')][$actividad->getFecha()->format('m')][$actividad->getFecha()->format('d')]['nombre'] = $miembro->getNombre(); 
            }

        }

        $response = new Response();
    
        $response->setContent(json_encode(array(
            'actividades' => $actividadesJson,
        )));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        
        return $response;

    }




}
