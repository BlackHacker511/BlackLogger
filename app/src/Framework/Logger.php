<?php

namespace Framework;

class Logger
{
    /**
     * 
     * @var Database
     */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function saveClientInfo($ip_address)
    {
        $this->db->query("INSERT INTO clients(ip_address, info) SET ip_address = :ip_address, info = :info");

        $this->db->bind(":ip_address", $ip_address);

        $this->db->execute();
    }

    public function collectClientInfo()
    {
    }
}
