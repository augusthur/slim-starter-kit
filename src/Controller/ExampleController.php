<?php namespace App\Controller;

final class ExampleController extends AbstractController
{
    public function greet($request, $response, $params)
    {
        $name = isset($params['name'])? $params['name']: 'stranger';
        return $this->view->render($response, 'master.twig', [
            'name' => $name
        ]);
    }
    
    public function sendMail($request, $response, $params)
    {
        $this->debugger->addMessage($this->mailer->sendMail('this is a fake email', ['foo@bar.com'], 'fake delivery en developer mode.'));
        return $this->view->render($response, 'master.twig', [
            'name' => 'and watch the sended email.'
        ]);
    }
    
    public function queryDB($request, $response, $params)
    {
        $users = $this->db->table('users')->lists('name');
        $this->debugger->addMessage($this->db->table('users')->find(1));
        $this->debugger->addMessage($this->db->query('App:User')->find(2));
        foreach ($users as $u) {
            $this->debugger->addMessage($u);
        }
        return $this->view->render($response, 'master.twig', [
            'name' => 'and watch the users.'
        ]);
    }
}
