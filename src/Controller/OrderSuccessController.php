<?php

namespace App\Controller;

use App\Class\Cart;
use App\Class\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	#[Route('/commande/merci/{stripeSessionId}', name: 'order_validate')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
    	$order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

    	if (!$order || $order->getUser() != $this->getUser()) {
    		$this->redirectToRoute('home');
		}

    	if ($order->getState() == 0) {
    		// Vider la session "Cart"
			$cart->remove();
			// Modifier le statut isPaid à 1
			$order->setState(1);
			$this->entityManager->flush();

			// Envoyer un email au client pour confirmer sa commande
			$email = new Mail();
			$content = "Bonjour ".$order->getUser()->getFirstname()."<br>Merci pour votre commande.<br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim illo inventore ipsa necessitatibus quos similique ut velit. Accusamus dolore earum esse, hic, mollitia nostrum possimus quas unde, veritatis voluptas voluptatibus.";
			$email->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande La Boutique Vitaminée est bien validée', $content);
		}
		// Afficher les informations de l'utilisateur
        return $this->render('order_success/index.html.twig', [
        	'order' => $order
		]);
    }
}
