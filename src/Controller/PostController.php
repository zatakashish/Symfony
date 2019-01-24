<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

/*Loaded Later*/
use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PostController extends AbstractController
{
    /**
     * @Route("/posts/", name="View_all_posts")
     */
    public function index(Request $request)
    {
		
		$posts=$this->getDoctrine()->getRepository(Post::class)->findAll();
		
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'PostController','posts'=>$posts
        ]);
    }
    
    
     /**
     * @Route("/create/", name="create_post")
     */
    public function create(Request $request)
    {   /*$post=new Post;
	    $form=$this->createFormBuilder($post)
		->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))		
		->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))		
	    ->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))	
		->add('save',SubmitType::class,array('label'=>'Create Post','attr'=>array('class'=>'btn btn-primary')))
	     ->getForm();
		
		
		/*$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$title=$form['title']->getData();
			$description=$form['description']->getData();
			$category=$form['category']->getData();
			
			$post->setTitle($title);
			$post->setDescription($description);
			$post->setCategory($category);
			
			$em=$this->getDoctrine()->getManager();
			$em->persist($post);
			$em->flush();
			
			
		}*/
		
		
		$post = new Post;
		$form=$this->createFormBuilder($post)
		->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))
		->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))		
		->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))		
		->add('submit', SubmitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:20px')))
				->getForm();
				
		
		
		
		
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$title=$form['title']->getData();
			$description=$form['description']->getData();
			$category=$form['category']->getData();
			
			$post->setTitle($title);
			$post->setDescription($description);
			$post->setCategory($category);
			
			$em=$this->getDoctrine()->getManager();
			$em->persist($post);
			$em->flush();
			
			$this->addFlash('message','Post Created Succesfully ! ');
			
			return $this->redirectToRoute('View_all_posts');
			
		}
		
		
			
			
			
		
		
		
		
		
		
		
		
		
        return $this->render('pages/create.html.twig', [
			'form'=>$form->createView()
            
        ]);
    }
    
    
    
     /**
     * @Route("/view/{id}", name="view_post")
     */
    public function view($id)
    {   
		
		$post=$this->getDoctrine()->getRepository(Post::class)->find($id);
		
		
        return $this->render('pages/view.html.twig', [
            'post' => $post,
        ]);
    }
    
     /**
     * @Route("/edit/{id}", name="update_post")
     */
    public function edit(Request $request,$id)
			
	{ /*
		$post=new Post;
		$data=$this->getDoctrine()->getRepository(Post::class)->find($id);
		$post->setTitle($data->getTitle());
		$post->setCategory($data->getCategory());
		$post->setDescription($data->getDescription());
		
		$form=$this->createFormBuilder($post)
		->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))		
		->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))		
	    ->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))	
		->add('save',SubmitType::class,array('label'=>'Update Post','attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:30px')))
	     ->getForm();
				
		
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			
			
			$title=$form['title']->getData();
			$description=$form['description']->getData();
			$category=$form['category']->getData();
			
			$em=$this->getDoctrine()->getManager();
			$newpost=$em->getRepository(Post::class)->find($id);
			
			$newpost->setTitle($title);
			$newpost->setDescription($description);
			$newpost->setCategory($category);
			
			$em->flush();
			$this->addFlash('message','Post Updated Succesfully');
			
			return $this->redirectToRoute('View_all_posts');
			
			
			
			
		}   */
		
		
		$post= new Post;
		$data=$this->getDoctrine()->getRepository(Post::class)->find($id);
		$post->setTitle($data->getTitle());
		$post->setDescription($data->getDescription());
		$post->setCategory($data->getCategory());
		
		$form=$this->createFormBuilder($post)
		->add('title',TextType::class,array('attr'=>array('class'=>'form-control')))		
		->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))		
	    ->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))	
		->add('save',SubmitType::class,array('label'=>'Update Post','attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:30px')))
	     ->getForm();
		
		
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$title=$form['title']->getData();
			$category=$form['category']->getData();
			$description=$form['description']->getData();
			
			$em=$this->getDoctrine()->getManager();
			$oldpost=$em->getRepository(Post::class)->find($id);
			
			$oldpost->setTitle($title);
			$oldpost->setCategory($category);
			$oldpost->setDescription($description);
			
			$em->flush();
			
			$this->addFlash('message', 'Post Updated Successfully ! ');
			
			return $this->redirectToRoute('View_all_posts');
			
		}

		
	  
		
	
		
      return $this->render('pages/edit.html.twig', [
           'form'=>$form->createView()
      ]);
    }
    
    
     /**
     * @Route("/delete/{id}", name="delete_post")
     */
    public function delete(Request $request,$id)
    {
		$em=$this->getDoctrine()->getManager();
		$post=$em->getRepository(Post::class)->find($id);
		$em->remove($post);
		$em->flush();
		
		$this->addFlash('message', 'Post Deleted Successfully !');
			
			return $this->redirectToRoute('View_all_posts');
		
		
      
    }
    
}
