<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActividadesRepository")
 */
class Actividades
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length = 50)
     */
    private $nombre;

    /**
     * @ORM\Column(type="text")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length = 100, nullable=true)
     */
    private $lugar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fecha;
    
    /**
     * @ORM\ManyToMany(targetEntity="Miembros", inversedBy="actividades")
     * @ORM\JoinTable(name="actividades_miembros")
     */
    private $miembros;
    
    public function __construct() {
        $this->miembros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /* GET - SET*/

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getLugar()
    {
        return $this->lugar;
    }

    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getActividades(){
        return 0;
    }
    
    public function getMiembros(){
        return $this->miembros;
    }
    
    public function addMiembro(Miembros $miembros)
    {
        //$miembros->addMiembro($miembros); // synchronously updating inverse side
        $this->miembros[] = $miembros;
    }

}
