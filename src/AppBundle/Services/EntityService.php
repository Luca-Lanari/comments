<?php 

    namespace AppBundle\Services;
    use Doctrine\ORM\EntityManager;

    class EntityService{
        
        protected $em;
        
        public function __construct(EntityManager $em) {
            $this->em = $em;
        }
    }