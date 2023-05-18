<?php
    class BaseModel
    {
        protected $connection;
        public function __construct()
        {
            $this->connection=new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
        }
        public function requete($query, $params=[])
        {
            $statement=$this->connection->prepare($query);
            $statement->execute($params);
            var_dump($statement->rowCount());
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }