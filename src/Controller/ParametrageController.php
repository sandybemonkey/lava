<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 13/04/2018
 * Time: 09:31.
 */

namespace App\Controller;

use App\Entity\Parametrage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/parametrage", name="parametrage_")
 * @IsGranted("ROLE_ADMIN", statusCode=403, message="Accès Refusé! Vos droits ne sont pas suffisant !")
 */
class ParametrageController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('parametrage/index.html.twig', [
            'parametrages' => $this->getDoctrine()->getRepository(Parametrage::class)->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/change-params", name="change")
     *
     * @param Request     $request
     * @param Parametrage $parametrage
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeParametrage(Request $request, Parametrage $parametrage)
    {
        $parametrage->setValue($request->query->get('value'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($parametrage);
        $em->flush();

        $this->addFlash('success', 'Le parametre à bien été mis à jour.');

        return $this->redirectToRoute('parametrage_index');
    }
}
