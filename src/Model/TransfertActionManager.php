<?php

namespace App\Model;

use App\Entity\SocieteGestionAction;
use App\Entity\TransfertAction;
use App\Mapping\TransfertActionMapping;
use App\Service\BaseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TransfertActionManager extends BaseManager{
    private $transfertActionMapping;

    public function __construct(TransfertActionMapping $transfertActionMapping,BaseService $baseService, \Swift_Mailer $mailer, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        parent::__construct($baseService, $mailer, $serializer, $validator, $em);
        $this->transfertActionMapping=$transfertActionMapping;
    }

    public function addTransfertAction($data){
        $data['societeGestionAction']=isset($data['societeGestionActionId'])?$this->em->getRepository(SocieteGestionAction::class)->find($data['societeGestionActionId']):null;
        $transfertAction=$this->transfertActionMapping->addTransfertAction($data);
        $this->em->persist($transfertAction);
        $this->em->flush();
        return array("code"=>201,"status"=>true,"message"=>"Transfert action créé avec succés");
    }

    public function searchTransfertAction($search){
        $transfertAction=$this->em->getRepository(TransfertAction::class)->searchTransfertAction($search);
        if (!$transfertAction){
            return array("code"=>500,"status"=>false,"message"=>"Transfert action inexistant");
        }
        return array("code"=>200,"status"=>true,"data"=>$this->transfertActionMapping->hydrateTransfertAction($transfertAction[0]));
    }
}