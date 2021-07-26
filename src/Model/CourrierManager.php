<?php

namespace App\Model;

use App\Entity\Agent;
use App\Entity\Courrier;
use App\Entity\TypeCourrier;
use App\Entity\User;
use App\Mapping\CourrierMapping;
use App\Service\BaseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CourrierManager extends BaseManager{
    private $courrierMapping;
    public function __construct(CourrierMapping $courrierMapping,BaseService $baseService, \Swift_Mailer $mailer, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $this->courrierMapping=$courrierMapping;
        parent::__construct($baseService, $mailer, $serializer, $validator, $em);
    }

    public function addCourrier($data){
        $data['agent']=$this->em->getRepository(Agent::class)->find($data['agentId']);
        $data['user']=$this->em->getRepository(User::class)->find($data['userId']);
        $data['typeCourrier']=$this->em->getRepository(TypeCourrier::class)->find($data['typeCourrierId']);
        $courrier=$this->courrierMapping->addCourrier($data);
        if (is_array($courrier)){
            return $courrier;
        }
        $this->em->persist($courrier);
        $this->em->flush();
        return array("code"=>201,"status"=>true,"message"=>"Courrier cree avec succes");

    }

    public function detailsCourrier($id){
        $courrier=$this->em->getRepository(Courrier::class)->find($id);
        if (!$courrier){
            return array("code"=>500,"status"=>false,"message"=>"Courrier inexistant");
        }
        return array("code"=>200,"status"=>true,"data"=>$this->courrierMapping->hydrateCourrier($courrier));
    }
}