<?php

    namespace AppBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    
    class IndexController extends Controller {
        
        protected $request;
        
        public function __construct(){
            $request = Request::createFromGlobals(); //utilizzato per le $_POST in symfony
            $this->request = $request;
        }
        
        
        public function showIndexAction() {
            $commentService = $this->get('app.commentService');
            $parent_info = $commentService->getParent();
            return $this->render('comments_view/index.html.twig', array('parent_info' => $parent_info));
        }
             
        public function newCommentAction(){ 
            $name = $this->request->request->get('name');
            $textComment = $this->request->request->get('txtComment');
            $date = new \DateTime();
            $commentService = $this->get('app.commentService');
            $commentService->newComment($name, $textComment, $date);
            return $this->redirect('/');
        }
        
        public function replyCommentAction($id_parent){
            $name = $this->request->request->get('name');
            $textReplyComment = $this->request->request->get('txtReplyComment');
            $date = new \DateTime();
            $commentService = $this->get('app.commentService');
            $commentService->replyTo($name, $id_parent, $textReplyComment, $date);
            return $this->redirect('/');
        }
        
        public function getRepliesAction(){
            $id = $this->request->request->get('id');
            $commentService = $this->get('app.commentService');
            $commentsChild = $commentService->getChildByIdParent($id);
            return new JsonResponse($commentsChild);     
        }
    }