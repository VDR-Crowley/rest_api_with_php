<?php
    namespace App\Models;

    use Exception;
    use PDO;

    class User
    {
        private static string $table = 'user';

        protected static function connect(): PDO
        {
            return new PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
        }
        public static function select($value, $column = 'id')
        {
            $sql = sprintf('SELECT * FROM %s WHERE %s = :%s', self::$table, $column, $column);
            $stmt =  self::connect()->prepare($sql);
            $stmt->bindValue(':'.$column, $value);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Nenhum usuário encontrado", 0);
            }
        }

        /**
         * @throws Exception
         */
        public static function selectAll(): false|array
        {
            $sql = 'SELECT * FROM '.self::$table;
            $stmt =  self::connect()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);

            } else {
                throw new Exception("Nenhum usuário encontrado");
            }
        }

        /**
         * @throws Exception
         */
        public static function insert($data): array
        {
            $sql = 'INSERT INTO '.self::$table.' (email, password, name) VALUES (:email, :password, :name)';
            $db = self::connect();
            $stmt =  $db->prepare($sql);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':password', $data['password']);
            $stmt->bindValue(':name', $data['name']);
            $stmt->execute();
            $lastId = $db->lastInsertId();;

            if($stmt->rowCount() > 0) {
                return [
                  'message' => 'Usuário(a) inserido com sucesso!',
                  'id' => $lastId
                ];
            } else {
                throw new Exception("Falha ao inserir usuário(a)");
            }
        }

        /**
         * @throws Exception
         */
        public static function update($id, $data): string
        {
            try {
                self::select($id);
                $sql = "UPDATE user SET name = :name, email = :email WHERE id = :id";
                $stmt = self::connect()->prepare($sql);
                $stmt->bindValue(':name', $data['name']);
                $stmt->bindValue(':email', $data['email']);
                $stmt->bindValue(':id', $id);
                $stmt->execute();

                return 'Usuário(a) foi edito com sucesso!';
            } catch (Exception $error) {
                return "Esse usuário não existe";
            }
        }

        public static function delete(string $id): string
        {
            $sql = "DELETE FROM user WHERE id = :id";
            $stmt = self::connect()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return 'Usuário(a) foi deletado com sucesso!';
        }
    }



