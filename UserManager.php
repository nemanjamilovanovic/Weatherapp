<?php

class UserManager
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * UserManager constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $uid
     * @param $accessToken
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $link
     * @param null $picture
     */
    public function handleGoogleUser($uid, $accessToken, $firstName, $lastName, $email, $link, $picture = null){

        $params = [
            'uid' => $uid,
            'access_token' => $accessToken,
            'firstname' => $firstName,
            'lastname' => $lastName,
            'email' => $email,
            'link' => $link,
            'picture' => $picture,
        ];

        if (!$this->doesGoogleUserExists($uid)) {

            $query = '
            INSERT INTO users (
                oauth_provider,
                oauth_uid, 
                access_token, 
                first_name, 
                last_name, 
                email,
                link,
                picture,
                created,
                modified
            ) 
            
            VALUES 
            (
                "google",
                :uid, 
                :access_token, 
                :firstname, 
                :lastname, 
                :email,
                :link,
                :picture,
                NOW(),
                NOW()  
            )
        ';

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
        }

        else {
            $query = '
            UPDATE 
                users
            SET
                access_token = :access_token, 
                first_name = :firstname, 
                last_name = :lastname, 
                email = :email,
                link = :link,
                picture = :picture,
                modified = NOW()
            WHERE oauth_uid = :uid
        ';

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
        }
    }

    /**
     * @param $uid
     * @return mixed
     */
    protected function doesGoogleUserExists($uid) {
        $query = 'SELECT COUNT(id) as cnt FROM users WHERE oauth_uid=:uid;';

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'uid' => $uid,
        ]);
        $result = $statement->fetch();
        return (bool) $result['cnt'];
    }

    /**
     * @param $uid
     * @return mixed
     */
    public function getAllUsers() {
        $query = 'SELECT * FROM users';

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param $uid
     * @return mixed
     */
    public function getByGoogleId($uid) {
        $query = 'SELECT * FROM users WHERE oauth_uid = :uid';

        $statement = $this->pdo->prepare($query);
        $statement->execute(['uid' => $uid]);

        $data = $statement->fetchAll();

        return $data[0];
    }
}