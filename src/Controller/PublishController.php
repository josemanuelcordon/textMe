<?php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class MensajeController extends AbstractController
{
    private $publisher;

    public function __construct(HubInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function sendMessage(Request $request, HubInterface $hub): Response
    {
        $currentUser = $this->getUser();
        $destinatarioId = $request->request->get('destinatario_id');
        $mensaje = $request->request->get('mensaje');

        $canalDestinatario = sprintf('user_%s', $destinatarioId);

        $update = new Update(
            sprintf('http://example.com/%s', $canalDestinatario),
            json_encode(['mensaje' => $mensaje])
        );

        $hub->publish($update);

        return new Response("Publicado!");
    }
}