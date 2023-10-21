<?php

namespace App\Controllers;


class User extends BaseController
{
    //============================================================================
    # INICIAR LOGIN
    public function login()
    {
        return
            view('/login/login');
    }

    public function cadastroUser()
    {
        return
            view('/login/cadastrar');
    }

    //============================================================================
    # LOGOUT
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    //============================================================================
    #SESSÃO DE LOGIN
    public function recebeDadosLogin()
    {
        //recebe dados do formulário
        $this->usuario = $this->request->getPost()['EMAIL'];
        $this->senha = $this->request->getPost()['SENHA'];
    }

    public function verificarLogin()
    {
        $this->recebeDadosLogin();

        //consulta sql personalizada
        $db      = \Config\Database::connect();
        $builder = $db->table('usuario');
        $builder->select('ID, PESSOA_ID, USUARIO, ATIVO, NIVEL');
        $builder->where('USUARIO', $this->usuario);
        $builder->where('SENHA', $this->senha);
        $builder->where('ATIVO', 1);
        $query = $builder->get()->getResultArray();

        if ($query == false) {
            return redirect()->to('usuario/login?error'); //pesquisar sobre erro   --------------------------------------------------------
        } else {
            session()->set([
                'id' => $query[0]['ID'],
                'usuario' => $query[0]['USUARIO'],
                'pessoa_id' => $query[0]['PESSOA_ID'],
                'nivel' => $query[0]['NIVEL'],
                'ativo' => $query[0]['ATIVO'],
            ]);
        }

        // Redireciona com base no nível
        if (session()->get('nivel') == 1) {
            return redirect()->to('../');
        } elseif (session()->get('nivel') == 2) {
            return redirect()->to('pagina-de-administrador');
        }
        // print_r(session()->get());


    }



    public function esqueceuSenha()
    {
        return view('login/esqueci-senha');
    }

    public function confirmacaoSenha()
    {
        $destinatario = $this->request->getPost('EMAIL');

        $db      = \Config\Database::connect();
        $builder = $db->table('usuario');
        $builder->select('ID, PESSOA_ID, USUARIO, ATIVO, NIVEL');
        $builder->where('USUARIO', $destinatario);
        $query = $builder->get()->getResultArray();

        // echo "<pre>";
        // var_dump($query);

        if ($query == false) {
            return redirect()->to('login/esqueceu-senha?error'); // Redirecione com uma mensagem de erro
        } else {

            // echo '<pre>';
            // var_dump($query);
            $usuarioModel = new \App\Models\User();
    
            $token = bin2hex(random_bytes(32)); // Gere um token único
            $usuarioModel->update($query[0]['ID'], [
                'RECUPERA_SENHA' => $token
            ]);
            

            $resetLink = site_url("reset-senha?token=$token");
          
            $config['mailType']       = 'html';
            
            $email = \Config\Services::email();
            $email->initialize($config);
            $email->setFrom('plannerbymarilia@gmail.com', 'Marilia');
            $email->setTo('lucassuzuki13@gmail.com');
            $email->setSubject('Recuperação de Senha - Planner By Marilia');
            $email->setMessage("Para redefinir sua senha, clique no link a seguir:\n$resetLink");
            
            $email->send();

            echo '<pre>';
            var_dump($email->send());
            if ($email->send()) {
                return redirect()->to('login/esqueceu-senha')->with('mensagem', 'Um e-mail de recuperação foi enviado para o seu endereço de e-mail.');
            } else {
                return redirect()->to('login/esqueceu-senha?error');
            }
        }
    }

}
