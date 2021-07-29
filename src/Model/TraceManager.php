<?php

namespace App\Model;

use App\Entity\Operation;
use App\Entity\Trace;
use App\Entity\User;
use App\Mapping\TraceMapping;
use App\Service\BaseService;
use App\Service\ConnectedUserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TraceManager extends BaseManager{
    private $tokenStorage;
    private $traceMapping;
    public function __construct(TraceMapping $traceMapping,TokenStorageInterface $tokenStorage,BaseService $baseService, \Swift_Mailer $mailer, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $this->tokenStorage=$tokenStorage;
        $this->traceMapping=$traceMapping;
        parent::__construct($baseService, $mailer, $serializer, $validator, $em);
    }
    public function addTrace($data){
        $trace=new Trace();
        $trace->setUser(ConnectedUserService::getConnectedUser($this->tokenStorage,$this->em->getRepository(User::class)));
        $trace->setAddresseIp($_SERVER['REMOTE_ADDR']);
        $trace->setOperation(isset($data['operation'])?$this->em->getRepository(Operation::class)->findOneBy(["libelle"=>$data['operation']]):null);
        $this->em->persist($trace);
        $this->em->flush();
    }

    public function getUserTraces($id){
        $traces=$this->em->getRepository(Trace::class)->findBy(["user"=>$id]);
        if (!$traces){
            return array("status"=>false,"code"=>500,"message"=>"Aucune trace pour cet utilisateur");
        }
        return array("status"=>true,"code"=>200,"data"=>$this->traceMapping->hydrateTraces($traces));

    }

    public function getAllTraces($id,$page){
        $limit=getenv('LIMIT');
        $traces=$this->em->getRepository(Trace::class)->findBy([],["id"=>"DESC"],$limit,($page - 1) * $limit);
        if (!$traces){
            return array("status"=>false,"code"=>500,"message"=>"Aucune trace disponible");
        }
        return array("status"=>true,"code"=>200,"data"=>$this->traceMapping->hydrateTraces($traces));

    }
}
