<?php
namespace Src\TableGateways;

class UserGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, name, email, photo, user_key
            FROM
                users;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT 
                id, name, email, photo, user_key
            FROM
                users
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function checkUser($name, $user_key)
    {
        $statement = "
            SELECT 
                id, name, email, photo, user_key
            FROM
                users
            WHERE 
                  name = :name
            AND
            	user_key = :user_key

        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $name,
                'user_key'  => $user_key,
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
//            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO users 
                (name, email, photo, user_key)
            VALUES
                (:name, :email, :photo, :user_key);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'email'  => $input['email'],
                'photo' => $input['photo'] ?? null,
                'user_key' => $input['user_key'] ,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE users
            SET 
                name = :name,
                email  = :email,
                photo = :photo,
                user_key = :user_key
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'name' => $input['name'],
                'email'  => $input['email'],
                'photo' => $input['photo'] ?? null,
                'user_key' => $input['user_key'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM users
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findKey($key)
    {
        $statement = "
            SELECT COUNT(*) FROM users where user_key = ?            
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($key));
            $result = $statement->fetchColumn();
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findName($name)
    {
        $statement = "
            SELECT COUNT(*) FROM users where name = ?            
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($name));
            $result = $statement->fetchColumn();
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findEmail($email)
    {
        $statement = "
            SELECT COUNT(*) FROM users where email = ?            
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($email));
            $result = $statement->fetchColumn();
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findAllSort($sortParam) {
        $statement = "
            SELECT 
                id, name, email, photo, user_key
            FROM
                users ORDER BY $sortParam;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}