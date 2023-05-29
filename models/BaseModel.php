<?php
    class BaseModel
    {
        private $connection;
        private $rowsAffected;
        private $resultat;
        /**
         * @param {$query} la requete
         * @param {$params} les parametres du requete
         */
        public function __construct()
        {
            $this->connection=new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
            $this->rowsAffected=0;
            $this->resultat=[];
        }
        /**
         * prepare et execute la requete
         */
        public function requete($query, $params=[])
        {
            $statement=$this->connection->prepare($query);
            $statement->execute($params);
            $this->rowsAffected=$statement->rowCount();
            $this->resultat=$statement->fetchAll(PDO::FETCH_ASSOC);;
        }
        /**
         * @return les données de la requete
         */
        public function getResultat():array
        {
            return $this->resultat;
        }
        /**
         * @return le nombre de lignes affectées
         */
        public function getRowsAffected(){
            return $this->rowsAffected;
        }
    }
    