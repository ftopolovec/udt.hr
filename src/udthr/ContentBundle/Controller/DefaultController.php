<?php

namespace udthr\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use udthr\ContentBundle\Form\ContactType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('udthrContentBundle:Blog')->findAll();

        $form = $this->createForm(new ContactType());

        if ($request->isMethod('POST')) {

            $form->submit($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    //->setSubject($form->get('predmet')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('ftopolovec2@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'udthrContentBundle:Default:kontakt_forma.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'ime' => $form->get('ime')->getData(),
                                'poruka' => $form->get('poruka')->getData(),

                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Uspješno ste poslali email! Hvala Vam!');

                return $this->redirect($this->generateUrl('udthr_content_homepage'));
            }
        }

        return $this->render('udthrContentBundle:Default:index.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView(),
        ));
    }

    public function displayAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('udthrContentBundle:Blog')->find($id);

        return $this->render('udthrContentBundle:Default:display.html.twig', array(
            "blog" => $blog
        ));
    }
}
