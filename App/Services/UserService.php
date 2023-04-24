<?php
    namespace App\Services;

    use App\Models\User;
    use Exception;
    use http\Client\Request;

    class UserService
    {
        /**
         * @throws Exception
         */
        public function get($id = null)
        {
            if(isset($id)) {
                return User::select($id);
            } else {
                return User::selectAll($id);
            }
        }

        /**
         * @throws Exception
         */
        public function post(): string
        {
            $message = $this->validateInfos($_POST, 'POST');
            if($message === 'success') {
                return User::insert($_POST);
            }
            return $message;
        }

        public function isValidPassword($password): bool
        {
            $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z\d].\S{8,36}$/';
            return (bool)preg_match($pattern, $password);
        }

        /**
         * @throws Exception
         */
        public function put($id = null): string
        {
            $_PUT = $this->parseInput();
            $message = $this->validateInfos($_PUT, 'PUT');
            if($message === 'success') {
                return User::update($id, $_PUT);
            }
            return $message;
        }

        function parseInput(): array
        {
            $data = file_get_contents("php://input");
            if(!$data) return array();
            parse_str($data, $result);
            return $result;
        }

        public function delete(string $id = null): string
        {
            if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
                parse_str(file_get_contents('php://input'), $_DELETE);
            }
            return User::delete($id);
        }

        /**
         * @throws Exception
         */
        public function validateInfos($data, $method = null): string
        {
            if (empty($data['email'])) {
                throw new Exception('O e-mail é um campo obrigatorio');
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('O e-mail enviado não é valido');
            }

            if (empty($data['password']) && $method === 'POST') {
                throw new Exception('A senha é um campo obrigatorio');
            }

            if(!empty($data['password']) && !$this->isValidPassword($data['password'])) {
                throw new Exception('Defina uma senha forte.');
            }

            if (empty($data['name'])) {
                throw new Exception('O nome é um campo obrigatorio');
            }

            return 'success';
        }

    }