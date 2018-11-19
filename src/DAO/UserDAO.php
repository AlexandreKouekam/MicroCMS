<?php

namespace MicroCMS\DAO;

use Doctrine\DBAL\Connection;
use MicroCMS\Domain\User;

class UserDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Return a list of all users, sorted by date (most recent first).
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from user order by id desc";
        $result = $this->db->fetchAll($sql);

        // Convert query result to an array of domain objects
        $users = array();
        foreach ($result as $row) {
            $userId = $row['art_id'];
            $users[$userId] = $this->buildUser($row);
        }
        return $users;
    }

    /**
     * Creates an User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \MicroCMS\Domain\User
     */
    private function buildUser(array $row) {
        $user = new User();
        $user->setId($row['id']);
        $user->setName($row['name']);
        return $user;
    }
}