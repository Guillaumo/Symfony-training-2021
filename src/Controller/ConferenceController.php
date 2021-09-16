<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; // class rajoutée
use Twig\Environment;
use App\Entity\Conference;
use App\Entity\Comment;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
        return new Response($twig->render('conference/index.html.twig', [
                      'conferences' => $conferenceRepository->findAll(),
        ]));
    }

    /**
     * @Route("/conference/{id}", name="conference")
     */
    public function show(Request $request, Environment $twig, Conference $conference, CommentRepository $commentRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);
        return new Response($twig->render('conference/show.html.twig', [
            'conference' => $conference,
            // 'comments' => $commentRepository->findBy(['conference' => $conference, 'validated' => 'true'], ['createdAt' => 'DESC']),
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
        ]));
    }

    /**
     * @Route("/conference/{id}/newcomment", name="conference_newcomment")
     */
    public function newComment(Conference $conference, Environment $twig, Request $request, EntityManagerInterface $entityManager):Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class,$comment);
        $form->handleRequest($request); // va prendre toutes les valeurs du formulaire et la méthode POST
        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setConference($conference);
            $comment->setCreatedAt(new \DateTime());
            $comment->setValidated(false);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('conference', ['id' =>$conference->getId()]);
        }
        return new Response ($twig->render('conference/newcomment/newcomment.html.twig',[
            'conference' => $conference,
            'form_comment' => $form->createView()
        ]));
    }

}
