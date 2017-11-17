<?php

    namespace AppBundle\Services;
    use AppBundle\Entity\Comment;
    use AppBundle\Services\EntityService;

    
    class CommentService extends EntityService{
        
        public function newComment($name, $textComment, $date){
            $comment = new Comment();
            $comment->setName($name);
            $comment->setText($textComment);
            $comment->setDate($date);
            
            $this->em->persist($comment);
            $this->em->flush();
        }
        
        public function replyTo($name, $id_parent, $text, $date){
            $comment = new Comment();  
            $comment->setName($name);
            $comment->setIdParent($id_parent);            
            $comment->setText($text);
            $comment->setDate($date);
            
            $this->em->persist($comment);
            $this->em->flush();
            
        }
        
        public function getComments(){
            $repository = $this->em->getRepository('AppBundle:Comment');
            return $repository->getComments();  
        }
         
        public function getParent(){
            $repository = $this->em->getRepository('AppBundle:Comment');
            $result = $repository->getParent();
            return $this->getParentInfo($result);
        }
        
        public function getChildByIdParent($id_parent){
            $repository = $this->em->getRepository('AppBundle:Comment');
            $result = $repository->getChildByIdParent($id_parent);
            return $this->getParentInfo($result);
  
        }
        
        /* 
         * getParentInfo() creates element and child arrays that will be saved in parent_info array
         *          
         */      
        protected function getParentInfo($result){
            $repository = $this->em->getRepository('AppBundle:Comment');
            $element = array();
            foreach ($result as $row){
                $element[$row['c_id']] = array('name' => $row['c_name'], 'text' => $row['c_text'], 
                                               'date' => $row['c_date']);         
            }
            $child = array();
            if(!empty($element)){
                $child = $repository->asChild(array_keys($element));
            }
            $parent_info = array();
            foreach ($element as $id => $row){
                $parent_info[$id]['element'] = $row;
                $parent_info[$id]['child'] = in_array($id, $child);
            }
            return $parent_info;   
        }
        
        
        
    }