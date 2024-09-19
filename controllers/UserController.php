<?php
require_once '../models/User.php';
require_once '../utils/Response.php';
require_once '../utils/Validator.php';

class UserController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
    }

    public function createUser($data) {
        if(!empty($data->username) && !empty($data->email) && !empty($data->password)) {
            if(!Validator::validateEmail($data->email)) {
                return Response::json(400, "Email inválido.");
            }
            if(!Validator::validateLength($data->username, 3, 50)) {
                return Response::json(400, "O nome de usuário deve ter entre 3 e 50 caracteres.");
            }
            
            $this->user->username = Validator::sanitizeString($data->username);
            $this->user->email = Validator::sanitizeString($data->email);
            $this->user->password = $data->password;

            if($this->user->create()) {
                return Response::json(201, "Usuário criado com sucesso.");
            } else {
                return Response::json(503, "Não foi possível criar o usuário.");
            }
        } else {
            return Response::json(400, "Não foi possível criar o usuário. Dados incompletos.");
        }
    }

    public function getUsers($id = null) {
        if($id !== null) {
            $user = $this->user->read($id);
            if($user) {
                return Response::json(200, "Usuário encontrado.", $user);
            } else {
                return Response::json(404, "Usuário não encontrado.");
            }
        } else {
            $users = $this->user->readAll();
            return Response::json(200, "Lista de usuários recuperada com sucesso.", $users);
        }
    }

    public function updateUser($data) {
        if(!empty($data->id) && (!empty($data->username) || !empty($data->email) || !empty($data->password))) {
            $this->user->id = $data->id;
            
            if(!empty($data->username)) {
                if(!Validator::validateLength($data->username, 3, 50)) {
                    return Response::json(400, "O nome de usuário deve ter entre 3 e 50 caracteres.");
                }
                $this->user->username = Validator::sanitizeString($data->username);
            }
            
            if(!empty($data->email)) {
                if(!Validator::validateEmail($data->email)) {
                    return Response::json(400, "Email inválido.");
                }
                $this->user->email = Validator::sanitizeString($data->email);
            }
            
            if(!empty($data->password)) {
                $this->user->password = $data->password;
            }

            if($this->user->update()) {
                return Response::json(200, "Usuário atualizado com sucesso.");
            } else {
                return Response::json(503, "Não foi possível atualizar o usuário.");
            }
        } else {
            return Response::json(400, "Não foi possível atualizar o usuário. Dados incompletos.");
        }
    }

    public function deleteUser($id) {
        if(!empty($id)) {
            $this->user->id = $id;
            if($this->user->delete()) {
                return Response::json(200, "Usuário excluído com sucesso.");
            } else {
                return Response::json(503, "Não foi possível excluir o usuário.");
            }
        } else {
            return Response::json(400, "Não foi possível excluir o usuário. ID não fornecido.");
        }
    }

    public function login($data) {
        if (empty($data->email) || empty($data->password)) {
            return Response::json(400, "Email e senha são obrigatórios");
        }

        $this->user->email = $data->email;
        if ($this->user->emailExists()) {
            if (password_verify($data->password, $this->user->password)) {
                $token = JWTUtil::generateToken($this->user->id);
                return Response::json(200, "Login bem-sucedido", ["token" => $token]);
            } else {
                return Response::json(401, "Senha incorreta");
            }
        } else {
            return Response::json(404, "Usuário não encontrado");
        }
    }
}